<?php
class Notenbank extends Vereinsapp_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('notenbank_model');

    if( !isset( $this->session->notenverzeichnis_sortieren ) OR empty( $this->session->notenverzeichnis_sortieren ) OR $this->session->notenverzeichnis_sortieren == '' )
      $this->session->notenverzeichnis_sortieren = array_values( array( array( 'kategorie' => $this->einstellungen_model->standard_einstellung( 'notenverzeichnis', 'sortieren_nach', ICH['id'] ), 'richtung' => SORT_ASC ) ) );
  }

  public function index() {
    $sortieren = $this->session->notenverzeichnis_sortieren;
    $filtern = array(); $parameter = array();
    if( isset( $this->session->notenverzeichnis_filtern ) AND !empty( $this->session->notenverzeichnis_filtern ) ) {
      foreach( $this->session->notenverzeichnis_filtern as $filter )
        $parameter[ $filter['kategorie'] ] = $this->parameter_aus_filter( NOTENVERZEICHNIS_FILTERBARE_KATEGORIEN, $filter, $this->notenbank_model->notenbank_notenverzeichnis(), NOTENVERZEICHNIS_KATEGORIEN_DB );
      $filtern = $this->session->notenverzeichnis_filtern;
    }

    $notenbank_notenverzeichnis = $this->notenbank_model->notenbank_notenverzeichnis( NULL, $parameter, notenverzeichnis_kategorie_sortierkorrektur( $sortieren ) );

    $liste = array( 'beschriftung_h5' => TRUE, /*'sortable' => TRUE*/ ); //$position = 1;
    if( !empty($notenbank_notenverzeichnis) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_kopf', $this->data); unset($liste['kopf']); }
    foreach( $notenbank_notenverzeichnis as $titel ) {
      //$liste['element']['id'] = $titel['id']; $liste['element']['sortable'] = TRUE; $liste['element']['position'] = $position; $position++;
      $liste['element']['beschriftung'] = $titel['titel_nr'].' '.$titel['titel'];

      $verzeichnis_meta = $this->notenbank_model->notenbank_verzeichnis_meta( $this->notenbank_model->notenbank_titel_nr_inhalt( $titel['titel_nr'] ) );
      if( $verzeichnis_meta['anzahl_stimmen'] > 0 OR $verzeichnis_meta['anzahl_audio'] > 0 OR $verzeichnis_meta['anzahl_unterverzeichnisse'] > 0 ) {
        $liste['element']['truncate'] = $verzeichnis_meta['anzahl_stimmen'].'<i class="bi bi-'.SYMBOLE['noten']['bootstrap'].'"></i> + '.
          $verzeichnis_meta['anzahl_audio'].'<i class="bi bi-'.SYMBOLE['play']['bootstrap'].'"></i> in '.
          $verzeichnis_meta['anzahl_unterverzeichnisse'].'<i class="bi bi-'.SYMBOLE['verzeichnis']['bootstrap'].'"></i>';
        $liste['element']['symbol'] = SYMBOLE['verzeichnis_oeffnen']['bootstrap'];
        $liste['element']['link'] = CONTROLLER.'/titel/'.$titel['id'];
      }

      if( in_array( '-n', ICH['rechte'] ) ) {
        $this->data['eintragen']['notenverzeichnis'][ intval($titel['id']) ] = $titel;
        $this->data['austragen']['notenverzeichnis'][ intval($titel['id']) ] = $titel;
        $this->data['austragen']['id'] = 'titel_austragen'; $this->data['austragen']['elemente'][ intval($titel['id']) ] = array( 'beschriftung' => $titel['titel_nr'] .' '.$titel['titel'] );

        $this->data['liste_element_werkzeugkasten'] = array( 'id' => $titel['id'], 'werkzeugkasten' => array(), );
        $this->data['liste_element_werkzeugkasten']['werkzeugkasten'][] = array( 'ziel' => $this->data['austragen']['id'], 'symbol' => SYMBOLE['loeschen']['bootstrap'], 'farbe' => 'danger', 'data' => array( 'element_id' => intval($titel['id']), ), );
        $this->data['liste_element_werkzeugkasten']['werkzeugkasten'][] = array( 'ziel' => 'notenverzeichnis_eintragen', 'symbol' => SYMBOLE['duplizieren']['bootstrap'], 'data' => array( 'titel_id' => intval($titel['id']), 'aktion' => 'duplizieren', ), );
        $this->data['liste_element_werkzeugkasten']['werkzeugkasten'][] = array( 'ziel' => 'notenverzeichnis_eintragen', 'symbol' => SYMBOLE['aendern']['bootstrap'], 'data' => array( 'titel_id' => intval($titel['id']), 'aktion' => 'aendern', ), );
        $this->data['liste_element_werkzeugkasten'] = $this->load->view('templates/liste_element_werkzeugkasten', $this->data, TRUE);
      }

      $this->data['liste'] = $liste; $this->load->view('templates/liste_element', $this->data); unset($liste['element']);
    }
    if( !empty($notenbank_notenverzeichnis) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_fuss', $this->data); unset($liste); }

    if( in_array( '-n', ICH['rechte'] ) ) {
      $this->data['werkzeugkasten'][] = array( 'ziel' => 'notenverzeichnis_eintragen',  'symbol' => SYMBOLE['hinzufuegen']['bootstrap'], 'data' => array( 'aktion' => 'eintragen', ) );

      $this->data['eintragen']['form'] = site_url().CONTROLLER.'/eintragen';
      $this->data['eintragen']['titel'] =  array( 'eintragen' => 'Titel eintragen', 'duplizieren' => 'Titel duplizieren', 'aendern' => 'Titel ändern', );
      $this->data['eintragen']['submit'] = array( 'eintragen' => 'Titel speichern', 'duplizieren' => 'Titel speichern', 'aendern' => 'Speichern', );

      $this->data['eintragen']['naechste_freie_titel_nr'] = NULL; $naechste_freie_titel_nr = 1; while( is_null($this->data['eintragen']['naechste_freie_titel_nr']) )
        if( !empty( $this->notenbank_model->notenbank_notenverzeichnis( NULL, array( 'titel_nr' => $naechste_freie_titel_nr ) )) ) $naechste_freie_titel_nr++;
        else $this->data['eintragen']['naechste_freie_titel_nr'] = $naechste_freie_titel_nr;
      
      $this->load->view('notenbank/eintragen_modal', $this->data);

      $this->data['austragen']['form'] = site_url().CONTROLLER.'/austragen';
      $this->data['austragen']['titel'] = 'Titel';
      //$this->data['austragen']['submit'] = array( 'austragen' => 'Titel löschen', );
      if( !empty($notenbank_notenverzeichnis) ) $this->load->view('templates/austragen_modal', $this->data);
    }

    $this->data['filtern'] = $filtern; $this->data['sortieren'] = $sortieren;
    //$this->data['werkzeugkasten'][] = array( 'typ' => 'modal', 'ziel' => CONTROLLER.'_filtern', 'symbol' => SYMBOLE['filtern']['bootstrap'] );
    //$this->data['view'] = array( 'filterbare_kategorien' => NOTENVERZEICHNIS_FILTERBARE_KATEGORIEN, 'kategorien' => NOTENVERZEICHNIS_KATEGORIEN, 'objekte' => $this->notenbank_model->notenbank_notenverzeichnis() ); $this->load->view('templates/filtern', $this->data);
    $this->data['werkzeugkasten'][] = array( 'typ' => 'modal', 'ziel' => CONTROLLER.'_sortieren', 'symbol' => SYMBOLE['sortieren']['bootstrap'] );
    $this->data['view'] = array( 'sortierbare_kategorien' => NOTENVERZEICHNIS_SORTIERBARE_KATEGORIEN, 'kategorien' => NOTENVERZEICHNIS_KATEGORIEN ); $this->load->view('templates/sortieren', $this->data);

    $this->data['werkzeugkasten'][] = array( 'ziel' => 'einstellungen', 'symbol' => SYMBOLE['einstellungen']['bootstrap'] );
    $this->data['einstellungen'] = array( 'notenverzeichnis' => array( 'sortieren_nach' => NULL, ), );
    foreach( $this->data['einstellungen'] as $gruppe => $funktionen ) foreach( $funktionen as $funktion => $wert )
      $this->data['einstellungen'][ $gruppe ][ $funktion ] = $this->einstellungen_model->standard_einstellung( $gruppe, $funktion, ICH['id'] );
    $this->load->view('einstellungen/einstellungen_modal', $this->data);

    //$this->data['links'][] = array( 'ziel' => site_url().CONTROLLER.'/bewertung_notenverzeichnis', 'symbol' => CONTROLLER_INT['umfragen']['symbol'] );
    if( defined('NOTENVERZEICHNIS_PDF') AND !is_null(NOTENVERZEICHNIS_PDF) ) $this->data['links'][] = array( 'ziel' => NOTENVERZEICHNIS_PDF, 'symbol' => SYMBOLE['pdf']['bootstrap'] );

    $this->load->view('templates/footer', $this->data);
  }

  //------------------------------------------------------------------------------------------------------------------
  public function sortieren( $kategorie ) {
    $sortieren = array( array( 'kategorie' => urldecode( $kategorie ), 'richtung' => SORT_ASC ) );
    $this->session->notenverzeichnis_sortieren = array_values($sortieren);
    redirect(ABSPRUNG);
  }

  public function sortieren_hinzu( $kategorie ) {
    $sortieren = $this->session->notenverzeichnis_sortieren; if( !is_array($sortieren) ) $sortieren = array();
    $sortieren[] = array( 'kategorie' => urldecode( $kategorie ), 'richtung' => SORT_ASC );
    $this->session->notenverzeichnis_sortieren = array_values($sortieren);
    redirect(ABSPRUNG);
  }

  public function sortieren_umkehren( $kategorie ) {
    $sortieren = $this->session->notenverzeichnis_sortieren; if( !is_array($sortieren) ) $sortieren = array();
    foreach( $sortieren as $prioritaet => $reihenfolge )
      if( urldecode( $kategorie ) == $reihenfolge['kategorie'] ) if( $reihenfolge['richtung'] == SORT_DESC ) $sortieren[ $prioritaet ]['richtung'] = SORT_ASC; else $sortieren[ $prioritaet ]['richtung'] = SORT_DESC;
    $this->session->notenverzeichnis_sortieren = array_values($sortieren);
    redirect(ABSPRUNG);
  }

  public function sortieren_loeschen( $kategorie ) {
    $sortieren = $this->session->notenverzeichnis_sortieren; if( !is_array($sortieren) ) $sortieren = array();
    foreach( $sortieren as $prioritaet => $reihenfolge )
      if( urldecode( $kategorie ) == $reihenfolge['kategorie'] ) unset( $sortieren[ $prioritaet ] );
    $this->session->notenverzeichnis_sortieren = array_values($sortieren);
    redirect(ABSPRUNG);
  }

  public function filtern_hinzu( $kategorie, $filter1 = NULL, $filter2 = NULL ) {
    if( is_null($filter1) ) {
      if( in_array( NOTENVERZEICHNIS_FILTERBARE_KATEGORIEN[ urldecode( $kategorie ) ], array( 'verfuegbare_werte' ) ) ) {
        $this->form_validation->set_rules( $kategorie.'_filter1', NOTENVERZEICHNIS_KATEGORIEN[ $kategorie ]['beschriftung'].'-Wert', 'required|callback_fv_standard_textzeile');
        if ( !$this->form_validation->run() ) redirect(ABSPRUNG); else {
          $filter1 = $this->input->post($kategorie.'_filter1');
        }
      } elseif( in_array( NOTENVERZEICHNIS_FILTERBARE_KATEGORIEN[ urldecode( $kategorie ) ], array( 'zeitraum', 'zeitraum_jahr' ) ) ) {
        $this->form_validation->set_rules( $kategorie.'_filter1', NOTENVERZEICHNIS_KATEGORIEN[ $kategorie ]['beschriftung'].'-Start', 'required|callback_fv_datum_zeit');
        $this->form_validation->set_rules( $kategorie.'_filter2', NOTENVERZEICHNIS_KATEGORIEN[ $kategorie ]['beschriftung'].'-Ende', 'required|callback_fv_datum_zeit');
        if ( !$this->form_validation->run() ) redirect(ABSPRUNG); else {
          $filter1 = strtotime( $this->input->post($kategorie.'_filter1') );
          $filter2 = strtotime( $this->input->post($kategorie.'_filter2') );
        }
      } elseif( in_array( NOTENVERZEICHNIS_FILTERBARE_KATEGORIEN[ urldecode( $kategorie ) ], array( 'zahlenraum' ) ) ) {
        $this->form_validation->set_rules( $kategorie.'_filter1', NOTENVERZEICHNIS_KATEGORIEN[ $kategorie ]['beschriftung'].'-Start', 'required|numeric');
        $this->form_validation->set_rules( $kategorie.'_filter2', NOTENVERZEICHNIS_KATEGORIEN[ $kategorie ]['beschriftung'].'-Ende', 'required|numeric');
        if ( !$this->form_validation->run() ) redirect(ABSPRUNG); else {
          $filter1 = intval( $this->input->post($kategorie.'_filter1') );
          $filter2 = intval( $this->input->post($kategorie.'_filter2') ); 
        }
      }
    }
    $filtern = $this->session->notenverzeichnis_filtern; if( !is_array($filtern) ) $filtern = array();
    foreach( $filtern as $prioritaet => $filter ) if( urldecode( $kategorie ) == $filter['kategorie'] ) unset( $filtern[ $prioritaet ] );
    if( in_array( NOTENVERZEICHNIS_FILTERBARE_KATEGORIEN[ urldecode( $kategorie ) ], array( 'zeitraum', 'zeitraum_jahr', 'zahlenraum' ) ) ) $filter = array( 'start' => $filter1, 'ende' => $filter2, ); else $filter = $filter1;
    $filtern[] = array( 'kategorie' => urldecode( $kategorie ), 'filter' => $filter );
    $this->session->notenverzeichnis_filtern = array_values($filtern);
    redirect(ABSPRUNG);
  }

  public function filtern_loeschen( $kategorie ) {
    $filtern = $this->session->notenverzeichnis_filtern; if( !is_array($filtern) ) $filtern = array();
    foreach( $filtern as $prioritaet => $filter ) if( urldecode( $kategorie ) == $filter['kategorie'] ) unset( $filtern[ $prioritaet ] );
    $this->session->notenverzeichnis_filtern = array_values($filtern);
    redirect(ABSPRUNG);
  }

  //------------------------------------------------------------------------------------------------------------------
  public function titel( $id ) {
    $notenbank_notenverzeichnis = $this->notenbank_model->notenbank_notenverzeichnis();
    if( !array_key_exists( intval($id), $notenbank_notenverzeichnis ) ) redirect(CONTROLLER); else {

      $this->data['titel'] = $notenbank_notenverzeichnis[ intval($id) ];
      $pfad_titel_nr = $this->notenbank_model->notenbank_pfad_titel_nr( $this->data['titel']['titel_nr'] );

      $this->data['pfad_array'] = array();
      foreach( $this->uri->segment_array() as $id => $verzeichnis ):
        if( $id >= 4 ) $this->data['pfad_array'][] = urldecode( $verzeichnis ); // Prüfen, ob ein Verzeichnis ausgewählt wurde
      endforeach;
      $this->load->view('notenbank/pfad', $this->data);

      $pfad = pfad_aus_array( $this->data['pfad_array'] );
      $verzeichnis_inhalt = $this->notenbank_model->notenbank_titel_nr_inhalt( $this->data['titel']['titel_nr'], $pfad );

      $verzeichnis_inhalt_unterverzeichnisse = $verzeichnis_inhalt;
      if( array_key_exists( '_stimmen', $verzeichnis_inhalt) ) unset( $verzeichnis_inhalt_unterverzeichnisse['_stimmen'] );
      if( array_key_exists( '_audio', $verzeichnis_inhalt) ) unset( $verzeichnis_inhalt_unterverzeichnisse['_audio'] );
      if( !empty($verzeichnis_inhalt_unterverzeichnisse) ) {
        //$this->load->view('templates/horizontale_linie', $this->data);
        $this->data['ueberschrift'] = 'Unterverzeichnisse'; $this->load->view('templates/ueberschrift', $this->data);
        $liste = array(); if( !empty($verzeichnis_inhalt_unterverzeichnisse) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_kopf', $this->data); unset($liste['kopf']); }
        foreach( $verzeichnis_inhalt_unterverzeichnisse as $verzeichnis => $notenbank ) {
          $verzeichnis_meta = $this->notenbank_model->notenbank_verzeichnis_meta( $notenbank );
          $liste['element']['beschriftung'] = $verzeichnis;
          $liste['element']['small'] = $verzeichnis_meta['anzahl_stimmen'].'<i class="bi bi-'.SYMBOLE['noten']['bootstrap'].'"></i> + '.
          $verzeichnis_meta['anzahl_audio'].'<i class="bi bi-'.SYMBOLE['play']['bootstrap'].'"></i> in '.
          $verzeichnis_meta['anzahl_unterverzeichnisse'].'<i class="bi bi-'.SYMBOLE['verzeichnis']['bootstrap'].'"></i>';;
          $liste['element']['symbol'] = SYMBOLE['verzeichnis_oeffnen']['bootstrap'];
          $liste['element']['link'] = $this->data['titel']['id'].$pfad.'/'.$verzeichnis;
          $this->data['liste'] = $liste; $this->load->view('templates/liste_element', $this->data); unset($liste['element']);
        }
        if( !empty($verzeichnis_inhalt_unterverzeichnisse) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_fuss', $this->data); unset($liste); }
      }

      if( array_key_exists( '_stimmen', $verzeichnis_inhalt) ) {
        $this->load->view('templates/horizontale_linie', $this->data);
        $this->data['ueberschrift'] = 'Stimmen'; $this->load->view('templates/ueberschrift', $this->data);
        $liste = array(); if( !empty($verzeichnis_inhalt['_stimmen']) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_kopf', $this->data); unset($liste['kopf']); }
        foreach( $verzeichnis_inhalt['_stimmen'] as $stimme ) {
          $liste['element']['beschriftung'] = $stimme['element'];
          $liste['element']['small'] = date( 'd.m.Y H:i', intval($stimme['letzte_aenderung']) );
          $liste['element']['symbol'] = SYMBOLE['noten']['bootstrap'];
          $liste['element']['link'] = $pfad_titel_nr.$pfad.'/'.$stimme['element'];
          $this->data['liste'] = $liste; $this->load->view('templates/liste_element', $this->data); unset($liste['element']);
        }
        if( !empty($verzeichnis_inhalt['_stimmen']) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_fuss', $this->data); unset($liste); }
      }

      if( array_key_exists( '_audio', $verzeichnis_inhalt) ) {
        $this->load->view('templates/horizontale_linie', $this->data);
        $this->data['ueberschrift'] = 'Audios'; $this->load->view('templates/ueberschrift', $this->data);
        $liste = array(); if( !empty($verzeichnis_inhalt['_audio']) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_kopf', $this->data); unset($liste['kopf']); }
        foreach( $verzeichnis_inhalt['_audio'] as $audio ) {
          $liste['element']['beschriftung'] = $audio['element'];
          $liste['element']['small'] = date( 'd.m.Y H:i', intval($audio['letzte_aenderung']) );
          $liste['element']['symbol'] = SYMBOLE['play']['bootstrap'];
          $liste['element']['link'] = $pfad_titel_nr.$pfad.'/'.$audio['element'];
          $this->data['liste'] = $liste; $this->load->view('templates/liste_element', $this->data); unset($liste['element']);
        }
        if( !empty($verzeichnis_inhalt['_audio']) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_fuss', $this->data); unset($liste); }
      }

      $this->data['links'][] = array( 'ziel' => site_url().CONTROLLER.'/bewertung_notenverzeichnis', 'symbol' => CONTROLLER_INT['umfragen']['symbol'] );
    
      $this->load->view('templates/footer', $this->data);
    }
  }

  //------------------------------------------------------------------------------------------------------------------
  public function eintragen() {
    if ( !in_array( '-m', ICH['rechte'] ) ) $this->standard_404(); else {
      $this->form_validation->set_rules('titel_nr', NOTENVERZEICHNIS_KATEGORIEN['titel_nr']['beschriftung'], 'required|numeric');
      $this->form_validation->set_rules('titel', NOTENVERZEICHNIS_KATEGORIEN['titel']['beschriftung'], 'required|callback_fv_standard_textzeile');
      $this->form_validation->set_rules('titel_id', 'Titel-ID', 'numeric');
      if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE ); else {

        $titel = array(
          'zeitpunkt' => time(),
          'titel_nr' => intval($this->input->post('titel_nr')),
          'titel' => $this->input->post('titel'),
        );
        
        if( !empty($this->input->post('titel_id')) ) {               // Titel wird geändert
          $titel['id'] = intval($this->input->post('titel_id'));
          if( $this->notenbank_model->notenbank_notenverzeichnis( $titel['id'] )['titel_nr'] != $titel['titel_nr'] AND !empty($this->notenbank_model->notenbank_notenverzeichnis( NULL, array( 'titel_nr' => $titel['titel_nr'] ) )) )
            status_feuern( 'danger', 'Diese Titel-Nr ist bereits belegt!', FALSE );
          elseif( $this->notenbank_model->notenbank_titel_db_aktualisieren( $titel ) ) status_feuern( 'success', 'Titel'.STATUSMELDUNGEN['speichern_erfolgreich']['meldung'], FALSE );
          else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );

        } else {                                                      // Titel wird neu erstellt
          if( !empty($this->notenbank_model->notenbank_notenverzeichnis( NULL, array( 'titel_nr' => $titel['titel_nr'] ) )) )
            status_feuern( 'danger', 'Diese Titel-Nr ist bereits belegt!', FALSE );
          elseif( $this->notenbank_model->notenbank_titel_eintragen( $titel ) ) status_feuern( 'success', 'Titel'.STATUSMELDUNGEN['speichern_erfolgreich']['meldung'], FALSE );
          else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
        }
      }

      redirect(ABSPRUNG);
    }
  }

  public function austragen() {
    if ( !in_array( '-n', ICH['rechte'] ) ) $this->standard_404(); else {
      $this->form_validation->set_rules( 'element_id', 'Titel-ID', 'required|numeric' );
      if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE ); else {
        $titel = $this->notenbank_model->notenbank_notenverzeichnis( intval($this->input->post('element_id')) );
        $titel['archiv'] = 1;
        if( $this->notenbank_model->notenbank_titel_db_aktualisieren( $titel ) ) status_feuern( 'danger', 'Titel'.STATUSMELDUNGEN['loeschen_erfolgreich']['meldung'], FALSE );
        else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
      }
      redirect(ABSPRUNG);
    }
  }

  //------------------------------------------------------------------------------------------------------------------
  public function bewertung_notenverzeichnis() {
    $bewertung = array(
      'titel' => 'Bewertung der Notenmappe',
      'db_tabelle' => 'bewertung_notenverzeichnis',
      'initialbewertung' => 0,
      'verfuegbare_werte' => array(
        -1 => array( 'farbe' => 'danger', 'beschriftung' => '<i class="bi bi-dash-circle"></i>' ),
        0 => array( 'farbe' => 'primary', 'beschriftung' => '<i class="bi bi-circle"></i>' ),
        1 => array( 'farbe' => 'success', 'beschriftung' => '<i class="bi bi-plus-circle"></i>' ),
      ),
    );
    $this->load->library('bewertung', $bewertung);

    $this->form_validation->set_rules('objekt_id', 'Objekt-ID', 'required|numeric');
    $this->form_validation->set_rules('wert', 'Wert', 'required|numeric');
    if ( !$this->form_validation->run() ) {

      $this->data['verfuegbare_werte'] = $this->bewertung->verfuegbare_werte;
      $notenbank_notenverzeichnis = $this->notenbank_model->notenbank_notenverzeichnis();

      if( !empty($notenbank_notenverzeichnis) ) $this->load->view('templates/tabelle_kopf', $this->data);
      foreach( $notenbank_notenverzeichnis as $this->data['titel'] ) {

        $this->data['objekt_id'] = intval( $this->data['titel']['id'] );

        $this->data['bewertungen_cluster_objekt'] = array();
        foreach( $this->data['verfuegbare_werte'] as $wert => $verfuegbarer_wert) {
          $this->data['bewertungen_cluster_objekt'][ $wert ] = $this->bewertung->bewertungen( NULL, array( 'objekt_id' => $this->data['objekt_id'], 'wert' => $wert ) );
        }

        $this->data['gesamtanzahl'] = 0;
        $this->data['gesamtbewertung'] = $this->bewertung->initialbewertung;
        foreach( $this->data['bewertungen_cluster_objekt'] as $wert => $bewertung ) {
          $anzahl = count( $bewertung );
          $this->data['gesamtbewertung'] += $wert*$anzahl;
          $this->data['gesamtanzahl'] += $anzahl;
        }

        $meine_bewertungen = $this->bewertung->bewertungen( NULL, array( 'objekt_id' => $this->data['objekt_id'], 'mitglied_id' => ICH['id'] ) );
        if( !empty($meine_bewertungen) ) $this->data['von_mir_bewertet'] = intval( $meine_bewertungen[ array_key_last( $meine_bewertungen ) ]['wert'] ); else $this->data['von_mir_bewertet'] = NULL;

        $this->load->view('bewertung/notenverzeichnis', $this->data);
      }
      if( !empty($notenbank_notenverzeichnis) ) $this->load->view('templates/tabelle_fuss', $this->data);

      $this->data['links'][] = array( 'ziel' => site_url().CONTROLLER, 'symbol' => SYMBOLE['ebene_hoch']['bootstrap'] );
      //if( in_array( '-e', ICH['rechte'] ) ) $this->data['links'][] = array( 'ziel' => site_url().CONTROLLER.'/bewertung_notenverzeichnis_bereinigen', 'symbol' => 'pie-chart' );
    }
    else {
      $bewertung = array(
        'zeitpunkt' => time(),
        'objekt_id' => intval($this->input->post('objekt_id')),
        'wert' => intval($this->input->post('wert')),
        'mitglied_id' => intval(ICH['id']),
      );
      if( $this->bewertung->bewerten( $bewertung ) ) redirect(ABSPRUNG);
    }
    $this->load->view('templates/footer', $this->data);
  }

}
