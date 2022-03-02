<?php
class Einstellungen_model extends CI_Model {

  public function __construct() {
    parent::__construct();
  }

  public function einstellungen( $id = NULL, $parameter = array(), $sortierung = 'zeitpunkt') {
    if ( !is_null($id) ) {
      $einstellung = $this->db->get_where( 'mitglieder_einstellungen', array( 'id' => intval($id) ) )->row_array();
      if ( is_null( $einstellung ) ) return array(); else return $einstellung;
    }
    else {
      foreach( $parameter as $kategorie => $filter )
        if( in_array( $kategorie, array( 'mitglied_id', 'einstellung_id', 'wert', ) ) ) {
          if( is_array( $filter ) ) $this->db->where_in( $kategorie, $filter ); else $this->db->where( $kategorie, $filter );
          unset( $parameter[ $kategorie ] );
        }
      $einstellungen_ids = verfuegbare_werte_in_spalte( array_column( $this->db->get( 'mitglieder_einstellungen' )->result_array(), 'id' ), FALSE );
      $einstellungen = array(); foreach( $einstellungen_ids as $einstellungen_id ) {
        $einstellung = $this->einstellungen( $einstellungen_id );
        if( array_intersect_assoc( $parameter, $einstellung ) == $parameter ) $einstellungen[ $einstellungen_id ] = $einstellung;
      }
      return tabelle_sortieren( $einstellungen, $sortierung );
    }
  }

  public function standard_einstellung( $gruppe, $funktion, $mitglied_id ) {
    $einstellungen = $this->einstellungen( NULL, array( 'mitglied_id' => $mitglied_id, 'gruppe' => $gruppe, 'funktion' => $funktion ) );
    if( empty( $einstellungen ) ) return EINSTELLUNGEN[ $gruppe ][ $funktion ]['standardwert'];
    else return $einstellungen[ array_key_last( $einstellungen ) ]['wert'];
  }

  public function einstellung_setzen( $einstellung ) {
    $this->db->delete( 'mitglieder_einstellungen', array( 'mitglied_id' => intval($einstellung['mitglied_id']), 'gruppe' => $einstellung['gruppe'], 'funktion' => $einstellung['funktion'] ) );
    return $this->db->insert( 'mitglieder_einstellungen', sql_sicherheitscheck( $einstellung ) );
  }

}
