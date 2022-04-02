<?php
class Strafkatalog_model extends CI_Model {

  public function __construct() {
    parent::__construct();
  }

  //------------------------------------------------------------------------------------------------------------------
  public function strafkatalog_kapiteln( $id = NULL, $parameter = array(), $sortierung = 'id') {
    if ( !is_null($id) ) {
      $kapitel = $this->db->get_where( 'strafkatalog_kapiteln', array( 'id' => intval($id) ) )->row_array();
      if ( is_null( $kapitel ) ) return array(); else return $kapitel;
    }
    else {
      if( !array_key_exists( 'archiv', $parameter ) ) $parameter['archiv'] = 0; elseif( $parameter[ 'archiv' ] == NULL ) unset( $parameter[ 'archiv' ] );
      foreach( $parameter as $kategorie => $filter )
        if( in_array( $kategorie, array( 'titel', 'archiv', ) ) ) {
          if( is_array( $filter ) ) $this->db->where_in( $kategorie, $filter ); else $this->db->where( $kategorie, $filter );
          unset( $parameter[ $kategorie ] );
        }
      $kapiteln_ids = verfuegbare_werte_in_spalte( array_column( $this->db->get( 'strafkatalog_kapiteln' )->result_array(), 'id' ), FALSE );
      $kapiteln = array(); foreach( $kapiteln_ids as $kapiteln_id ) {
        $kapitel = $this->strafkatalog_kapiteln( $kapiteln_id );
        if( array_intersect_assoc( $parameter, $kapitel ) == $parameter ) $kapiteln[ $kapiteln_id ] = $kapitel;
      }
      return tabelle_sortieren( $kapiteln, $sortierung );
    }
  }

  //------------------------------------------------------------------------------------------------------------------
  public function strafkatalog( $id = NULL, $parameter = array(), $sortierung = 'kapitel_id') {
    if ( !is_null($id) ) {
      $strafe = $this->db->get_where( 'strafkatalog', array( 'id' => intval($id) ) )->row_array();
      if ( is_null( $strafe ) ) return array(); else return $strafe;
    }
    else {
      if( !array_key_exists( 'archiv', $parameter ) ) $parameter['archiv'] = 0; elseif( $parameter[ 'archiv' ] == NULL ) unset( $parameter[ 'archiv' ] );
      foreach( $parameter as $kategorie => $filter )
        if( in_array( $kategorie, array( 'grund', 'bemerkung', 'kapitel_id',  'betrag>=', 'betrag<=', 'archiv', ) ) ) {
          if( is_array( $filter ) ) $this->db->where_in( $kategorie, $filter ); else $this->db->where( $kategorie, $filter );
          unset( $parameter[ $kategorie ] );
        }
      $strafkatalog_ids = verfuegbare_werte_in_spalte( array_column( $this->db->get( 'strafkatalog' )->result_array(), 'id' ), FALSE );
      $strafkatalog = array(); foreach( $strafkatalog_ids as $strafkatalog_id ) {
        $strafe = $this->strafkatalog( $strafkatalog_id );
        if( array_intersect_assoc( $parameter, $strafe ) == $parameter ) $strafkatalog[ $strafkatalog_id ] = $strafe;
      }
      return tabelle_sortieren( $strafkatalog, $sortierung );
    }
  }

  public function strafe_db_aktualisieren( $strafe ) {
    return $this->db->update( 'strafkatalog', sql_sicherheitscheck( $strafe ), array( 'id' => $strafe['id'] ) );
  }

  public function strafe_eintragen( $strafe ) {
    return $this->db->insert( 'strafkatalog', sql_sicherheitscheck( $strafe ) );
  }
  
  //------------------------------------------------------------------------------------------------------------------
  public function strafkatalog_eintraege( $id = NULL, $parameter = array(), $sortierung = 'zeitpunkt') {
    if ( !is_null($id) ) {
      $eintrag = $this->db->get_where( 'strafkatalog_eintraege', array( 'id' => intval($id) ) )->row_array();
      if ( is_null( $eintrag ) ) return array(); else return $eintrag;
    }
    else {
      if( !array_key_exists( 'archiv', $parameter ) ) $parameter['archiv'] = 0; elseif( $parameter[ 'archiv' ] == NULL ) unset( $parameter[ 'archiv' ] );
      foreach( $parameter as $kategorie => $filter )
        if( in_array( $kategorie, array( 'strafe_grund', 'strafe_bemerkung', 'strafe_betrag>=', 'strafe_betrag<=', 'mitglied_id', 'von_mitglied_id', 'erledigt_zeitpunkt>=', 'erledigt_zeitpunkt<=', 'erledigt_von_mitglied_id', 'archiv', ) ) ) {
          if( is_array( $filter ) ) $this->db->where_in( $kategorie, $filter ); else $this->db->where( $kategorie, $filter );
          unset( $parameter[ $kategorie ] );
        }
      $eintraege_ids = verfuegbare_werte_in_spalte( array_column( $this->db->get( 'strafkatalog_eintraege' )->result_array(), 'id' ), FALSE );
      $eintraege = array(); foreach( $eintraege_ids as $eintraege_id ) {
        $eintrag = $this->strafkatalog_eintraege( $eintraege_id );
        if( array_intersect_assoc( $parameter, $eintrag ) == $parameter ) $eintraege[ $eintraege_id ] = $eintrag;
      }
      return tabelle_sortieren( $eintraege, $sortierung );
    }
  }

  public function strafkatalog_eintrag_eintragen( $eintrag ) {
    return $this->db->insert( 'strafkatalog_eintraege', sql_sicherheitscheck( $eintrag ) );
  }

  public function strafkatalog_eintrag_db_aktualisieren( $eintrag ) {
    return $this->db->update( 'strafkatalog_eintraege', sql_sicherheitscheck( $eintrag ), array( 'id' => $eintrag['id'] ) );
  }

  public function strafkatalog_eintraege_betrag( $eintraege = NULL ) {
    if( is_null($eintraege) ) $eintraege = $this->strafkatalog_eintraege();
    $eintraege_betrag = 0; foreach ($eintraege as $eintrag) $eintraege_betrag += $eintrag['strafe_betrag'];
    return $eintraege_betrag;
  }

}
