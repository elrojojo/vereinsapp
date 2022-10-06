<?php
/**
 * Eigener Library f�r die Vereinsapp
 *
 */
defined('BASEPATH') OR exit('No direct script access allowed');
//$CI =& get_instance(); $CI->load->model('umfragen_model');

class Bewertung { //extends Umfragen_Model {

  protected $CI;

  public $titel;
  public $db_tabelle;
  public $initialbewertung_id;
  public $verfuegbare_werte;

  public function __construct( $bewertung ) {
    //parent::__construct();
    $this->CI =& get_instance();

    $this->titel = $bewertung['titel'];
    $this->db_tabelle = $bewertung['db_tabelle'];
    $this->initialbewertung = $bewertung['initialbewertung'];
    $this->verfuegbare_werte = $bewertung['verfuegbare_werte'];
  }

  //------------------------------------------------------------------------------------------------------------------
  public function bewertungen( $id = NULL, $parameter = array(), $sortierung = 'zeitpunkt') {
    if ( !is_null($id) ) {
      $bewertung = $this->CI->db->get_where( DB_PREFIX .$this->db_tabelle, array( 'id' => $id ) )->row_array();
      if ( is_null( $bewertung ) ) $bewertung = array(); return $bewertung;
    }
    else {
      $db_parameter = array(); foreach( array( 'objekt_id', 'wert', 'wert>=',  'wert<=', 'mitglied_id', 'archiv', ) as $index ) {
        if( array_key_exists( $index, $parameter ) ) $db_parameter[ $index ] = $parameter[ $index ]; unset( $parameter[ $index ] ); }
      if( !array_key_exists( 'archiv', $db_parameter ) ) $db_parameter[ 'archiv' ] = 0;
      elseif( $db_parameter[ 'archiv' ] == NULL ) unset( $db_parameter[ 'archiv' ] );
      $bewertungen_ids = verfuegbare_werte_in_spalte( array_column( $this->CI->db->get_where( DB_PREFIX .$this->db_tabelle, $db_parameter )->result_array(), 'id' ) );
      $bewertungen = array(); foreach( $bewertungen_ids as $bewertungen_id ) {
        $bewertung = $this->bewertungen( $bewertungen_id );
        if( array_intersect_assoc( $parameter, $bewertung ) == $parameter ) $bewertungen[ $bewertungen_id ] = $bewertung;
      }
      return tabelle_sortieren( $bewertungen, $sortierung );
    }
  }

  public function bewerten( $bewertung ) {
    $this->CI->db->update( DB_PREFIX .$this->db_tabelle, array( 'archiv' => 1 ), array( 'objekt_id' => $bewertung['objekt_id'], 'mitglied_id' => $bewertung['mitglied_id'], ) );
    return $this->CI->db->insert( DB_PREFIX .$this->db_tabelle, $bewertung );
  }

}
