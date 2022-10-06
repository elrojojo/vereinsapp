<?php
class Mitglieder_model extends CI_Model {

  public function __construct() {
    parent::__construct();

    if( !isset( $this->session->mitglieder_sortieren ) OR empty( $this->session->mitglieder_sortieren ) )
      $this->session->mitglieder_sortieren = array_values( array( array( 'kategorie' => 'nachname', 'richtung' => SORT_ASC ) ) );
  }

  //------------------------------------------------------------------------------------------------------------------
  public function mitglieder( $id = NULL, $parameter = array(), $sortieren = NULL ) {
    if( is_null($sortieren) ) $sortieren = $this->session->mitglieder_sortieren;
    $parameter_standard = array(
      'archiv' => 0,
    );

    if ( !is_null($id) ) {
      $mitglied = $this->db->get_where( 'mitglieder', array( 'id' => intval($id) ) )->row_array();
      if ( is_null( $mitglied ) ) return array(); else {

        $mitglied['geburtstag'] = strtotime( date('d', intval($mitglied['geburt']) ).'.'.date('m', intval($mitglied['geburt']) ).'.'.date('Y').' 00:00:00' );
        /*filter*/ if( array_key_exists( 'geburtstag', $parameter ) AND !( intval($mitglied['geburtstag']) >= intval($parameter['geburtstag']['start']) AND intval($mitglied['geburtstag']) <= intval($parameter['geburtstag']['ende']) ) ) return array();

        $mitglied['alter_exakt'] = ( time() - intval($mitglied['geburt']) ) / SEK_PRO_JAHR;
        /*filter*/ if( array_key_exists( 'alter_exakt', $parameter ) AND !( intval($mitglied['alter_exakt']) >= intval($parameter['alter_exakt']['start']) AND intval($mitglied['alter_exakt']) <= intval($parameter['alter_exakt']['ende']) ) ) return array();

        $mitglied['alter'] = floor( ( time() - intval($mitglied['geburt']) ) / SEK_PRO_JAHR );
        /*filter*/ if( array_key_exists( 'alter', $parameter ) AND !( intval($mitglied['alter']) >= intval($parameter['alter']['start']) AND intval($mitglied['alter']) <= intval($parameter['alter']['ende']) ) ) return array();

        if( empty($mitglied['rechte']) ) $mitglied['rechte'] = array(); else $mitglied['rechte'] = explode( ' ', $mitglied['rechte'] ); $mitglied['rechte_db'] = $mitglied['rechte'];
        foreach( $this->mitglieder_vertretungen( NULL, array( 'vertretung_id' => $mitglied['id'] ) ) as $vertretung ){
          if( !in_array( $vertretung['recht'], $mitglied['rechte_db'] ) ) $mitglied['rechte'][] = $vertretung['recht'];
        }
        if( is_null($mitglied['login_erlaubt']) ) $mitglied['login_erlaubt'] = NULL; elseif( empty($mitglied['login_erlaubt']) ) $mitglied['login_erlaubt'] = array(); else $mitglied['login_erlaubt'] = explode( ' ', $mitglied['login_erlaubt'] );

        return $mitglied;
      }
    }
    else {
      /*filter*/  if( !array_key_exists( 'archiv', $parameter ) ) $parameter['archiv'] = $parameter_standard['archiv']; elseif( is_null( $parameter['archiv'] ) ) unset( $parameter[ 'archiv' ] );
      foreach( $parameter as $kategorie => $filter )
        if( in_array( $kategorie, MITGLIEDER_KATEGORIEN_DB ) ) {
          if( is_array( $filter ) ) $this->db->where_in( $kategorie, $filter ); else $this->db->where( $kategorie, $filter );
          unset( $parameter[ $kategorie ] );
        }
      $mitglieder_ids = verfuegbare_werte_in_spalte( array_column( $this->db->get( 'mitglieder' )->result_array(), 'id' ), FALSE );
      $mitglieder = array(); foreach( $mitglieder_ids as $mitglieder_id ) {
        $mitglied = $this->mitglieder( $mitglieder_id, $parameter );
        if( !empty($mitglied) ) $mitglieder[ $mitglieder_id ] = $mitglied;
      }
      return tabelle_sortieren( $mitglieder, $sortieren );
    }
  }

