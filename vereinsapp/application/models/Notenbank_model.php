<?php
class Notenbank_model extends CI_Model {

  public function __construct() {
    parent::__construct();

    if( !isset( $this->session->notenverzeichnis_sortieren ) OR empty( $this->session->notenverzeichnis_sortieren ) OR $this->session->notenverzeichnis_sortieren == '' )
    $this->session->notenverzeichnis_sortieren = array_values( array( array( 'kategorie' => $this->einstellungen_model->standard_einstellung( 'notenverzeichnis', 'sortieren_nach', ICH['id'] ), 'richtung' => SORT_ASC ) ) );
  }

  private $pfad = '../vereinsapp_storage/notenbank';
  private $titelnr_ziffern = 2;
  private $operator_verstecken = '_';
  private $ignorierte_elemente = array(
    '.',
    '..',
    '@eaDir',
  );

  //------------------------------------------------------------------------------------------------------------------
  public function notenbank_notenverzeichnis( $id = NULL, $parameter = array(), $sortieren = NULL ) {
    if( is_null($sortieren) ) $sortieren = $this->session->notenverzeichnis_sortieren;
    $parameter_standard = array(
      'archiv' => 0,
    );

    if ( !is_null($id) ) {
      $titel = $this->db->get_where( 'notenbank_notenverzeichnis', array( 'id' => intval($id) ) )->row_array();
      if ( is_null( $titel ) ) return array(); else return $titel;
    }
    else {
      /*filter*/  if( !array_key_exists( 'archiv', $parameter ) ) $parameter['archiv'] = $parameter_standard['archiv']; elseif( is_null( $parameter['archiv'] ) ) unset( $parameter[ 'archiv' ] );
      foreach( $parameter as $kategorie => $filter )
      if( in_array( $kategorie, NOTENVERZEICHNIS_KATEGORIEN_DB ) ) {
        if( is_array( $filter ) ) $this->db->where_in( $kategorie, $filter ); else $this->db->where( $kategorie, $filter );
          unset( $parameter[ $kategorie ] );
        }
      $notenverzeichnis_ids = verfuegbare_werte_in_spalte( array_column( $this->db->get( 'notenbank_notenverzeichnis' )->result_array(), 'id' ), FALSE );
      $notenverzeichnis = array(); foreach( $notenverzeichnis_ids as $notenverzeichnis_id ) {
        $titel = $this->notenbank_notenverzeichnis( $notenverzeichnis_id );
        if( array_intersect_assoc( $parameter, $titel ) == $parameter ) $notenverzeichnis[ $notenverzeichnis_id ] = $titel;
      }
      return tabelle_sortieren( $notenverzeichnis, $sortieren );
    }
  }

  public function notenbank_titel_db_aktualisieren( $titel = NULL ) {
    if( isset($titel['archiv']) AND $titel['archiv'] > 0 ) {  // Titel wird ausgetragen
      // in Bewertungen Notenverzeichnis geprüft
      if( in_array( 'termine', AKTIVE_CONTROLLER ) AND TERMINE_SETLISTS ) {
        $this->load->model('termine_model');
        foreach( $this->termine_model->alle_termine() as $termin )
          if( in_array( $titel['id'],  $termin['setlist'] ) ) {
            unset( $termin['setlist'][ array_search( $titel['id'], $termin['setlist'] ) ] );
            $this->termine_model->termin_db_aktualisieren( $termin );
          }
      }
    }
    return $this->db->update( 'notenbank_notenverzeichnis', sql_sicherheitscheck( $titel ), array( 'id' => $titel['id'] ) );
  }

  public function notenbank_titel_eintragen( $titel ) {
    return $this->db->insert( 'notenbank_notenverzeichnis', sql_sicherheitscheck( $titel ) );
  }


  //------------------------------------------------------------------------------------------------------------------
  private function verzeichnis_zu_titel_nr( $titel_nr ) {
    if ( $handle = opendir( $this->pfad ) )
      while ( ( $element = readdir( $handle ) ) !== FALSE )
        if ( $element == '.' OR $element == '..' OR substr( $element, 0, strlen($this->operator_verstecken) ) == $this->operator_verstecken ) continue; // Element ist kein Sonderelement und nicht versteckt
        elseif( !strrchr( $element, "." ) AND substr( $element, 0, $this->titelnr_ziffern ) == str_pad( $titel_nr, $this->titelnr_ziffern ,'0', STR_PAD_LEFT ) ) { closedir($handle); return '/'.$element; }
        else continue;
    else return NULL;
    closedir($handle); return NULL;
  }

