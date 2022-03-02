<?php
class Termine extends Vereinsapp_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('termine_model');

    if( !isset( $this->session->termine_sortieren ) OR empty( $this->session->termine_sortieren ) )
      $this->session->termine_sortieren = array_values( array( array( 'kategorie' => $this->einstellungen_model->standard_einstellung( 'termine', 'sortieren_nach', ICH['id'] ), 'richtung' => SORT_ASC ) ) );
  }

  public function index() { //$this->session->sess_destroy();
    $sortieren = $this->session->termine_sortieren;
    $filtern = array(); $parameter = array();
    if( isset( $this->session->termine_filtern ) AND !empty( $this->session->termine_filtern ) ) {
      foreach( $this->session->termine_filtern as $filter )
        $parameter[ $filter['kategorie'] ] = $this->parameter_aus_filter( TERMINE_FILTERBARE_KATEGORIEN, $filter, $this->termine_model->termine(), TERMINE_KATEGORIEN_DB );
      $filtern = $this->session->termine_filtern;
    }

    $termine = $this->termine_model->termine( NULL, $parameter, termine_kategorie_sortierkorrektur( $sortieren ) );

    $liste = array( 'beschriftung_h5' => TRUE, /*'sortable' => TRUE*/ ); //$position = 1;
    if( !empty($termine) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_kopf', $this->data); unset($liste['kopf']); }
    foreach( $termine as $this->data['termin'] ) {
      //$liste['element']['id'] = $mitglied['id']; $liste['element']['sortable'] = TRUE; $liste['element']['position'] = $position; $position++;
      $liste['element']['symbol'] = SYMBOLE['info']['bootstrap'];
      $liste['element']['link'] = CONTROLLER.'/details/'.$this->data['termin']['id'];

      if( in_array( '-t', ICH['rechte'] ) ) {
        $this->data['eintragen']['termine'][ intval($this->data['termin']['id']) ] = $this->data['termin'];
        if( $this->data['termin']['start'] > time() ) $this->data['austragen']['termine'][ intval($this->data['termin']['id']) ] = $this->data['termin'];
        if( $this->data['termin']['start'] > time() ) { $this->data['austragen']['id'] = 'termin_austragen'; $this->data['austragen']['elemente'][ intval($this->data['termin']['id']) ] = array( 'beschriftung' => $this->data['termin']['titel'].' ('.TERMINE_KATEGORIEN['start']['beschriftung'].': '.date( 'd.m.Y H:i', $this->data['termin']['start'] ).')' ); }

        $this->data['liste_element_werkzeugkasten'] = array( 'id' => $this->data['termin']['id'], 'werkzeugkasten' => array(), );
        if( $this->data['termin']['start'] > time() ) $this->data['liste_element_werkzeugkasten']['werkzeugkasten'][] = array( 'ziel' => $this->data['austragen']['id'], 'symbol' => SYMBOLE['loeschen']['bootstrap'], 'farbe' => 'danger', 'data' => array( 'element_id' => intval($this->data['termin']['id']), ), );
        $this->data['liste_element_werkzeugkasten']['werkzeugkasten'][] = array( 'ziel' => 'termin_eintragen', 'symbol' => SYMBOLE['duplizieren']['bootstrap'], 'data' => array( 'termin_id' => intval($this->data['termin']['id']), 'aktion' => 'duplizieren', ), );
        if( $this->data['termin']['start'] > time() ) $this->data['liste_element_werkzeugkasten']['werkzeugkasten'][] = array( 'ziel' => 'termin_eintragen', 'symbol' => SYMBOLE['aendern']['bootstrap'], 'data' => array( 'termin_id' => intval($this->data['termin']['id']), 'aktion' => 'aendern', ), );
        $this->data['liste_element_werkzeugkasten'] = $this->load->view('templates/liste_element_werkzeugkasten', $this->data, TRUE);
      }

      if( !empty( $this->mitglieder_model->mitglieder_abwesenheiten( NULL, array( 'mitglied_id' => ICH['id'], 'start<=' => $this->data['termin']['start'], 'ende>=' => $this->data['termin']['start'] ) ) ) )
        $this->data['termin']['ich_abwesend'] = TRUE; else $this->data['termin']['ich_abwesend'] = FALSE;
      $ich_rueckmeldungen = $this->termine_model->termine_rueckmeldungen( NULL, array( 'termin_id' => $this->data['termin']['id'], 'mitglied_id' => ICH['id'] ) );
      if( !empty($ich_rueckmeldungen) ) $this->data['ich_rueckmeldung'][ $this->data['termin']['id'] ] = $ich_rueckmeldungen[ array_key_last( $ich_rueckmeldungen ) ];
      $this->data['rueckmeldung_machen'] = $this->load->view('termine/rueckmeldung_machen', $this->data, TRUE);

      $this->data['liste'] = $liste; $this->load->view('termine/termine', $this->data); unset($liste['element']);
    }
    if( !empty($termine) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_fuss', $this->data); unset($liste); }
    if( !empty($termine) AND TERMINE_RUECKMELDUNG_DETAIL_FREWILLIG ) { $this->data['termine'] = $termine; $this->data['rueckmeldung_machen_detail_modal'] = 1; $this->load->view('termine/rueckmeldung_machen_detail_modal', $this->data); }
    if( !empty($termine) AND (TERMINE_RUECKMELDUNG_DETAIL_FREWILLIG OR TERMINE_RUECKMELDUNG_DETAIL_ABSAGE ) ) { $this->data['termine'] = $termine; $this->data['rueckmeldung_machen_detail_modal'] = 0; $this->load->view('termine/rueckmeldung_machen_detail_modal', $this->data); }
  
    if( in_array( '-t', ICH['rechte'] ) ) {
      $this->data['werkzeugkasten'][] = array( 'ziel' => 'termin_eintragen',  'symbol' => SYMBOLE['hinzufuegen']['bootstrap'], 'data' => array( 'aktion' => 'eintragen', ) );

      $this->data['eintragen']['form'] = site_url().CONTROLLER.'/eintragen';
      $this->data['eintragen']['titel'] =  array( 'eintragen' => 'Termin eintragen', 'duplizieren' => 'Termin duplizieren', 'aendern' => 'Termin ändern', );
      $this->data['eintragen']['submit'] = array( 'eintragen' => 'Termin speichern', 'duplizieren' => 'Termin speichern', 'aendern' => 'Speichern', );
      $this->load->view('termine/eintragen_modal', $this->data);

      $this->data['austragen']['form'] = site_url().CONTROLLER.'/austragen';
      $this->data['austragen']['titel'] = 'Termin';
      //$this->data['austragen']['submit'] = array( 'austragen' => 'Termin löschen', );
      if( !empty($termine) ) $this->load->view('templates/austragen_modal', $this->data);
    }

    $this->data['filtern'] = $filtern; $this->data['sortieren'] = $sortieren;
    //$this->data['werkzeugkasten'][] = array( 'typ' => 'modal', 'ziel' => CONTROLLER.'_filtern', 'symbol' => SYMBOLE['filtern']['bootstrap'] );
    //$this->data['view'] = array( 'filterbare_kategorien' => TERMINE_FILTERBARE_KATEGORIEN, 'kategorien' => TERMINE_KATEGORIEN, 'objekte' => $this->termine_model->termine() ); $this->load->view('templates/filtern', $this->data);
    $this->data['werkzeugkasten'][] = array( 'typ' => 'modal', 'ziel' => CONTROLLER.'_sortieren', 'symbol' => SYMBOLE['sortieren']['bootstrap'] );
    $this->data['view'] = array( 'sortierbare_kategorien' => TERMINE_SORTIERBARE_KATEGORIEN, 'kategorien' => TERMINE_KATEGORIEN ); $this->load->view('templates/sortieren', $this->data);

    $this->data['werkzeugkasten'][] = array( 'ziel' => 'einstellungen', 'symbol' => SYMBOLE['einstellungen']['bootstrap'] );
    $this->data['einstellungen'] = array( 'termine' => array( 'vergangen_anzeigen' => NULL, 'ich_beschr_anzeigen' => NULL, 'sortieren_nach' => NULL, ), );
    foreach( $this->data['einstellungen'] as $gruppe => $funktionen ) foreach( $funktionen as $funktion => $wert )
      $this->data['einstellungen'][ $gruppe ][ $funktion ] = $this->einstellungen_model->standard_einstellung( $gruppe, $funktion, ICH['id'] );
    $this->load->view('einstellungen/einstellungen_modal', $this->data);

    $this->load->view('templates/footer', $this->data);
  }

  //------------------------------------------------------------------------------------------------------------------
  public function sortieren( $kategorie ) {
    $sortieren = array( array( 'kategorie' => urldecode( $kategorie ), 'richtung' => SORT_ASC ) );
    $this->session->termine_sortieren = array_values($sortieren);
    redirect(ABSPRUNG);
  }

  public function sortieren_hinzu( $kategorie ) {
    $sortieren = $this->session->termine_sortieren; if( !is_array($sortieren) ) $sortieren = array();
    $sortieren[] = array( 'kategorie' => urldecode( $kategorie ), 'richtung' => SORT_ASC );
    $this->session->termine_sortieren = array_values($sortieren);
    redirect(ABSPRUNG);
  }

  public function sortieren_umkehren( $kategorie ) {
    $sortieren = $this->session->termine_sortieren; if( !is_array($sortieren) ) $sortieren = array();
    foreach( $sortieren as $prioritaet => $reihenfolge )
      if( urldecode( $kategorie ) == $reihenfolge['kategorie'] ) if( $reihenfolge['richtung'] == SORT_DESC ) $sortieren[ $prioritaet ]['richtung'] = SORT_ASC; else $sortieren[ $prioritaet ]['richtung'] = SORT_DESC;
    $this->session->termine_sortieren = array_values($sortieren);
    redirect(ABSPRUNG);
  }

  public function sortieren_loeschen( $kategorie ) {
    $sortieren = $this->session->termine_sortieren; if( !is_array($sortieren) ) $sortieren = array();
    foreach( $sortieren as $prioritaet => $reihenfolge )
      if( urldecode( $kategorie ) == $reihenfolge['kategorie'] ) unset( $sortieren[ $prioritaet ] );
    $this->session->termine_sortieren = array_values($sortieren);
    redirect(ABSPRUNG);
  }

  public function filtern_hinzu( $kategorie, $filter1 = NULL, $filter2 = NULL ) {
    if( is_null($filter1) ) {
      if( in_array( TERMINE_FILTERBARE_KATEGORIEN[ urldecode( $kategorie ) ], array( 'verfuegbare_werte', 'vorgegebene_werte' ) ) ) {
        $this->form_validation->set_rules( $kategorie.'_filter1', TERMINE_KATEGORIEN[ $kategorie ]['beschriftung'].'-Wert', 'required|callback_fv_standard_textzeile');
        if ( !$this->form_validation->run() ) redirect(ABSPRUNG); else {
          $filter1 = $this->input->post($kategorie.'_filter1');
        }
      } elseif( in_array( TERMINE_FILTERBARE_KATEGORIEN[ urldecode( $kategorie ) ], array( 'zeitraum', 'zeitraum_jahr' ) ) ) {
        $this->form_validation->set_rules( $kategorie.'_filter1', TERMINE_KATEGORIEN[ $kategorie ]['beschriftung'].'-Start', 'required|callback_fv_datum_zeit');
        $this->form_validation->set_rules( $kategorie.'_filter2', TERMINE_KATEGORIEN[ $kategorie ]['beschriftung'].'-Ende', 'required|callback_fv_datum_zeit');
        if ( !$this->form_validation->run() ) redirect(ABSPRUNG); else {
          $filter1 = strtotime( $this->input->post($kategorie.'_filter1') );
          $filter2 = strtotime( $this->input->post($kategorie.'_filter2') );
        }
      } elseif( in_array( TERMINE_FILTERBARE_KATEGORIEN[ urldecode( $kategorie ) ], array( 'zahlenraum' ) ) ) {
        $this->form_validation->set_rules( $kategorie.'_filter1', TERMINE_KATEGORIEN[ $kategorie ]['beschriftung'].'-Start', 'required|numeric');
        $this->form_validation->set_rules( $kategorie.'_filter2', TERMINE_KATEGORIEN[ $kategorie ]['beschriftung'].'-Ende', 'required|numeric');
        if ( !$this->form_validation->run() ) redirect(ABSPRUNG); else {
          $filter1 = intval( $this->input->post($kategorie.'_filter1') );
          $filter2 = intval( $this->input->post($kategorie.'_filter2') ); 
        }
      }
    }
    $filtern = $this->session->termine_filtern; if( !is_array($filtern) ) $filtern = array();
    foreach( $filtern as $prioritaet => $filter ) if( urldecode( $kategorie ) == $filter['kategorie'] ) unset( $filtern[ $prioritaet ] );
    if( in_array( TERMINE_FILTERBARE_KATEGORIEN[ urldecode( $kategorie ) ], array( 'zeitraum', 'zeitraum_jahr', 'zahlenraum' ) ) ) $filter = array( 'start' => $filter1, 'ende' => $filter2, ); else $filter = $filter1;
    $filtern[] = array( 'kategorie' => urldecode( $kategorie ), 'filter' => $filter );
    $this->session->termine_filtern = array_values($filtern);
    redirect(ABSPRUNG);
  }

  public function filtern_loeschen( $kategorie ) {
    $filtern = $this->session->termine_filtern; if( !is_array($filtern) ) $filtern = array();
    foreach( $filtern as $prioritaet => $filter ) if( urldecode( $kategorie ) == $filter['kategorie'] ) unset( $filtern[ $prioritaet ] );
    $this->session->termine_filtern = array_values($filtern);
    redirect(ABSPRUNG);
  }

  //------------------------------------------------------------------------------------------------------------------
  public function details( $id ) {
    $alle_termine = $this->termine_model->alle_termine();
    if( !array_key_exists( intval($id), $alle_termine ) ) redirect(CONTROLLER); else {

      $this->data['termin'] = $alle_termine[ intval($id) ];
      $termine = $this->termine_model->termine();

      $this->data['vorheriger_termin'] = FALSE; $this->data['naechster_termin'] = FALSE;
      $termine_ids = array_column( $termine, 'id' ); if( in_array( $this->data['termin']['id'], $termine_ids ) ) {
        $position = array_search( $this->data['termin']['id'], $termine_ids );
        if( $this->data['termin']['id'] != array_key_first($termine) ) $this->data['vorheriger_termin'] = $termine[ $termine_ids[ $position-1 ] ];
        if( $this->data['termin']['id'] != array_key_last($termine) ) $this->data['naechster_termin'] = $termine[ $termine_ids[ $position+1 ] ];
      }

      if( !empty( $this->mitglieder_model->mitglieder_abwesenheiten( NULL, array( 'mitglied_id' => ICH['id'], 'start<=' => $this->data['termin']['start'], 'ende>=' => $this->data['termin']['start'] ) ) ) )
        $this->data['termin']['ich_abwesend'] = TRUE; else $this->data['termin']['ich_abwesend'] = FALSE;
      $ich_rueckmeldungen = $this->termine_model->termine_rueckmeldungen( NULL, array( 'termin_id' => $this->data['termin']['id'], 'mitglied_id' => ICH['id'] ) );
      if( !empty($ich_rueckmeldungen) ) $this->data['ich_rueckmeldung'][ $this->data['termin']['id'] ] = $ich_rueckmeldungen[ array_key_last( $ich_rueckmeldungen ) ];
      $this->data['rueckmeldung_machen'] = $this->load->view('termine/rueckmeldung_machen', $this->data, TRUE);
      $this->load->view('termine/details', $this->data);

      $this->data['mitglieder_gruppieren_nach'] = $this->einstellungen_model->standard_einstellung( 'mitglieder', 'gruppieren_nach', ICH['id'] );
      $mitglieder_cluster = MITGLIEDER; foreach( $mitglieder_cluster as $mitglied ) foreach( $this->data['termin']['beschr_mitglieder'] as $beschr_kategorie => $beschr_werte ) if( in_array( $mitglied[ $beschr_kategorie ], $beschr_werte ) ) unset( $mitglieder_cluster[ intval($mitglied['id']) ] );
      $this->data['mitglieder_cluster'] = tabelle_clustern( $mitglieder_cluster, $this->data['mitglieder_gruppieren_nach'] );
      $rueckmeldungen = $this->termine_model->termine_rueckmeldungen( NULL, array( 'termin_id' => $this->data['termin']['id'] ) );
      $this->data['termin']['rueckmeldungen_cluster'] = $this->termine_model->termine_rueckmeldungen_cluster( NULL, $this->data['mitglieder_gruppieren_nach'], $rueckmeldungen, $mitglieder_cluster );
      $this->load->view('termine/rueckmeldungen', $this->data);

      if( in_array( 'notenbank', AKTIVE_CONTROLLER ) AND TERMINE_SETLISTS AND in_array( $this->data['termin']['typ'], TERMINE_SETLISTS_TYPEN ) ) { $this->load->model('notenbank_model');
        $this->data['ueberschrift'] = 'Setlist'; $this->load->view('templates/ueberschrift', $this->data);
        $liste = array(); if( in_array( '-t', ICH['rechte'] ) ) $liste = array( 'sortable' => TRUE, 'form' => site_url().CONTROLLER.'/setlist_speichern' ); //$position = 1;
        $this->data['liste'] = $liste; $this->load->view('templates/liste_kopf', $this->data); unset($liste['kopf']);
        foreach( $this->data['termin']['setlist'] as $liste['element']['position'] => $liste['element']['id'] ) {
          if( in_array( '-t', ICH['rechte'] ) ) { $liste['element']['sortable'] = TRUE; }//$position; $position++; }
          $titel = $this->notenbank_model->notenbank_notenverzeichnis( intval($liste['element']['id']) );
          $liste['element']['beschriftung'] = $titel['titel_nr'].' '.$titel['titel'];
          $verzeichnis_meta = $this->notenbank_model->notenbank_verzeichnis_meta( $this->notenbank_model->notenbank_titel_nr_inhalt( $titel['titel_nr'] ) );
          if( $verzeichnis_meta['anzahl_unterverzeichnisse'] > 0 OR $verzeichnis_meta['anzahl_stimmen'] > 0 OR $verzeichnis_meta['anzahl_audio'] > 0 ) {
            $liste['element']['link'] = site_url().'notenbank/titel/'.$titel['id'];
            $liste['element']['symbol'] = SYMBOLE['noten']['bootstrap'];
          }
          $this->data['liste'] = $liste; $this->load->view('templates/liste_element', $this->data); unset($liste['element']);
        }
        if( in_array( '-t', ICH['rechte'] ) ) {
          if( empty($this->data['termin']['setlist']) ) $this->data['setlist_werkzeuge']['auswaehlen_symbol'] = SYMBOLE['hinzufuegen']['bootstrap'];
          else $this->data['setlist_werkzeuge']['auswaehlen_symbol'] = SYMBOLE['noten']['bootstrap'];
          $liste['fuss_werkzeugkasten'] = $this->load->view('termine/setlist_werkzeuge', $this->data, TRUE);
        } $this->data['liste'] = $liste; $this->load->view('templates/liste_fuss', $this->data); unset($liste);
        

        if( in_array( '-t', ICH['rechte'] ) ) {
          $notenverzeichnis_auswaehlen_checked = array(); foreach( $this->data['termin']['setlist'] as $setlist_titel_id ) $notenverzeichnis_auswaehlen_checked[ $setlist_titel_id ] = TRUE;
          $this->data['notenverzeichnis_auswaehlen'] = array(
            'ziel' => site_url().CONTROLLER.'/setlist_titel_auswaehlen',
            'beschriftung' => 'Auswahl speichern',
            'notenverzeichnis' => $this->notenbank_model->notenbank_notenverzeichnis(),
            //'notenverzeichnis_cluster' => $this->data['notenverzeichnis_cluster'],
            //'notenverzeichnis_gruppieren_nach' => $this->data['notenverzeichnis_gruppieren_nach'],
            'elemente' => array(
              $this->data['termin']['id'] => array(
                'bemerkung' => 'Zur Setlist hinzufügen',
                'checked' => $notenverzeichnis_auswaehlen_checked,
                'css' => array(),
              ),
            )
          );
          $this->load->view('notenbank/notenverzeichnis_auswaehlen_modal', $this->data);
        }
      }
      
      if( TERMINE_RUECKMELDUNG_DETAIL_FREWILLIG ){ $this->data['rueckmeldung_machen_detail_modal'] = 1; $this->load->view('termine/rueckmeldung_machen_detail_modal', $this->data); }
      if( TERMINE_RUECKMELDUNG_DETAIL_FREWILLIG OR TERMINE_RUECKMELDUNG_DETAIL_ABSAGE ){ $this->data['rueckmeldung_machen_detail_modal'] = 0; $this->load->view('termine/rueckmeldung_machen_detail_modal', $this->data); }

      if( in_array( '-t', ICH['rechte'] ) AND $this->data['termin']['start'] > time() ) {
        $this->data['austragen']['termine'][ intval($this->data['termin']['id']) ] = $this->data['termin'];
        $this->data['austragen']['id'] = 'termin_austragen'; $this->data['austragen']['elemente'][ intval($this->data['termin']['id']) ] = array( 'beschriftung' => $this->data['termin']['titel'].' ('.TERMINE_KATEGORIEN['start']['beschriftung'].': '.date( 'd.m.Y H:i', $this->data['termin']['start'] ).')' );
        $this->data['austragen']['form'] = site_url().CONTROLLER.'/austragen';
        $this->data['austragen']['titel'] = 'Termin';
        //$this->data['austragen']['submit'] = array( 'austragen' => 'Termin löschen', );
        $this->load->view('templates/austragen_modal', $this->data);
        $this->data['werkzeugkasten'][] = array( 'ziel' => $this->data['austragen']['id'], 'symbol' => SYMBOLE['loeschen']['bootstrap'], 'farbe' => 'danger', 'data' => array( 'element_id' => intval($this->data['termin']['id']), ), );
      }

      if( in_array( '-t', ICH['rechte'] ) ) {
        $this->data['eintragen']['form'] = site_url().CONTROLLER.'/eintragen';
        $this->data['eintragen']['termine'][ intval($this->data['termin']['id']) ] = $this->data['termin'];

        $this->data['eintragen']['titel']['duplizieren'] =  'Termin duplizieren';
        $this->data['eintragen']['submit']['duplizieren'] = 'Termin speichern';
        $this->data['werkzeugkasten'][] = array( 'ziel' => 'termin_eintragen', 'symbol' => SYMBOLE['duplizieren']['bootstrap'], 'data' => array( 'termin_id' => intval($this->data['termin']['id']), 'aktion' => 'duplizieren', ), );

        if( $this->data['termin']['start'] > time() ) {
          $this->data['eintragen']['titel']['aendern'] =  'Termin ändern';
          $this->data['eintragen']['submit']['aendern'] = 'Speichern';
          $this->data['werkzeugkasten'][] = array( 'ziel' => 'termin_eintragen', 'symbol' => SYMBOLE['aendern']['bootstrap'], 'data' => array( 'termin_id' => intval($this->data['termin']['id']), 'aktion' => 'aendern', ), );
        }
        $this->load->view('termine/eintragen_modal', $this->data);
      }
      
      if( in_array( '-t', ICH['rechte'] ) OR $this->data['termin']['beschr_mitglieder'] != VORGEGEBENE_WERTE['termine']['typ'][ $this->data['termin']['typ'] ]['beschr_mitglieder_standard'] ) {
        $this->data['werkzeugkasten'][] = array( 'ziel' => 'beschraenkungen', 'symbol' => CONTROLLER_INT_EXT['mitglieder']['symbol'] );
        if( in_array( '-t', ICH['rechte'] ) AND $this->data['termin']['start'] > time() ) $this->data['beschraenkungen']['ziel'] = site_url().CONTROLLER.'/beschraenkungen_speichern';
        $this->load->view('termine/beschraenkungen_modal', $this->data);
      }

      $this->data['werkzeugkasten'][] = array( 'ziel' => 'mitglieder_auswaehlen', 'symbol' => 'person-check', 'data' => array( 'element_id' => $this->data['termin']['id'], ) );
      $mitglieder_auswaehlen_checked = array(); foreach( $this->termine_model->termine_anwesenheiten( NULL, array( 'termin_id' => intval($id), ) ) as $anwesenheit )
        $mitglieder_auswaehlen_checked[ $anwesenheit['mitglied_id'] ] = TRUE;
      $mitglieder_auswaehlen_css = array(); foreach( $this->termine_model->termine_rueckmeldungen( NULL, array( 'termin_id' => intval($id), ) ) as $rueckmeldung )
        if( $rueckmeldung['status'] >= 1 ) $mitglieder_auswaehlen_css[ $rueckmeldung['mitglied_id'] ] = 'text-success'; else $mitglieder_auswaehlen_css[ $rueckmeldung['mitglied_id'] ] = 'text-danger';
      $this->data['mitglieder_auswaehlen'] = array(
        'beschriftung' => 'Auswahl speichern',  // meistens immer gleich -> STRING
        'mitglieder_cluster' => $this->data['mitglieder_cluster'],  // immer gleich -> ARRAY nach mitglied_id
        'mitglieder_gruppieren_nach' => $this->data['mitglieder_gruppieren_nach'],  // immer gleich -> STRING
        'elemente' => array(
          $this->data['termin']['id'] => array( // = element_id -> NUM
            'bemerkung' => 'Anwesenheit zum Termin',  // diesmal immer gleich -> STRING
            'checked' => $mitglieder_auswaehlen_checked,  // diesmal immer gleich -> ARRAY nach mitglied_id
            'css' => $mitglieder_auswaehlen_css,  // diesmal immer gleich -> ARRAY nach mitglied_id    
          ),
        )
      );
      if( TERMINE_ANWESENHEITSKONTROLLE AND in_array( '-a', ICH['rechte'] ) ) $this->data['mitglieder_auswaehlen']['form'] = site_url().CONTROLLER.'/anwesenheit_kontrollieren';
      $this->load->view('mitglieder/mitglieder_auswaehlen_modal', $this->data);

      $this->data['werkzeugkasten'][] = array( 'ziel' => 'einstellungen', 'symbol' => SYMBOLE['einstellungen']['bootstrap'] );
      $this->data['einstellungen'] = array( 'mitglieder' => array( 'sortieren_nach' => NULL, 'gruppieren_nach' => NULL, ), );
      foreach( $this->data['einstellungen'] as $gruppe => $funktionen ) foreach( $funktionen as $funktion => $wert )
        $this->data['einstellungen'][ $gruppe ][ $funktion ] = $this->einstellungen_model->standard_einstellung( $gruppe, $funktion, ICH['id'] );
      $this->load->view('einstellungen/einstellungen_modal', $this->data);

      $this->data['links'][] = array( 'ziel' => site_url().CONTROLLER, 'symbol' => SYMBOLE['ebene_hoch']['bootstrap'] );

      $this->load->view('templates/footer', $this->data);
    }
  }

  //------------------------------------------------------------------------------------------------------------------
  public function eintragen() {
    if ( !in_array( '-t', ICH['rechte'] ) ) $this->standard_404(); else {
      $this->form_validation->set_rules('titel', TERMINE_KATEGORIEN['titel']['beschriftung'], 'required|callback_fv_standard_textzeile');
      $this->form_validation->set_rules('start_datum', TERMINE_KATEGORIEN['start']['beschriftung'].' Datum', 'required|callback_fv_datum');
      $this->form_validation->set_rules('start_zeit', TERMINE_KATEGORIEN['start']['beschriftung'].' Zeit', 'required|callback_fv_zeit');
      $this->form_validation->set_rules('ort', TERMINE_KATEGORIEN['ort']['beschriftung'], 'required|callback_fv_standard_textzeile');
      if( array_key_exists( 'organisator', TERMINE_KATEGORIEN ) ) $this->form_validation->set_rules('organisator', TERMINE_KATEGORIEN['organisator']['beschriftung'], 'callback_fv_standard_textzeile');
      if( array_key_exists( 'bemerkung', TERMINE_KATEGORIEN ) ) $this->form_validation->set_rules('bemerkung', TERMINE_KATEGORIEN['bemerkung']['beschriftung'], 'callback_fv_standard_textzeile');
      $this->form_validation->set_rules('typ', TERMINE_KATEGORIEN['typ']['beschriftung'], 'required|callback_fv_standard_textzeile');
      $this->form_validation->set_rules('beschr_mitglieder', TERMINE_KATEGORIEN['beschr_mitglieder']['beschriftung'], 'regex_match[/beschr_mitglieder/]');
      $this->form_validation->set_rules('termin_id_beschr_mitglieder', 'Termin-ID', 'numeric');
      $this->form_validation->set_rules('termin_id', 'Termin-ID', 'numeric');
      if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE ); else {

        $termin['zeitpunkt'] = time();
        $termin['titel'] = $this->input->post('titel');
        $termin['start'] = strtotime( $this->input->post('start_datum').' '.$this->input->post('start_zeit') );
        $termin['ort'] = $this->input->post('ort');
        if( array_key_exists( 'organisator', TERMINE_KATEGORIEN ) ) $termin['organisator'] = $this->input->post('organisator');
        if( array_key_exists( 'bemerkung', TERMINE_KATEGORIEN ) ) $termin['bemerkung'] = $this->input->post('bemerkung');
        $termin['typ'] = $this->input->post('typ');

        if( !empty($this->input->post('termin_id')) ) {               // Termin wird geändert
          $termin['id'] = intval($this->input->post('termin_id'));
          if( $termin['start'] < time() ) status_feuern( 'danger', 'Du kannst diesen Termin nicht ändern, weil neues Datum und Uhrzeit in der Vergangenheit liegen!', FALSE );
          elseif( $this->termine_model->alle_termine( $termin['id'] )['start'] < time() )
            status_feuern( 'danger', 'Du kannst diesen Termin nicht ändern, weil der Termin bereits begonnen hat oder in der Vergangenheit liegt!', FALSE );
          elseif( $this->termine_model->termin_db_aktualisieren( $termin ) ) status_feuern( 'success', 'Termin'.STATUSMELDUNGEN['speichern_erfolgreich']['meldung'], FALSE );
          else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );

        } else {                                                      // Termin wird neu erstellt
          if( !empty($this->input->post('termin_id_beschr_mitglieder')) AND $this->input->post('beschr_mitglieder') ) // Mitglieder-Beschränkung wird mitkopiert
            $termin['beschr_mitglieder'] = $this->termine_model->alle_termine( intval($this->input->post('termin_id_beschr_mitglieder')) )['beschr_mitglieder'];
          if( $termin['start'] < time() ) status_feuern( 'danger', 'Du kannst diesen Termin nicht erstellen, weil Datum und Uhrzeit in der Vergangenheit liegen!', FALSE );
          elseif( $this->termine_model->termin_eintragen( $termin ) ) status_feuern( 'success', 'Termin'.STATUSMELDUNGEN['speichern_erfolgreich']['meldung'], FALSE );
          else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
        }
      }

      redirect(ABSPRUNG);
    }
  }

  public function austragen() {
    if ( !in_array( '-t', ICH['rechte'] ) ) $this->standard_404(); else {
      $this->form_validation->set_rules('element_id', 'Termin-ID', 'required|numeric');
      if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE ); else {
        $termin = $this->termine_model->alle_termine( intval($this->input->post('element_id')) );
        $termin['archiv'] = 1;
        if( $termin['start'] < time() ) status_feuern( 'Du kannst diesen Termin nicht löschen, weil der Termin bereits begonnen hat oder in der Vergangenheit liegt!', FALSE );
        else if( $this->termine_model->termin_db_aktualisieren( $termin ) ) status_feuern( 'danger', 'Termin'.STATUSMELDUNGEN['loeschen_erfolgreich']['meldung'], FALSE );
        else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
      }
      redirect(ABSPRUNG);
    }
  }

  //------------------------------------------------------------------------------------------------------------------
  public function beschraenkungen_speichern() {
    if ( !in_array( '-t', ICH['rechte'] ) ) $this->standard_404(); else {
      foreach( TERMINE_KATEGORIEN_BESCHR_MITGLIEDER as $beschr_kategorie )
        $this->form_validation->set_rules( $beschr_kategorie.'[]', MITGLIEDER_KATEGORIEN[ $beschr_kategorie ]['beschriftung'].'-Beschränkung', 'callback_fv_standard_textzeile');
      $this->form_validation->set_rules('termin_id', 'Termin-ID', 'required|numeric');
      if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE ); else {

        $termin = $this->termine_model->alle_termine()[ intval($this->input->post('termin_id')) ];
        $termin['beschr_mitglieder'] = array(); foreach( TERMINE_KATEGORIEN_BESCHR_MITGLIEDER as $beschr_kategorie )
          foreach( verfuegbare_werte_in_spalte( array_column( MITGLIEDER, $beschr_kategorie ) ) as $wert )
            if( is_null($this->input->post($beschr_kategorie.'[]')) OR !in_array( $wert, $this->input->post($beschr_kategorie.'[]') ) ) $termin['beschr_mitglieder'][ $beschr_kategorie ][] = $wert;

        if( $this->termine_model->alle_termine( intval($termin['id']) )['start'] < time() ) status_feuern( 'Du kannst diesen Termin nicht ändern, weil der Termin bereits begonnen hat oder in der Vergangenheit liegt!', FALSE );
        elseif( $this->termine_model->termin_db_aktualisieren( $termin ) ) status_feuern( 'success', 'Termin'.STATUSMELDUNGEN['speichern_erfolgreich']['meldung'], FALSE );
        else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
      }
      redirect(ABSPRUNG);
    }
  }

  //------------------------------------------------------------------------------------------------------------------
  public function rueckmeldung_machen() {
    $this->form_validation->set_rules('termin_id', 'Termin-ID', 'required|numeric');
    $this->form_validation->set_rules('status', 'Status', 'required|numeric');
    if( ( TERMINE_RUECKMELDUNG_DETAIL_ABSAGE AND intval( $this->input->post('status') ) == 0 ) ) $this->form_validation->set_rules('bemerkung', 'Begründung', 'required|callback_fv_standard_rueckmeldung');
    else $this->form_validation->set_rules('bemerkung', 'Bemerkung', 'callback_fv_standard_rueckmeldung');
      if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE ); else {
      $rueckmeldung = array(
        'zeitpunkt' => time(),
        'termin_id' => intval( $this->input->post('termin_id') ),
        'status' => intval( $this->input->post('status') ),
        'mitglied_id' => ICH['id'],
        'bemerkung' => $this->input->post('bemerkung'),
      );
      if( TERMINE_RUECKMELDUNG_DETAIL_ABSAGE AND intval( $this->input->post('status') ) == 0 AND empty($rueckmeldung['bemerkung']) ) status_feuern( 'Für deine Rückmeldung ist eine kurze Begründung erforderlich!', FALSE );
      elseif( $this->termine_model->alle_termine( intval($rueckmeldung['termin_id']) )['start']-TERMINE_RUECKMELDUNG_FRIST < time() ) status_feuern( 'Du kannst zu diesem Termin keine Rückmeldung machen, weil der Termin bereits begonnen hat oder in der Vergangenheit liegt!', FALSE );
    elseif( $this->termine_model->termine_rueckmeldung_machen( $rueckmeldung ) ) { /* Keine Status-Nachricht */ }
      else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
    }
    redirect(ABSPRUNG);
  }

  //------------------------------------------------------------------------------------------------------------------
  public function anwesenheit_kontrollieren() {
    if( !TERMINE_ANWESENHEITSKONTROLLE OR !in_array( '-a', ICH['rechte'] ) ) $this->standard_404(); else {
      $this->form_validation->set_rules('element_id', 'Termin-ID', 'required|numeric');
      $this->form_validation->set_rules('mitglieder[]', 'Mitglieder-ID', 'numeric');
      if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE ); else {
        if( is_null( $this->input->post('mitglieder') ) ) $anwesende_mitglieder = array(); else $anwesende_mitglieder = $this->input->post('mitglieder');
        $durchgelaufen = TRUE; foreach( MITGLIEDER as $mitglied ) {
          if( in_array( $mitglied['id'], $anwesende_mitglieder ) ) {
            $anwesenheit['zeitpunkt'] = time();
            $anwesenheit['mitglied_id'] = $mitglied['id'];
            $anwesenheit['termin_id'] = intval( $this->input->post('element_id') ); // muss das element_id sein?
            if( !$this->termine_model->termine_anwesenheit_eintragen( $anwesenheit ) ) $durchgelaufen = FALSE;
          } else {
            $anwesenheit['mitglied_id'] = intval( $mitglied['id'] );
            $anwesenheit['termin_id'] = intval( $this->input->post('element_id') ); // muss das element_id sein?
            foreach( $this->termine_model->termine_anwesenheiten( NULL, $anwesenheit ) as $anwesenheit )
              if( !$this->termine_model->termine_anwesenheit_austragen( $anwesenheit['id'] ) ) $durchgelaufen = FALSE;
          }
          unset( $anwesenheit );
        } if( $durchgelaufen ) status_feuern( 'success', 'Anwesenheiten'.STATUSMELDUNGEN['speichern_erfolgreich']['meldung'], FALSE );
          else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
      }
      redirect(ABSPRUNG);
    }
  }
  
  //------------------------------------------------------------------------------------------------------------------
  public function setlist_titel_auswaehlen() {
    if( !TERMINE_SETLISTS OR !in_array( '-t', ICH['rechte'] ) ) $this->standard_404(); else {
      $this->form_validation->set_rules('element_id', 'Termin-ID', 'required|numeric');
      $this->form_validation->set_rules('notenverzeichnis[]', 'Titel-ID', 'numeric');
      if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE ); else {
        $termin_id = intval( $this->input->post('element_id') ); // muss das element_id sein?
        $termin_setlist = $this->termine_model->alle_termine( $termin_id )['setlist'];
        $this->load->model('notenbank_model');
        foreach( $this->notenbank_model->notenbank_notenverzeichnis() as $titel ) {
          $ausgewaehlte_titel = array(); if( !empty($this->input->post('notenverzeichnis')) ) $ausgewaehlte_titel = $this->input->post('notenverzeichnis'); 
          if( in_array( $titel['id'], $ausgewaehlte_titel ) AND !in_array( $titel['id'],  $termin_setlist ) ) $termin_setlist[] = $titel['id'];
          elseif( !in_array( $titel['id'], $ausgewaehlte_titel ) AND in_array( $titel['id'],  $termin_setlist ) ) unset( $termin_setlist[ array_search( $titel['id'], $termin_setlist ) ] );
        }
        if( $this->termine_model->termin_db_aktualisieren( array( 'id' => $termin_id, 'setlist' => $termin_setlist ) ) ) status_feuern( 'success', 'Setlist'.STATUSMELDUNGEN['speichern_erfolgreich']['meldung'], FALSE );
        else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
      }
      redirect(ABSPRUNG);
    }
  }

  public function setlist_speichern() {
    if( !TERMINE_SETLISTS OR !in_array( '-t', ICH['rechte'] ) ) $this->standard_404(); else {
      $this->form_validation->set_rules('termin_id', 'Termin-ID', 'required|numeric');
      $this->form_validation->set_rules('sortable_elemente[]', 'Positionen', 'numeric');
      if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE );
      elseif( $this->termine_model->termin_db_aktualisieren( array( 'id' => $this->input->post('termin_id'), 'setlist' => $this->input->post('sortable_positionen') ) ) ) status_feuern( 'success', 'Setlist'.STATUSMELDUNGEN['speichern_erfolgreich']['meldung'], FALSE );
      else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
      redirect(ABSPRUNG);
    }
  }

}