  public function mitglied_db_aktualisieren( $mitglied ) {
    if( isset($mitglied['geburtstag']) ) unset( $mitglied['geburtstag'] );
    if( isset($mitglied['alter']) ) unset( $mitglied['alter'] );
    if( isset($mitglied['alter_exakt']) ) unset( $mitglied['alter_exakt'] );
    if( isset($mitglied['rechte_db']) ) { $mitglied['rechte'] = implode ( ' ', $mitglied['rechte_db'] ); unset( $mitglied['rechte_db'] ); }
    if( isset($mitglied['login_erlaubt']) AND !is_null($mitglied['login_erlaubt']) ) $mitglied['login_erlaubt'] = implode ( ' ', $mitglied['login_erlaubt'] );
    if( isset($mitglied['archiv']) AND $mitglied['archiv'] > 0 ) {  // Mitglied wird ausgetragen
      $this->mitglieder_abwesenheit_austragen( $mitglied['id'] );
      $this->mitglieder_vertretung_austragen( $mitglied['id'] );
      $this->db->delete( 'mitglieder_dauerhaft_angemeldet', array( 'mitglied_id' => $mitglied['id'] ) );
      $this->db->delete( 'mitglieder_einstellungen', array( 'mitglied_id' => $mitglied['id'] ) );
      // in Termine Anwesenheiten geprüft
      // in Termine Rückmeldungen geprüft
    }
    return $this->db->update('mitglieder', sql_sicherheitscheck( $mitglied ), array( 'id' => $mitglied['id'] ) );
  }

  public function mitglied_eintragen( $mitglied ) {
    return $this->db->insert( 'mitglieder', sql_sicherheitscheck( $mitglied ) );
  }

  //------------------------------------------------------------------------------------------------------------------
  public function mitglieder_abwesenheiten( $id = NULL, $parameter = array(), $sortierung = 'start') {
    if ( !is_null($id) ) {
      $mitglieder_abwesenheit = $this->db->get_where( 'mitglieder_abwesenheiten', array( 'id' => intval($id) ) )->row_array();
      if ( is_null( $mitglieder_abwesenheit ) ) return array(); else return $mitglieder_abwesenheit;
    }
    else {
      foreach( $parameter as $kategorie => $filter )
        if( in_array( $kategorie, array( 'mitglied_id', 'start>=', 'start<=', 'ende>=', 'ende<=', ) ) ) {
          if( is_array( $filter ) ) $this->db->where_in( $kategorie, $filter ); else $this->db->where( $kategorie, $filter );
          unset( $parameter[ $kategorie ] );
        }
      $mitglieder_abwesenheiten_ids = verfuegbare_werte_in_spalte( array_column( $this->db->get( 'mitglieder_abwesenheiten' )->result_array(), 'id' ), FALSE );
      $mitglieder_abwesenheiten = array(); foreach( $mitglieder_abwesenheiten_ids as $mitglieder_abwesenheiten_id ) {
        $mitglieder_abwesenheit = $this->mitglieder_abwesenheiten( $mitglieder_abwesenheiten_id );
        if( array_intersect_assoc( $parameter, $mitglieder_abwesenheit ) == $parameter ) $mitglieder_abwesenheiten[ $mitglieder_abwesenheiten_id ] = $mitglieder_abwesenheit;
      }
      return tabelle_sortieren( $mitglieder_abwesenheiten, $sortierung );
    }
  }

  public function mitglieder_abwesenheit_eintragen( $abwesenheit ) {
    return $this->db->insert( 'mitglieder_abwesenheiten', sql_sicherheitscheck( $abwesenheit ) );
  }

  public function mitglieder_abwesenheit_austragen( $id ) {
    return $this->db->delete( 'mitglieder_abwesenheiten', array( 'id' => intval($id) ) );
  }