  public function notenbank_titel_nr_inhalt( $titel_nr, $unterverzeichnisse = NULL ) {
    if( is_null( $unterverzeichnisse ) ) $unterverzeichnis = '';
    elseif( is_array( $unterverzeichnisse ) ) $unterverzeichnis = pfad_aus_array( $unterverzeichnisse );
    else $unterverzeichnis = $unterverzeichnisse;

    if( strlen($unterverzeichnis) > 0 AND $unterverzeichnis[0] != '/' ) $unterverzeichnis = '/'.$unterverzeichnis;

    if( !is_null( $this->verzeichnis_zu_titel_nr( $titel_nr ) ) )
      if ( $handle = opendir( $this->pfad .$this->verzeichnis_zu_titel_nr( $titel_nr ) .$unterverzeichnis ) ) {

        $inhalt = array();
        while( ( $element = readdir( $handle ) ) !== FALSE ) {
          $element_pfad = $this->pfad .$this->verzeichnis_zu_titel_nr( $titel_nr ) .$unterverzeichnis;

          if( in_array( $element, $this->ignorierte_elemente ) OR substr( $element, 0, strlen($this->operator_verstecken) ) == $this->operator_verstecken ) continue; // Element ist kein Sonderelement und nicht versteckt
          
          elseif( !strrchr( $element, "." ) ) $inhalt[$element] = $this->notenbank_titel_nr_inhalt( $titel_nr, $unterverzeichnis.'/'.$element ); // Element ist ein Ordner
          
          elseif( substr(strrchr( $element_pfad.'/'.$element , "."), 1) == 'pdf' ) // Elemenet ist ein PDF
            $inhalt['_stimmen'][] = array(
              'element' => $element,
              'letzte_aenderung' => filemtime( $element_pfad.'/'.$element ),
              );
          
              elseif( file_exists( $element_pfad.'/'.$element ) AND in_array( substr( strrchr($element, "."), 1 ), AUDIOFORMATE ) ) // Elemenet ist ein PDF
            $inhalt['_audio'][] = array(
              'element' => $element,
              'letzte_aenderung' => filemtime( $element_pfad.'/'.$element ),
              );
          else continue; // $inhalt['_sonstiges'][] = $element;
        }
          
        closedir( $handle );

      } else return NULL;
    else return NULL;
    ksort( $inhalt );
    return $inhalt;
  }

  private function verzeichnis_anzahl_unterverzeichnisse( $verzeichnis_inhalt ){
    $anzahl = 0;
    if( is_array($verzeichnis_inhalt) ) foreach( $verzeichnis_inhalt as $unterverzeichnis => $unterverzeichnis_inhalt ){
      if( substr( $unterverzeichnis, 0, strlen($this->operator_verstecken) ) == $this->operator_verstecken ) continue;
      else {
        $anzahl++;
        if( is_array($unterverzeichnis_inhalt) ) $anzahl+=$this->verzeichnis_anzahl_unterverzeichnisse( $unterverzeichnis_inhalt );
      }
    }
    return $anzahl;
  }

  private function verzeichnis_anzahl_stimmen( $verzeichnis_inhalt ){
    $anzahl = 0;
    if( is_array($verzeichnis_inhalt) ) foreach( $verzeichnis_inhalt as $unterverzeichnis => $unterverzeichnis_inhalt ):
      if( $unterverzeichnis == '_stimmen' ) $anzahl+=count($unterverzeichnis_inhalt);
      elseif( substr( $unterverzeichnis, 0, strlen($this->operator_verstecken) ) == $this->operator_verstecken ) continue;
      else if( is_array($unterverzeichnis_inhalt) ) $anzahl+=$this->verzeichnis_anzahl_stimmen( $unterverzeichnis_inhalt );
    endforeach;
    return $anzahl;
  }

  private function verzeichnis_anzahl_audio( $verzeichnis_inhalt ){
    $anzahl = 0;
    if( is_array($verzeichnis_inhalt) ) foreach( $verzeichnis_inhalt as $unterverzeichnis => $unterverzeichnis_inhalt ):
      if( $unterverzeichnis == '_audio' ) $anzahl+=count($unterverzeichnis_inhalt);
      elseif( substr( $unterverzeichnis, 0, strlen($this->operator_verstecken) ) == $this->operator_verstecken ) continue;
      else if( is_array($unterverzeichnis_inhalt) ) $anzahl+=$this->verzeichnis_anzahl_audio( $unterverzeichnis_inhalt );
    endforeach;
    return $anzahl;
  }

  public function notenbank_verzeichnis_meta( $verzeichnis_inhalt ) {
    $verzeichnis_meta = array(
      'anzahl_unterverzeichnisse' => $this->verzeichnis_anzahl_unterverzeichnisse( $verzeichnis_inhalt ),
      'anzahl_stimmen' => $this->verzeichnis_anzahl_stimmen( $verzeichnis_inhalt ),
      'anzahl_audio' => $this->verzeichnis_anzahl_audio( $verzeichnis_inhalt ),
    );
    return $verzeichnis_meta;
  }

  public function notenbank_pfad_titel_nr( $titel_nr ) {
    return '../../../'.$this->pfad.$this->verzeichnis_zu_titel_nr( $titel_nr );
  }

}
