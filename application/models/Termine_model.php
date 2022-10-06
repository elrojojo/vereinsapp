<?php
class Termine_model extends CI_Model {

  public function __construct() {
    parent::__construct();

    if( !isset( $this->session->termine_sortieren ) OR empty( $this->session->termine_sortieren ) )
      $this->session->termine_sortieren = array_values( array( array( 'kategorie' => $this->einstellungen_model->standard_einstellung( 'termine', 'sortieren_nach', ICH['id'] ), 'richtung' => SORT_ASC ) ) );
  }

  //------------------------------------------------------------------------------------------------------------------
  public function termine( $id = NULL, $parameter = array(), $sortieren = NULL ) {
    if( is_null($sortieren) ) $sortieren = $this->session->termine_sortieren;
    $parameter_standard = array(
      'archiv' => 0,
      'vergangen' => boolval( $this->einstellungen_model->standard_einstellung( 'termine', 'vergangen_anzeigen', ICH['id'] ) ),
      'ich_beschr' => boolval( $this->einstellungen_model->standard_einstellung( 'termine', 'ich_beschr_anzeigen', ICH['id'] ) ),
    );

    if ( !is_null($id) ) {
      $termin = $this->db->get_where( 'termine', array( 'id' => intval($id) ) )->row_array();
      if ( is_null( $termin ) ) return array(); else {
        if( empty($termin['setlist']) ) $termin['setlist'] = array(); else $termin['setlist'] = explode( ' ', $termin['setlist'] );
        if( is_null( $termin['beschr_mitglieder'] ) OR empty($termin['beschr_mitglieder']) OR $termin['beschr_mitglieder'] == 'null' ) $termin['beschr_mitglieder'] = VORGEGEBENE_WERTE['termine']['typ'][ $termin['typ'] ]['beschr_mitglieder_standard'];
        else $termin['beschr_mitglieder'] = json_decode( str_replace( '&quot;', '"', $termin['beschr_mitglieder'] ), TRUE );
        $termin['ich_beschr'] = FALSE; if( is_array($termin['beschr_mitglieder']) ) foreach( $termin['beschr_mitglieder'] as $beschr_kategorie => $beschr_werte )
          if( in_array( ICH[ $beschr_kategorie ], $beschr_werte ) ) $termin['ich_beschr'] = TRUE;
        /*filter*/  if( !array_key_exists( 'ich_beschr', $parameter ) ) { if( !$parameter_standard['ich_beschr'] AND $termin['ich_beschr'] ) return array(); }
        /*filter*/  elseif( is_null( $parameter['ich_beschr'] ) ) return $termin; elseif( $parameter['ich_beschr'] != $termin['ich_beschr'] ) return array();
        return $termin;
      }
    }
    else {
      /*filter*/  if( !array_key_exists( 'archiv', $parameter ) ) $parameter['archiv'] = $parameter_standard['archiv']; elseif( is_null( $parameter['archiv'] ) ) unset( $parameter[ 'archiv' ] );
      /*filter*/  if( !array_key_exists( 'vergangen', $parameter ) ) { if( !$parameter_standard['vergangen'] ) $parameter['start>='] = HEUTE; }
      /*filter*/    elseif( is_null( $parameter['vergangen'] ) ) { TRUE; } elseif( $parameter['vergangen'] ) $parameter['start<='] = HEUTE-1; else $parameter['start>='] = HEUTE;
      foreach( $parameter as $kategorie => $filter )
        if( in_array( $kategorie, TERMINE_KATEGORIEN_DB ) ) {
          if( is_array( $filter ) ) $this->db->where_in( $kategorie, $filter ); else $this->db->where( $kategorie, $filter );
          unset( $parameter[ $kategorie ] );
        }
      $termine_ids = verfuegbare_werte_in_spalte( array_column( $this->db->get( 'termine' )->result_array(), 'id' ), FALSE );
      $termine = array(); foreach( $termine_ids as $termine_id ) {
        $termin = $this->termine( $termine_id, $parameter );
        if( !empty($termin) ) $termine[ $termine_id ] = $termin;
      }
      return tabelle_sortieren( $termine, $sortieren );
    }
  }

  public function termin_db_aktualisieren( $termin ) {
    if( isset($termin['ich_beschr']) ) unset($termin['ich_beschr']);
    if( isset($termin['beschr_mitglieder']) ) $termin['beschr_mitglieder'] = json_encode( $termin['beschr_mitglieder'] );
    if( isset($termin['setlist']) ) $termin['setlist'] = implode ( ' ', $termin['setlist'] );
    if( isset($termin['archiv']) AND $termin['archiv'] > 0 ) {  // Termin wird ausgetragen
      // in Termine Anwesenheiten geprüft
      // in Termine Rückmeldungen geprüft
    }
    return $this->db->update( 'termine', sql_sicherheitscheck( $termin ), array( 'id' => $termin['id'] ) );
  }

