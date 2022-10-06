<?php
class Strafkatalog extends Vereinsapp_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('strafkatalog_model');
  }

  //------------------------------------------------------------------------------------------------------------------
  public function index() {
    $mitglieder_auswaehlen_elemente = array();

    foreach( $this->strafkatalog_model->strafkatalog_kapiteln() as $kapitel ) {
      $strafkatalog_strafen = $this->strafkatalog_model->strafkatalog( NULL, array( 'kapitel_id' => $kapitel['id'] ));

      if( !empty($strafkatalog_strafen) ) { $this->data['ueberschrift'] = $kapitel['titel']; $this->load->view('templates/ueberschrift', $this->data); }
      $liste = array(); if( !empty($strafkatalog_strafen ) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_kopf', $this->data); unset($liste['kopf']); }
      foreach( $strafkatalog_strafen as $strafe ) {

        $liste['element']['beschriftung'] = $strafe['grund'];
        $liste['element']['float_right'] = html_waehrung($strafe['betrag']);
        if( !empty($strafe['bemerkung']) ) $liste['element']['small'] = $strafe['bemerkung'];

        if( in_array( '-s', ICH['rechte'] ) ) {
          $liste['element']['symbol'] = SYMBOLE['mitglied']['bootstrap'];
          $liste['element']['modal_id'] = 'mitglieder_auswaehlen';
          $liste['element']['id'] = $strafe['id'];

          $this->data['eintragen']['strafen'][ intval($strafe['id']) ] = $strafe;
          $this->data['austragen']['id'] = 'strafe_austragen'; $this->data['austragen']['elemente'][ intval($strafe['id']) ] = array( 'beschriftung' => 'diese Strafe' );
  
          $this->data['liste_element_werkzeugkasten'] = array( 'id' => $strafe['id'], 'werkzeugkasten' => array(), );
          $this->data['liste_element_werkzeugkasten']['werkzeugkasten'][] = array( 'ziel' => $this->data['austragen']['id'], 'symbol' => SYMBOLE['loeschen']['bootstrap'], 'farbe' => 'danger', 'data' => array( 'element_id' => intval($strafe['id']), ), );
          $this->data['liste_element_werkzeugkasten']['werkzeugkasten'][] = array( 'ziel' => 'strafe_eintragen', 'symbol' => SYMBOLE['duplizieren']['bootstrap'], 'data' => array( 'strafe_id' => intval($strafe['id']), 'aktion' => 'duplizieren', ), );
          $this->data['liste_element_werkzeugkasten']['werkzeugkasten'][] = array( 'ziel' => 'strafe_eintragen', 'symbol' => SYMBOLE['aendern']['bootstrap'], 'data' => array( 'strafe_id' => intval($strafe['id']), 'aktion' => 'aendern', ), );
          $this->data['liste_element_werkzeugkasten'] = $this->load->view('templates/liste_element_werkzeugkasten', $this->data, TRUE);

          $mitglieder_auswaehlen_elemente[ intval( $strafe['id'] ) ] = array( 'bemerkung' => $strafe['grund'].' ('.html_waehrung($strafe['betrag']).')', 'checked' => array(), 'css' => array() );
        }

        $this->data['liste'] = $liste; $this->load->view('templates/liste_element', $this->data); unset($liste['element']);
      }
      if( !empty($strafkatalog_strafen ) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_fuss', $this->data); unset($liste); }
      $this->data['eintragen']['kapiteln'][ intval($kapitel['id']) ] = $kapitel;
    }

    if( in_array( '-s', ICH['rechte'] ) ) {
      $this->data['mitglieder_auswaehlen'] = array(
        'form' => site_url().CONTROLLER.'/eintrag_eintragen', // immer gleich -> STRING
        'beschriftung' => 'Auswahl speichern',  // meistens immer gleich -> STRING
        'mitglieder_cluster' => tabelle_clustern( MITGLIEDER, $this->einstellungen_model->standard_einstellung( 'mitglieder', 'gruppieren_nach', ICH['id'] ) ),  // immer gleich -> ARRAY nach mitglied_id
        'mitglieder_gruppieren_nach' => $this->einstellungen_model->standard_einstellung( 'mitglieder', 'gruppieren_nach', ICH['id'] ),  // immer gleich -> STRING
        'elemente' => $mitglieder_auswaehlen_elemente,
      );
      $this->load->view('mitglieder/mitglieder_auswaehlen_modal', $this->data);
    }

    if( in_array( '-s', ICH['rechte'] ) ) {
      $this->data['werkzeugkasten'][] = array( 'ziel' => 'strafe_eintragen',  'symbol' => SYMBOLE['hinzufuegen']['bootstrap'], 'data' => array( 'aktion' => 'eintragen', ) );

      $this->data['eintragen']['form'] = site_url().CONTROLLER.'/strafe_eintragen';
      $this->data['eintragen']['titel'] =  array( 'eintragen' => 'Strafe eintragen', 'duplizieren' => 'Strafe duplizieren', 'aendern' => 'Strafe ändern', );
      $this->data['eintragen']['submit'] = array( 'eintragen' => 'Strafe speichern', 'duplizieren' => 'Strafe speichern', 'aendern' => 'Speichern', );
      $this->load->view('strafkatalog/strafe_eintragen_modal', $this->data);

      $this->data['austragen']['form'] = site_url().CONTROLLER.'/strafe_austragen';
      $this->data['austragen']['titel'] = 'Strafe';
      //$this->data['austragen']['submit'] = array( 'austragen' => 'Strafe löschen', );
      if( !empty($strafkatalog_strafen) ) $this->load->view('templates/austragen_modal', $this->data);
    }


    $strafkatalog_eintraege = $this->strafkatalog_model->strafkatalog_eintraege( NULL, array( 'erledigt_zeitpunkt<=' => 0 ) );

    if( !empty($strafkatalog_eintraege) ) $this->load->view('templates/horizontale_linie', $this->data);
      
    if( !empty($strafkatalog_eintraege) ) { $this->data['ueberschrift'] = 'Offene Einträge'; $this->load->view('templates/ueberschrift', $this->data); }
    $liste = array(); if( !empty($strafkatalog_eintraege ) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_kopf', $this->data); unset($liste['kopf']); }
    foreach( $strafkatalog_eintraege as $eintrag ) {
      if( array_key_exists( intval($eintrag['mitglied_id']), MITGLIEDER ) ) $mitglied = MITGLIEDER[ intval($eintrag['mitglied_id']) ]['vorname'].' '.MITGLIEDER[ intval($eintrag['mitglied_id']) ]['nachname']; else $mitglied = 'Mitglied gelöscht';

      if( $eintrag['erledigt_zeitpunkt'] > 0 ) $farbe = 'body'; else $farbe = 'danger';
      $liste['element']['beschriftung'] = '<div class="small">'.date( 'd.m.Y', $eintrag['zeitpunkt'] ).' - '.$mitglied;
      if( !empty($eintrag['erledigt_zeitpunkt']) AND intval($eintrag['erledigt_zeitpunkt']) > 0 ) $liste['element']['beschriftung'] .= ' - <span class="text-success">'.date( 'd.m.Y', $eintrag['erledigt_zeitpunkt'] ).'</span>';
      $liste['element']['beschriftung'] .= '</div>';
      $liste['element']['beschriftung'] .= '<span class="text-'.$farbe.'">'.$eintrag['strafe_grund'].'</span>';
      $liste['element']['float_right'] = '<span class="text-'.$farbe.'">'.html_waehrung( $eintrag['strafe_betrag'] ).'</span>';
      if( !empty($eintrag['strafe_bemerkung']) ) $liste['element']['small'] = $eintrag['strafe_bemerkung'];

      if( in_array( '-s', ICH['rechte'] ) ) {
        if( $eintrag['erledigt_zeitpunkt'] > 0 ) {
          $liste['element']['symbol'] = SYMBOLE['kein_haken']['bootstrap'];
          $liste['element']['symbol_farbe'] = 'danger';
          $this->data['eintrag_erledigen']['eintraege'][ $eintrag['id'] ] = array( 'beschriftung' => 'Strafe über '.html_waehrung( $eintrag['strafe_betrag'] ).' für '.$mitglied.' reaktivieren?' );
        } else {
          $liste['element']['symbol'] = SYMBOLE['haken']['bootstrap']; 
          $liste['element']['symbol_farbe'] = 'success';
          $this->data['eintrag_erledigen']['eintraege'][ $eintrag['id'] ] = array( 'beschriftung' => 'Strafe über '.html_waehrung( $eintrag['strafe_betrag'] ).' wurde von '.$mitglied.' bezahlt?' );
        }
        $liste['element']['modal_id'] = 'eintrag_erledigen';
        $liste['element']['id'] = $eintrag['id'];

        $this->data['eintragen']['eintraege'][ intval($eintrag['id']) ] = $eintrag;
        $this->data['austragen']['id'] = 'eintrag_austragen'; $this->data['austragen']['elemente'][ intval($eintrag['id']) ] = array( 'beschriftung' => 'diesen Eintrag' );

        $this->data['liste_element_werkzeugkasten'] = array( 'id' => $eintrag['id'], 'werkzeugkasten' => array(), );
        $this->data['liste_element_werkzeugkasten']['werkzeugkasten'][] = array( 'ziel' => $this->data['austragen']['id'], 'symbol' => SYMBOLE['loeschen']['bootstrap'], 'farbe' => 'danger', 'data' => array( 'element_id' => intval($eintrag['id']), ), );
        $this->data['liste_element_werkzeugkasten']['werkzeugkasten'][] = array( 'ziel' => 'eintrag_eintragen', 'symbol' => SYMBOLE['aendern']['bootstrap'], 'data' => array( 'eintrag_id' => intval($eintrag['id']), 'aktion' => 'aendern', ), );
        $this->data['liste_element_werkzeugkasten'] = $this->load->view('templates/liste_element_werkzeugkasten', $this->data, TRUE);
      }

      $this->data['liste'] = $liste; $this->load->view('templates/liste_element', $this->data); unset($liste['element']);
    }
    if( !empty($strafkatalog_eintraege) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_fuss', $this->data); unset($liste); }

    if( !empty($strafkatalog_eintraege) ) {
      //$this->data['eintraege_betrag'] = array( 'beschriftung' => 'aller Einträge:', 'betrag' => $this->strafkatalog_model->strafkatalog_eintraege_betrag( $strafkatalog_eintraege ) );
      //$this->load->view('strafkatalog/eintraege_betrag', $this->data);
  
      //$this->data['eintraege_betrag'] = array( 'beschriftung' => 'aller bezahlten Einträge:', 'farbe' => 'success', 'betrag' => $this->strafkatalog_model->strafkatalog_eintraege_betrag( $this->strafkatalog_model->strafkatalog_eintraege( NULL, array( 'erledigt_zeitpunkt>=' => 1 ) ) ) );
      //$this->load->view('strafkatalog/eintraege_betrag', $this->data);
  
      $this->data['eintraege_betrag'] = array( 'beschriftung' => 'aller offenen Einträge:', 'farbe' => 'danger', 'betrag' => $this->strafkatalog_model->strafkatalog_eintraege_betrag( $strafkatalog_eintraege ) );
      $this->load->view('strafkatalog/eintraege_betrag', $this->data);
    }
    
    if( in_array( '-s', ICH['rechte'] ) ) {
      $this->data['eintragen']['form'] = site_url().CONTROLLER.'/eintrag_eintragen';
      $this->data['eintragen']['titel'] =  array( 'aendern' => 'Eintrag ändern', );
      $this->data['eintragen']['submit'] = array( 'aendern' => 'Speichern', );
      $this->load->view('strafkatalog/eintrag_eintragen_modal', $this->data);

      $this->data['austragen']['form'] = site_url().CONTROLLER.'/eintrag_austragen';
      $this->data['austragen']['titel'] = 'Eintrag';
      //$this->data['austragen']['submit'] = array( 'austragen' => 'Eintrag löschen', );
      if( !empty($strafkatalog_eintraege) ) $this->load->view('templates/austragen_modal', $this->data);

      if( !empty($strafkatalog_eintraege) ) $this->load->view('strafkatalog/eintrag_erledigen_modal', $this->data);
    }

    $this->data['links'][] = array( 'ziel' => site_url().CONTROLLER.'/kassenbuch', 'symbol' => 'journal' );

    $this->load->view('templates/footer', $this->data);
  }

  //------------------------------------------------------------------------------------------------------------------
  public function kassenbuch() {

    $strafkatalog_eintraege = $this->strafkatalog_model->strafkatalog_eintraege();
      
    $this->data['ueberschrift'] = 'Kassenbuch'; $this->load->view('templates/ueberschrift', $this->data);
    $liste = array(); if( !empty($strafkatalog_eintraege ) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_kopf', $this->data); unset($liste['kopf']); }
    foreach( $strafkatalog_eintraege as $eintrag ) {
      if( array_key_exists( intval($eintrag['mitglied_id']), MITGLIEDER ) ) $mitglied = MITGLIEDER[ intval($eintrag['mitglied_id']) ]['vorname'].' '.MITGLIEDER[ intval($eintrag['mitglied_id']) ]['nachname']; else $mitglied = 'Mitglied gelöscht';

      if( $eintrag['erledigt_zeitpunkt'] > 0 ) $farbe = 'body'; else $farbe = 'danger';
      $liste['element']['beschriftung'] = '<div class="small">'.date( 'd.m.Y', $eintrag['zeitpunkt'] ).' - '.$mitglied;
      if( !empty($eintrag['erledigt_zeitpunkt']) AND intval($eintrag['erledigt_zeitpunkt']) > 0 ) $liste['element']['beschriftung'] .= ' - <span class="text-success">'.date( 'd.m.Y', $eintrag['erledigt_zeitpunkt'] ).'</span>';
      $liste['element']['beschriftung'] .= '</div>';
      $liste['element']['beschriftung'] .= '<span class="text-'.$farbe.'">'.$eintrag['strafe_grund'].'</span>';
      $liste['element']['float_right'] = '<span class="text-'.$farbe.'">'.html_waehrung( $eintrag['strafe_betrag'] ).'</span>';
      if( !empty($eintrag['strafe_bemerkung']) ) $liste['element']['small'] = $eintrag['strafe_bemerkung'];

      if( in_array( '-s', ICH['rechte'] ) ) {
        if( $eintrag['erledigt_zeitpunkt'] > 0 ) {
          $liste['element']['symbol'] = SYMBOLE['kein_haken']['bootstrap'];
          $liste['element']['symbol_farbe'] = 'danger';
          $this->data['eintrag_erledigen']['eintraege'][ $eintrag['id'] ] = array( 'beschriftung' => 'Strafe über '.html_waehrung( $eintrag['strafe_betrag'] ).' für '.$mitglied.' reaktivieren?' );
        } else {
          $liste['element']['symbol'] = SYMBOLE['haken']['bootstrap']; 
          $liste['element']['symbol_farbe'] = 'success';
          $this->data['eintrag_erledigen']['eintraege'][ $eintrag['id'] ] = array( 'beschriftung' => 'Strafe über '.html_waehrung( $eintrag['strafe_betrag'] ).' wurde von '.$mitglied.' bezahlt?' );
        }
        $liste['element']['modal_id'] = 'eintrag_erledigen';
        $liste['element']['id'] = $eintrag['id'];

        $this->data['eintragen']['eintraege'][ intval($eintrag['id']) ] = $eintrag;
        $this->data['austragen']['id'] = 'eintrag_austragen'; $this->data['austragen']['elemente'][ intval($eintrag['id']) ] = array( 'beschriftung' => 'diesen Eintrag' );

        $this->data['liste_element_werkzeugkasten'] = array( 'id' => $eintrag['id'], 'werkzeugkasten' => array(), );
        $this->data['liste_element_werkzeugkasten']['werkzeugkasten'][] = array( 'ziel' => $this->data['austragen']['id'], 'symbol' => SYMBOLE['loeschen']['bootstrap'], 'farbe' => 'danger', 'data' => array( 'element_id' => intval($eintrag['id']), ), );
        $this->data['liste_element_werkzeugkasten']['werkzeugkasten'][] = array( 'ziel' => 'eintrag_eintragen', 'symbol' => SYMBOLE['aendern']['bootstrap'], 'data' => array( 'eintrag_id' => intval($eintrag['id']), 'aktion' => 'aendern', ), );
        $this->data['liste_element_werkzeugkasten'] = $this->load->view('templates/liste_element_werkzeugkasten', $this->data, TRUE);
      }

      $this->data['liste'] = $liste; $this->load->view('templates/liste_element', $this->data); unset($liste['element']);
    }
    if( !empty($strafkatalog_eintraege) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_fuss', $this->data); unset($liste); }

    if( !empty($strafkatalog_eintraege) ) {
      $this->data['eintraege_betrag'] = array( 'beschriftung' => 'aller Einträge:', 'betrag' => $this->strafkatalog_model->strafkatalog_eintraege_betrag( $strafkatalog_eintraege ) );
      $this->load->view('strafkatalog/eintraege_betrag', $this->data);
  
      $this->data['eintraege_betrag'] = array( 'beschriftung' => 'aller bezahlten Einträge:', 'farbe' => 'success', 'betrag' => $this->strafkatalog_model->strafkatalog_eintraege_betrag( $this->strafkatalog_model->strafkatalog_eintraege( NULL, array( 'erledigt_zeitpunkt>=' => 1 ) ) ) );
      $this->load->view('strafkatalog/eintraege_betrag', $this->data);
  
      $this->data['eintraege_betrag'] = array( 'beschriftung' => 'aller offenen Einträge:', 'farbe' => 'danger', 'betrag' => $this->strafkatalog_model->strafkatalog_eintraege_betrag( $this->strafkatalog_model->strafkatalog_eintraege( NULL, array( 'erledigt_zeitpunkt<=' => 0 ) ) ) );
      $this->load->view('strafkatalog/eintraege_betrag', $this->data);
    }
    
    if( in_array( '-s', ICH['rechte'] ) ) {
      $this->data['eintragen']['form'] = site_url().CONTROLLER.'/eintrag_eintragen';
      $this->data['eintragen']['titel'] =  array( 'aendern' => 'Eintrag ändern', );
      $this->data['eintragen']['submit'] = array( 'aendern' => 'Speichern', );
      $this->load->view('strafkatalog/eintrag_eintragen_modal', $this->data);

      $this->data['austragen']['form'] = site_url().CONTROLLER.'/eintrag_austragen';
      $this->data['austragen']['titel'] = 'Eintrag';
      //$this->data['austragen']['submit'] = array( 'austragen' => 'Eintrag löschen', );
      if( !empty($strafkatalog_eintraege) ) $this->load->view('templates/austragen_modal', $this->data);

      if( !empty($strafkatalog_eintraege) ) $this->load->view('strafkatalog/eintrag_erledigen_modal', $this->data);
    }

    $this->data['links'][] = array( 'ziel' => site_url().CONTROLLER, 'symbol' => SYMBOLE['ebene_hoch']['bootstrap'] );

    $this->load->view('templates/footer', $this->data);
  }

  //------------------------------------------------------------------------------------------------------------------
  public function strafe_eintragen() {
    if ( !in_array( '-s', ICH['rechte'] ) ) $this->standard_404(); else {
      $this->form_validation->set_rules('grund', STRAFKATALOG_KATEGORIEN['grund']['beschriftung'], 'required|callback_fv_standard_textzeile');
      $this->form_validation->set_rules('bemerkung', STRAFKATALOG_KATEGORIEN['bemerkung']['beschriftung'], 'callback_fv_standard_textzeile');
      $this->form_validation->set_rules('betrag', STRAFKATALOG_KATEGORIEN['betrag']['beschriftung'], 'required|numeric');
      $this->form_validation->set_rules('kapitel_id', STRAFKATALOG_KATEGORIEN['kapitel_id']['beschriftung'], 'required|numeric');
      $this->form_validation->set_rules('strafe_id', 'Strafe-ID', 'numeric');
      if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE ); else {

        $strafe = array(
          'zeitpunkt' => time(),
          'grund' => $this->input->post('grund'),
          'bemerkung' => $this->input->post('bemerkung'),
          'betrag' => floatval($this->input->post('betrag')),
          'kapitel_id' => intval($this->input->post('kapitel_id')),
        );

        if( !empty($this->input->post('strafe_id')) ) { // Strafe  wird geändert
          $strafe['id'] = intval($this->input->post('strafe_id'));
          if( $this->strafkatalog_model->strafe_db_aktualisieren( $strafe ) ) status_feuern( 'success', 'Strafe'.STATUSMELDUNGEN['speichern_erfolgreich']['meldung'], FALSE );
          else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
        } else {                                        // Strafe  wird neu erstellt
          if( $this->strafkatalog_model->strafe_eintragen( $strafe ) ) status_feuern( 'success', 'Strafe'.STATUSMELDUNGEN['speichern_erfolgreich']['meldung'], FALSE ); // Strafe wird neu erstellt
          else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
        }
      }

      redirect(ABSPRUNG);
    }
  }

  public function strafe_austragen() {
    if ( !in_array( '-s', ICH['rechte'] ) ) $this->standard_404(); else {
      $this->form_validation->set_rules('element_id', 'Strafe-ID', 'required|numeric');
      if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE ); else {
        $strafe = $this->strafkatalog_model->strafkatalog( intval( $this->input->post('element_id') ) );
        $strafe['archiv'] = 1;
        if( $this->strafkatalog_model->strafe_db_aktualisieren( $strafe ) ) status_feuern( 'danger', 'Strafe'.STATUSMELDUNGEN['loeschen_erfolgreich']['meldung'], FALSE );
        else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
      }
      redirect(ABSPRUNG);
    }
  }

  //------------------------------------------------------------------------------------------------------------------
  public function eintrag_eintragen( ) {
    if ( !in_array( '-s', ICH['rechte'] ) ) $this->standard_404(); else {
      $this->form_validation->set_rules('eintrag_id', 'Strafe-ID', 'numeric');
      if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE ); else {

        if( !empty($this->input->post('eintrag_id')) ) {  // Eintrag  wird geändert
          $this->form_validation->set_rules('zeitpunkt', 'Zeitpunkt', 'required|callback_fv_datum');
          $this->form_validation->set_rules('mitglied_id', 'Mitglied-ID', 'required|numeric');
          $this->form_validation->set_rules('eintrag_id', 'Eintrag-ID', 'required|numeric');
          if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE ); else {

            $eintrag = array(
              'zeitpunkt' => strtotime( $this->input->post('zeitpunkt') ),
              'mitglied_id' => $this->input->post('mitglied_id'),
            );
            $eintrag['id'] = intval($this->input->post('eintrag_id'));
            if( $this->strafkatalog_model->strafkatalog_eintrag_db_aktualisieren( $eintrag ) ) status_feuern( 'success', 'Eintrag'.STATUSMELDUNGEN['speichern_erfolgreich']['meldung'], FALSE );
            else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
          }

        } else {                                          // Eintrag  wird neu erstellt
          $this->form_validation->set_rules('element_id', 'Strafe-ID', 'required|numeric');
          $this->form_validation->set_rules('mitglieder[]', 'Mitglieder-ID', 'required|numeric');
          if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE ); else {

            $strafe = $this->strafkatalog_model->strafkatalog( intval( $this->input->post('element_id') ) );
            $eintrag = array(
              'zeitpunkt' => time(),
              'strafe_grund' => $strafe['grund'],
              'strafe_bemerkung' => $strafe['bemerkung'],
              'strafe_betrag' => $strafe['betrag'],
              'von_mitglied_id' => ICH['id'],
            );

            $durchgelaufen = TRUE; foreach( $this->input->post('mitglieder') as $mitglied_id ) {
              $eintrag['zeitpunkt'] = time();
              $eintrag['mitglied_id'] = $mitglied_id;
              if( !$this->strafkatalog_model->strafkatalog_eintrag_eintragen( $eintrag ) ) $durchgelaufen = FALSE;
            }
            if( $durchgelaufen ) status_feuern( 'success', 'Eintrag'.STATUSMELDUNGEN['speichern_erfolgreich']['meldung'], FALSE );
            else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
          }
        }

      }
      redirect(ABSPRUNG);
    }
  }

  public function eintrag_austragen() {
    if ( !in_array( '-s', ICH['rechte'] ) ) $this->standard_404(); else {
      $this->form_validation->set_rules('element_id', 'Eintrag-ID', 'required|numeric');
      if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE ); else {
        $eintrag = $this->strafkatalog_model->strafkatalog_eintraege( intval( $this->input->post('element_id') ) );
        $eintrag['archiv'] = 1;
        if( $this->strafkatalog_model->strafkatalog_eintrag_db_aktualisieren( $eintrag ) ) status_feuern( 'danger', 'Eintrag'.STATUSMELDUNGEN['loeschen_erfolgreich']['meldung'], FALSE );
        else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
      }
      redirect(ABSPRUNG);
    }
  }

  public function eintrag_erledigen( ) {
    if ( !in_array( '-s', ICH['rechte'] ) ) $this->standard_404(); else {
      $this->form_validation->set_rules('eintrag_id', 'Eintrag-ID', 'required|numeric');
      if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE ); else {
        $eintrag = $this->strafkatalog_model->strafkatalog_eintraege( intval( $this->input->post('eintrag_id') ) );
        if( intval($eintrag['erledigt_zeitpunkt']) > 0 ) {
          $eintrag['erledigt_zeitpunkt'] = 0;
          $eintrag['erledigt_von_mitglied_id'] = 0;
          $status = 'Eintrag wurde wieder aktiviert.';
        } else {
          $eintrag['erledigt_zeitpunkt'] = time();
          $eintrag['erledigt_von_mitglied_id'] = ICH['id'];
          $status = 'Eintrag wurde als erledigt markiert.';
        }
        if( $this->strafkatalog_model->strafkatalog_eintrag_db_aktualisieren( $eintrag ) ) status_feuern( 'success', $status, FALSE );
        else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
      }
      redirect(ABSPRUNG);
    }
  }
  
}