  //------------------------------------------------------------------------------------------------------------------
  public function mitglieder_vertretungen( $id = NULL, $parameter = array(), $sortierung = 'zeitpunkt') {
    if ( !is_null($id) ) {
      $mitglieder_vertretung = $this->db->get_where( 'mitglieder_vertretungen', array( 'id' => intval($id) ) )->row_array();
      if ( is_null( $mitglieder_vertretung ) ) return array(); else return $mitglieder_vertretung;
    }
    else {
      foreach( $parameter as $kategorie => $filter )
        if( in_array( $kategorie, array( 'mitglied_id', 'vertretung_id', 'recht', ) ) ) {
          if( is_array( $filter ) ) $this->db->where_in( $kategorie, $filter ); else $this->db->where( $kategorie, $filter );
          unset( $parameter[ $kategorie ] );
        }
      $mitglieder_vertretungen_ids = verfuegbare_werte_in_spalte( array_column( $this->db->get( 'mitglieder_vertretungen' )->result_array(), 'id' ), FALSE );
      $mitglieder_vertretungen = array(); foreach( $mitglieder_vertretungen_ids as $mitglieder_vertretungen_id ) {
        $mitglieder_vertretung = $this->mitglieder_vertretungen( $mitglieder_vertretungen_id );
        if( array_intersect_assoc( $parameter, $mitglieder_vertretung ) == $parameter ) $mitglieder_vertretungen[ $mitglieder_vertretungen_id ] = $mitglieder_vertretung;
      }
      return tabelle_sortieren( $mitglieder_vertretungen, $sortierung );
    }
  }

  public function mitglieder_vertretung_eintragen( $vertretung ) {
    $this->db->delete( 'mitglieder_vertretungen', array( 'mitglied_id' => intval($vertretung['mitglied_id']), 'vertretung_id' => intval($vertretung['vertretung_id']), 'recht' => $vertretung['recht'] ) );
    return $this->db->insert( 'mitglieder_vertretungen', sql_sicherheitscheck( $vertretung ) );
  }

  public function mitglieder_vertretung_austragen( $id ) {
    return $this->db->delete( 'mitglieder_vertretungen', array( 'id' => intval($id) ) );
  }

  //------------------------------------------------------------------------------------------------------------------
  public function mitglieder_dauerhaft_angemeldet( $id = NULL, $parameter = array(), $sortierung = 'zeitpunkt') {
    if ( !is_null($id) ) {
      $mitglieder_dauerhaft_angemeldet_eintrag = $this->db->get_where( 'mitglieder_dauerhaft_angemeldet', array( 'id' => intval($id) ) )->row_array();
      if ( is_null( $mitglieder_dauerhaft_angemeldet_eintrag ) ) return array(); else return $mitglieder_dauerhaft_angemeldet_eintrag;
    }
    else {
      foreach( $parameter as $kategorie => $filter )
        if( in_array( $kategorie, array( 'mitglied_id', 'identifier', 'securitytoken', ) ) ) {
          if( is_array( $filter ) ) $this->db->where_in( $kategorie, $filter ); else $this->db->where( $kategorie, $filter );
          unset( $parameter[ $kategorie ] );
        }
      $mitglieder_dauerhaft_angemeldet_ids = verfuegbare_werte_in_spalte( array_column( $this->db->get( 'mitglieder_dauerhaft_angemeldet' )->result_array(), 'id' ), FALSE );
      $mitglieder_dauerhaft_angemeldet = array(); foreach( $mitglieder_dauerhaft_angemeldet_ids as $mitglieder_dauerhaft_angemeldet_id ) {
        $mitglieder_dauerhaft_angemeldet_eintrag = $this->mitglieder_dauerhaft_angemeldet( $mitglieder_dauerhaft_angemeldet_id );
        if( array_intersect_assoc( $parameter, $mitglieder_dauerhaft_angemeldet_eintrag ) == $parameter ) $mitglieder_dauerhaft_angemeldet[ $mitglieder_dauerhaft_angemeldet_id ] = $mitglieder_dauerhaft_angemeldet_eintrag;
      }
      return tabelle_sortieren( $mitglieder_dauerhaft_angemeldet, $sortierung );
    }
  }

  public function mitglieder_dauerhaft_angemeldet_eintragen( $dauerhaft_angemeldet ) {
    $this->db->delete( 'mitglieder_dauerhaft_angemeldet', array( 'identifier' => $dauerhaft_angemeldet['identifier'], ) );
    return $this->db->insert( 'mitglieder_dauerhaft_angemeldet', sql_sicherheitscheck( $dauerhaft_angemeldet ) );
  }

  public function mitglieder_dauerhaft_angemeldet_austragen( $identifier ) {
    return $this->db->delete( 'mitglieder_dauerhaft_angemeldet', array( 'identifier' => intval($identifier) ) );
  }

}
