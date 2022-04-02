<?php
class Startseite extends Vereinsapp_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
    $termine_zeitraum = $this->einstellungen_model->standard_einstellung( CONTROLLER, 'termine_zeitraum', ICH['id'] );

    if( $this->einstellungen_model->standard_einstellung( CONTROLLER, 'logo_anzeigen', ICH['id'] ) == 'ja' ) $this->load->view('startseite/logo', $this->data);

	  if( in_array( '-m', ICH['rechte'] ) ) {
      $gesperrte_mitglieder = array();
      foreach( MITGLIEDER as $mitglied ) {
        if( $mitglied['loginversuche'] == 0 ) $gesperrte_mitglieder[] = $mitglied;
      }

      if( !empty($gesperrte_mitglieder) ) { $this->data['ueberschrift'] = 'Gesperrte Zugänge'; $this->load->view('templates/ueberschrift', $this->data); }
      $liste = array(); if( !empty($gesperrte_mitglieder) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_kopf', $this->data); unset($liste['kopf']); }
      foreach( $gesperrte_mitglieder as $gesperrtes_mitglied ) {
        $liste['element']['beschriftung'] = $gesperrtes_mitglied['vorname'].' '.$gesperrtes_mitglied['nachname'];
        //$liste['element']['small'] = ;
        $liste['element']['float_right'] = SYMBOLE['gesperrt']['html'];
        $liste['element']['symbol'] = SYMBOLE['info']['bootstrap'];
        $liste['element']['link'] = 'mitglieder/details/'.$gesperrtes_mitglied['id'];
        $this->data['liste'] = $liste; $this->load->view('templates/liste_element', $this->data); unset($liste['element']);
      }
      if( !empty($gesperrte_mitglieder) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_fuss', $this->data); unset($liste); }
    }

    $zeitraeume = array(
      'kommende_14_tage' => array(
        array( 'ueberschrift' => 'in den nächsten 14 Tagen', 'start' => HEUTE, 'ende' => HEUTE+2*SEK_PRO_WOCHE, ),
      ),
      'diese_naechste_woche' => array(
        array( 'ueberschrift' => 'in dieser Woche', 'start' => LETZTER_MONTAG, 'ende' => NAECHSTER_MONTAG, ),
        array( 'ueberschrift' => 'in der nächsten Woche', 'start' => NAECHSTER_MONTAG, 'ende' => UEBERNAECHSTER_MONTAG, ),
      ),
    );

    
    foreach( $zeitraeume[ $termine_zeitraum ] as $zeitraum ) {

      $geburtstagskinder = array();
      foreach( $this->mitglieder_model->mitglieder( NULL, array(), 'geburtstag') as $mitglied ):
        if( $zeitraum['start'] <= $mitglied['geburtstag'] AND $zeitraum['ende'] > $mitglied['geburtstag'] )
        $geburtstagskinder[] = $mitglied;
      endforeach;

      if( !empty($geburtstagskinder) ) { $this->data['ueberschrift'] = 'Geburtstage '.$zeitraum['ueberschrift']; $this->load->view('templates/ueberschrift', $this->data); }
      $liste = array(); if( !empty($geburtstagskinder) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_kopf', $this->data); unset($liste['kopf']); }
      foreach( $geburtstagskinder as $geburtstagskind ) {
        $liste['element']['beschriftung'] = $geburtstagskind['vorname'].' '.$geburtstagskind['nachname'];
        $liste['element']['small'] = WOCHENTAGE[ intval(date( 'w', $geburtstagskind['geburtstag'] )) ][0].', '.date( 'd.m.', $geburtstagskind['geburtstag'] ).' ('.floor( ( intval($geburtstagskind['geburtstag']) +12*60*60 - intval($geburtstagskind['geburt']) ) / SEK_PRO_JAHR ).')';
        $liste['element']['float_right'] = SYMBOLE['geburtstag']['html'];
        //$liste['element']['link'] = 'mitglieder/details/'.$geburtstagskind['id'];
        $this->data['liste'] = $liste; $this->load->view('templates/liste_element', $this->data); unset($liste['element']);
      }
      if( !empty($geburtstagskinder) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_fuss', $this->data); unset($liste); }
    }
    
    if( in_array( 'termine', AKTIVE_CONTROLLER ) ) {
      $this->load->model('termine_model');
      foreach( $zeitraeume[ $termine_zeitraum ] as $zeitraum ) {

        $termine = $this->termine_model->termine( NULL, array( 'start>=' => $zeitraum['start'], 'start<=' => $zeitraum['ende']-1 ) );
        if( !empty($termine) ) { $this->data['ueberschrift'] = 'Termine '.$zeitraum['ueberschrift']; $this->load->view('templates/ueberschrift', $this->data); }
        $liste = array(); if( !empty($termine) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_kopf', $this->data); unset($liste['kopf']); }
        foreach( $termine as $termin ) {
          $liste['element']['beschriftung'] = $termin['titel'];
          $liste['element']['float_right'] = '<span class="stretched-link-unwirksam" role="button" data-toggle="popover" data-placement="left" data-content="'.VORGEGEBENE_WERTE['termine']['typ'][ $termin['typ'] ]['beschriftung'].'" tabindex="0" data-trigger="focus">'.VORGEGEBENE_WERTE['termine']['typ'][ $termin['typ'] ]['symbol'].'</span>';

          $liste['element']['small'] = WOCHENTAGE[ intval(date( 'w', $termin['start'] )) ][0].', '.date( 'd.m. H:i', $termin['start'] );
          if( intval($termin['start']) >= HEUTE ) {
            $liste['element']['symbol'] = SYMBOLE['info']['bootstrap'];
            $liste['element']['link'] = 'termine/details/'.$termin['id'];
          }
          $this->data['liste'] = $liste; $this->load->view('templates/liste_element', $this->data); unset($liste['element']);
        }
        if( !empty($termine) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_fuss', $this->data); unset($liste); }
  
      }
    }

    $this->data['werkzeugkasten'][] = array( 'ziel' => 'einstellungen', 'symbol' => SYMBOLE['einstellungen']['bootstrap'] );
    $this->data['einstellungen'] = array( 'startseite' => array( 'logo_anzeigen' => NULL, 'termine_zeitraum' => NULL, ), );
    foreach( $this->data['einstellungen'] as $gruppe => $funktionen ) foreach( $funktionen as $funktion => $wert )
      $this->data['einstellungen'][ $gruppe ][ $funktion ] = $this->einstellungen_model->standard_einstellung( $gruppe, $funktion, ICH['id'] );
    $this->load->view('einstellungen/einstellungen_modal', $this->data);

    $this->load->view('templates/footer', $this->data);
  }
}