  public function termin_eintragen( $termin ) {
    if( isset($termin['beschr_mitglieder']) ) $termin['beschr_mitglieder'] = json_encode( $termin['beschr_mitglieder'] );
    return $this->db->insert( 'termine', sql_sicherheitscheck( $termin ) );
  }

  public function alle_termine( $id = NULL ) {
    return $this->termine( $id, array( 'vergangen' => NULL, 'ich_beschr' => NULL, ), $this->session->termine_sortieren );
  }

  //------------------------------------------------------------------------------------------------------------------
  public function termine_rueckmeldungen( $id = NULL, $parameter = array(), $sortierung = 'zeitpunkt') {
    if ( !is_null($id) ) {
      $rueckmeldung = $this->db->get_where( 'termine_rueckmeldungen', array( 'id' => intval($id) ) )->row_array();
      if ( is_null( $rueckmeldung ) ) return array(); else {
          foreach( $this->alle_termine( intval($rueckmeldung['termin_id']) )['beschr_mitglieder'] as $beschr_kategorie => $beschr_werte )
            if( array_key_exists( intval($rueckmeldung['mitglied_id']), MITGLIEDER ) AND in_array( MITGLIEDER[ intval($rueckmeldung['mitglied_id']) ][ $beschr_kategorie ], $beschr_werte ) ) return array();
        return $rueckmeldung;
      }
    }
    else {
      $db_parameter = array(); foreach( $parameter as $kategorie => $filter )
        if( in_array( $kategorie, array( 'termin_id', 'status>=', 'status<=', 'mitglied_id' ) ) ) {
          if( is_array( $filter ) ) $this->db->where_in( $kategorie, $filter ); else $this->db->where( $kategorie, $filter );
          $db_parameter[ $kategorie ] = $filter;
        }
      $rueckmeldungen_ids = verfuegbare_werte_in_spalte( array_column( $this->db->get( 'termine_rueckmeldungen' )->result_array(), 'id' ), FALSE );
      $rueckmeldungen = array(); foreach( $rueckmeldungen_ids as $rueckmeldungen_id ) {
        $rueckmeldung = $this->termine_rueckmeldungen( $rueckmeldungen_id );
        if( !empty($rueckmeldung) ) {
          $abwesenheiten = $this->mitglieder_model->mitglieder_abwesenheiten( NULL, array( // Abwesenheiten prüfen
            'mitglied_id' => $rueckmeldung['mitglied_id'],
            'start<=' => $this->alle_termine( intval($rueckmeldung['termin_id']) )['start'],
            'ende>=' => $this->alle_termine( intval($rueckmeldung['termin_id']) )['start'],
          ) );
          if( empty( $abwesenheiten ) AND array_intersect_assoc( $parameter, $rueckmeldung ) == $parameter ) $rueckmeldungen[ $rueckmeldungen_id ] = $rueckmeldung;
        }
      }
      
      $abwesenheiten_parameter = array();                                               // Abwesenheiten ergänzen
      if( array_key_exists( 'mitglied_id', $db_parameter ) )
        $abwesenheiten_parameter['mitglied_id'] = $db_parameter['mitglied_id'];
      if( array_key_exists( 'termin_id', $db_parameter ) ) {
        $abwesenheiten_parameter['start<='] = $this->alle_termine( intval($db_parameter['termin_id']) )['start'];
        $abwesenheiten_parameter['ende>='] = $this->alle_termine( intval($db_parameter['termin_id']) )['start'];
        $termine = array(); $termine[] = $this->alle_termine( intval($db_parameter['termin_id']) );
      }
      
      $abwesenheiten = $this->mitglieder_model->mitglieder_abwesenheiten( NULL, $abwesenheiten_parameter );
      foreach( $abwesenheiten as $abwesenheit ) {
        if( empty($termine) ) $termine = $this->alle_termine( NULL, $parameter = array( 'start>=' => $abwesenheit['start'], 'start<=' => $abwesenheit['ende'] ) );
        foreach( $termine as $termin ){

          if( !isset($abwesenheit['bemerkung']) OR empty($abwesenheit['bemerkung']) ) $bemerkung = 'Automatische Absage'; else $bemerkung = $abwesenheit['bemerkung']; $bemerkung = SYMBOLE['abwesend']['html'].' '.$bemerkung;

          $mitglied_beschr = FALSE; foreach( $termin['beschr_mitglieder'] as $beschr_kategorie => $beschr_werte ) if( in_array( MITGLIEDER[ intval($abwesenheit['mitglied_id']) ][ $beschr_kategorie ], $beschr_werte ) ) $mitglied_beschr = TRUE;
          
          if( !$mitglied_beschr ) $rueckmeldungen[ intval(array_key_last( $rueckmeldungen ))+1 ] = array(
            'id' => intval(array_key_last( $rueckmeldungen ))+1,
            'zeitpunkt' => $abwesenheit['zeitpunkt'],
            'termin_id' => $termin['id'],
            'status' => 0,
            'mitglied_id' => $abwesenheit['mitglied_id'],
            'bemerkung' => $bemerkung,
          );
        }
      }
      
      return tabelle_sortieren( $rueckmeldungen, $sortierung );
    }
  }

  public function termine_rueckmeldung_db_aktualisieren( $rueckmeldung ) {
    return $this->db->update( 'termine_rueckmeldungen', sql_sicherheitscheck( $rueckmeldung ), array( 'id' => $rueckmeldung['id'] ) );
  }

  public function termine_rueckmeldung_machen( $rueckmeldung ) {
    $this->db->delete( 'termine_rueckmeldungen', array( 'termin_id' => intval($rueckmeldung['termin_id']), 'mitglied_id' => intval($rueckmeldung['mitglied_id']) ) );
    return $this->db->insert( 'termine_rueckmeldungen', sql_sicherheitscheck( $rueckmeldung ) );
  }

  public function termine_rueckmeldungen_cluster( $wert = NULL, $kategorie, $rueckmeldungen = NULL, $mitglieder = NULL ) {
    if ( !is_null($wert) ) {
      $wert_cluster = array( 'zusagen' => array(), 'absagen' => array(), 'mitglieder_ausstehend' => $mitglieder );
      foreach( $rueckmeldungen as $rueckmeldung ) {
        if( array_key_exists( intval($rueckmeldung['mitglied_id']), MITGLIEDER ) AND MITGLIEDER[ intval($rueckmeldung['mitglied_id']) ][ $kategorie ] == $wert ) {
          unset( $wert_cluster['mitglieder_ausstehend'][ intval($rueckmeldung['mitglied_id']) ] );
          if( $rueckmeldung['status'] >= 1 ) array_push( $wert_cluster['zusagen'], $rueckmeldung ); else array_push( $wert_cluster['absagen'], $rueckmeldung );
        }
      }
      return $wert_cluster;
    }
    else {
      if ( is_null($rueckmeldungen) ) $rueckmeldungen = $this->termine_rueckmeldungen();
      if ( is_null($mitglieder) ) $mitglieder = MITGLIEDER;
      $rueckmeldungen_cluster = array();
      $werte = verfuegbare_werte_in_spalte( array_column( $mitglieder, $kategorie ) );
      $mitglieder_cluster = tabelle_clustern( $mitglieder, $kategorie );
      foreach( $werte as $wert ) {
        $rueckmeldungen_cluster[ $wert ] = $this->termine_rueckmeldungen_cluster( $wert, $kategorie, $rueckmeldungen, $mitglieder_cluster[ $wert ] );
      }
      return $rueckmeldungen_cluster;
    }
  }

  //------------------------------------------------------------------------------------------------------------------
  public function termine_anwesenheiten( $id = NULL, $parameter = array(), $sortierung = 'zeitpunkt') {
    if ( !is_null($id) ) {
      $anwesenheit = $this->db->get_where( 'termine_anwesenheiten', array( 'id' => intval($id) ) )->row_array();
      if ( is_null( $anwesenheit ) ) return array(); else return $anwesenheit;
    }
    else {
      foreach( $parameter as $kategorie => $filter )
        if( in_array( $kategorie, array( 'termin_id', 'mitglied_id' ) ) ) {
          if( is_array( $filter ) ) $this->db->where_in( $kategorie, $filter ); else $this->db->where( $kategorie, $filter );
          unset( $parameter[ $kategorie ] );
        }
      $anwesenheiten_ids = verfuegbare_werte_in_spalte( array_column( $this->db->get( 'termine_anwesenheiten' )->result_array(), 'id' ), FALSE );
      $anwesenheiten = array(); foreach( $anwesenheiten_ids as $anwesenheiten_id ) {
        $anwesenheit = $this->termine_anwesenheiten( $anwesenheiten_id );
        if( array_intersect_assoc( $parameter, $anwesenheit ) == $parameter ) $anwesenheiten[ $anwesenheiten_id ] = $anwesenheit;
      }
      return tabelle_sortieren( $anwesenheiten, $sortierung );
    }
  }

  public function termine_anwesenheit_eintragen( $anwesenheit ) {
    $this->db->delete( 'termine_anwesenheiten', array( 'termin_id' => intval($anwesenheit['termin_id']), 'mitglied_id' => intval($anwesenheit['mitglied_id']) ) );
    return $this->db->insert( 'termine_anwesenheiten', sql_sicherheitscheck( $anwesenheit ) );
  }

  public function termine_anwesenheit_austragen( $anwesenheit_id ) {
    return $this->db->delete( 'termine_anwesenheiten', array( 'id' => intval($anwesenheit_id) ) );
  }

}
