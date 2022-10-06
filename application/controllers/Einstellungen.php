<?php
class Einstellungen extends Vereinsapp_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {

    $this->data['dauerhaft_angemeldet'] = FALSE; $dauerhaft_angemeldet = $this->mitglieder_model->mitglieder_dauerhaft_angemeldet( NULL, array( 'identifier' => $this->input->cookie('vereinsapp_dauerhaft_angemeldet_identifier') ) );
    if( !empty($dauerhaft_angemeldet) ) {
      $dauerhaft_angemeldet = $dauerhaft_angemeldet[ array_key_last($dauerhaft_angemeldet) ];
      $this->data['dauerhaft_angemeldet'] = array_key_exists( 'securitytoken', $dauerhaft_angemeldet ) AND password_verify( $this->input->cookie('vereinsapp_dauerhaft_angemeldet_securitytoken'), $dauerhaft_angemeldet['securitytoken'] );
    }
    $this->data['dauerhaft_angemeldet_identifier'] = $this->input->cookie('vereinsapp_dauerhaft_angemeldet_identifier');
    $this->load->view('einstellungen/verknuepfen', $this->data);

    $meine_abwesenheiten = $this->mitglieder_model->mitglieder_abwesenheiten( NULL, array( 'mitglied_id' => ICH['id'] ) );
    $this->data['ueberschrift'] = 'Meine Abwesenheiten'; $this->load->view('templates/ueberschrift', $this->data);
    $liste = array(); if( !empty($meine_abwesenheiten) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_kopf', $this->data); unset($liste['kopf']); }
    foreach( $meine_abwesenheiten as $abwesenheit ) {
      $this->data['austragen']['id'] = 'abwesenheit_austragen';
      $this->data['austragen']['elemente'][ $abwesenheit['id'] ] = array( 'beschriftung' => 'die Abwesenheit im Zeitraum '.date( 'd.m.Y', $abwesenheit['start'] ).' - '.date( 'd.m.Y', $abwesenheit['ende'] ), );
      $liste['element']['modal_id'] = $this->data['austragen']['id'];
      $liste['element']['id'] = $abwesenheit['id'];
      $liste['element']['beschriftung'] = date( 'd.m.Y', $abwesenheit['start'] ).' - '.date( 'd.m.Y', $abwesenheit['ende'] );
      $liste['element']['small'] = $abwesenheit['bemerkung'];
      $liste['element']['symbol'] = SYMBOLE['loeschen']['bootstrap'];
      $liste['element']['symbol_farbe'] = 'danger';
      $this->data['liste'] = $liste; $this->load->view('templates/liste_element', $this->data); unset($liste['element']);
    }
    if( !empty($meine_abwesenheiten) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_fuss', $this->data); unset($liste); }
    $this->data['austragen']['form'] = site_url().CONTROLLER.'/abwesenheit_austragen';
    $this->data['austragen']['titel'] = 'Abwesenheit';
    //$this->data['austragen']['submit'] = array( 'austragen' => 'Abwesenheit löschen', );
    if( !empty($meine_abwesenheiten) ) $this->load->view('templates/austragen_modal', $this->data);
    $this->load->view('einstellungen/abwesenheit_eintragen', $this->data);

    $this->load->view('templates/horizontale_linie', $this->data);

    $this->data['ueberschrift'] = 'Meine '.MITGLIEDER_KATEGORIEN['rechte']['beschriftung']; $this->load->view('templates/ueberschrift', $this->data);
    $liste = array( 'form' => site_url().CONTROLLER.'/einstellungen_rechte_aendern' ); 
    if( !empty(RECHTE) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_kopf', $this->data); unset($liste['kopf']); }
    foreach( RECHTE as $recht => $eigenschaften ) {
      $liste['element']['beschriftung'] = '<div class="input-group flex-nowrap"><input class="form-check-input-lg" type="checkbox" value="'.$recht.'" name="rechte[]" id="'.$recht.'"';
      if( !$eigenschaften['veraenderbar'] // Recht darf nicht verändert werden
       OR ( !in_array( $recht, ICH['rechte_db'] ) AND in_array( $recht, ICH['rechte'] ) ) // Recht kommt durch Vertretungen o.ä.
       OR !in_array( '-r', ICH['rechte'] ) // Mitglied hat keine Rechte zum Ändern der Rechte
      ) $liste['element']['beschriftung'] .= ' disabled'; else $liste['element']['beschriftung'] .= ' onclick="this.form.submit();"';
      if( in_array( $recht, ICH['rechte'] ) ) $liste['element']['beschriftung'] .= ' checked';
      $liste['element']['beschriftung'] .= ' /><label class="form-check-label" for="'.$recht.'">'.$eigenschaften['beschriftung'].'</label></div>';
      if( array_key_exists( 'bemerkung', $eigenschaften ) ) $liste['element']['small'] = $eigenschaften['bemerkung'];
      $this->data['liste'] = $liste; $this->load->view('templates/liste_element', $this->data); unset($liste['element']);
    }
    if( !empty(RECHTE) ) { $liste['form_inputs'] = array( 'mitglied_id' => ICH['id'] ); $this->data['liste'] = $liste; $this->load->view('templates/liste_fuss', $this->data); unset($liste); }

    $this->load->view('templates/horizontale_linie', $this->data);

    $this->data['ueberschrift'] = 'Meine Vertretungen'; $this->load->view('templates/ueberschrift', $this->data);

    $this->data['ich_vertrete'] = TRUE; $ich_vertrete = tabelle_clustern( $this->mitglieder_model->mitglieder_vertretungen( NULL, array( 'vertretung_id' => ICH['id'] ) ), 'mitglied_id' );
    $liste = array(); if( !empty($ich_vertrete) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_kopf', $this->data); unset($liste['kopf']); }
    foreach( $ich_vertrete as $mitglied_id => $vertretungen ) {
      $liste['element']['beschriftung'] = 'Ich vertrete '.MITGLIEDER[ $mitglied_id ]['vorname'].' '.MITGLIEDER[ $mitglied_id ]['nachname'];
      $liste['element']['small'] = ''; foreach( $vertretungen as $vertretung ) $this->data['liste']['small'] .= '<div>'.RECHTE[ $vertretung['recht'] ]['beschriftung'].'</div>';
      $liste['element']['symbol'] = SYMBOLE['loeschen']['bootstrap'];
      $liste['element']['symbol_farbe'] = 'danger';
      $liste['element']['modal_id'] = 'ich_vertrete_loeschen';
      $this->data['liste'] = $liste; $this->load->view('templates/liste_element', $this->data); unset($liste['element']);
    }
    if( !empty($ich_vertrete) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_fuss', $this->data); unset($liste); }
    if( !empty($ich_vertrete) ) { $this->data['vertretungen_cluster'] = $ich_vertrete; $this->load->view('einstellungen/vertretungen_loeschen_modal', $this->data); }

    $this->data['ich_vertrete'] = FALSE; $ich_werde_vertreten =  tabelle_clustern( $this->mitglieder_model->mitglieder_vertretungen( NULL, array( 'mitglied_id' => ICH['id'] ) ), 'vertretung_id' );
    $liste = array(); if( !empty($ich_werde_vertreten) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_kopf', $this->data); unset($liste['kopf']); }
    foreach( $ich_werde_vertreten as $vertretung_id => $vertretungen ) {
      $liste['element']['beschriftung'] = 'Ich werde vertreten durch '.MITGLIEDER[ $vertretung_id ]['vorname'].' '.MITGLIEDER[ $vertretung_id ]['nachname'];
      $liste['element']['small'] = ''; foreach( $vertretungen as $vertretung ) $liste['element']['small'] .= '<div>'.RECHTE[ $vertretung['recht'] ]['beschriftung'].'</div>';
      $liste['element']['symbol'] = SYMBOLE['loeschen']['bootstrap'];
      $liste['element']['symbol_farbe'] = 'danger';
      $liste['element']['id'] = $vertretung_id;
      $liste['element']['modal_id'] = 'ich_werde_vertreten_loeschen'; 
      $this->data['liste'] = $liste; $this->load->view('templates/liste_element', $this->data); unset($liste['element']);
    }
    if( !empty($ich_werde_vertreten) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_fuss', $this->data); unset($liste); }
    if( !empty($ich_werde_vertreten) ) { $this->data['vertretungen_cluster'] = $ich_werde_vertreten; $this->load->view('einstellungen/vertretungen_loeschen_modal', $this->data); }
    $this->load->view('einstellungen/vertretung_eintragen', $this->data);

    if( !is_null(ICH['login_erlaubt']) AND in_array( 'email_passwort', ICH['login_erlaubt'] ) ) {
      $this->load->view('templates/horizontale_linie', $this->data);
      if( !is_null(ICH['passwort']) ) $this->data['ueberschrift'] = 'Mein Passwort ändern'; else $this->data['ueberschrift'] = 'Mein Passwort vergeben'; $this->load->view('templates/ueberschrift', $this->data);
      $this->load->view('einstellungen/passwort_aendern', $this->data);
    }

    $this->load->view('templates/horizontale_linie', $this->data);

    $this->data['ueberschrift'] = 'Für mich '.lcfirst(MITGLIEDER_KATEGORIEN['login_erlaubt']['beschriftung']); $this->load->view('templates/ueberschrift', $this->data);
    $liste = array( 'form' => site_url().CONTROLLER.'/einstellungen_login_erlaubt' );
    if( !empty(LOGIN_ERLAUBT) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_kopf', $this->data); unset($liste['kopf']); }
    foreach( LOGIN_ERLAUBT as $login_erlaubt => $eigenschaften ) {
      $liste['element']['beschriftung'] = '<div class="input-group flex-nowrap"><input class="form-check-input-lg" type="checkbox" value="'.$login_erlaubt.'" name="login_erlaubt[]" id="'.$login_erlaubt.'" onclick="this.form.submit();"';
      if( !is_null(ICH['login_erlaubt']) AND in_array( $login_erlaubt, ICH['login_erlaubt'] ) ) $liste['element']['beschriftung'] .= ' checked';
      $liste['element']['beschriftung'] .= ' /><label class="form-check-label" for="'.$login_erlaubt.'">'.$eigenschaften['beschriftung'].'</label></div>';
      if( array_key_exists( 'bemerkung', $eigenschaften ) ) $liste['element']['small'] = $eigenschaften['bemerkung'];
      $this->data['liste'] = $liste; $this->load->view('templates/liste_element', $this->data); unset($liste['element']);
    }
    if( !empty(LOGIN_ERLAUBT) ) { $liste['form_inputs'] = array( 'mitglied_id' => ICH['id'] ); $this->data['liste'] = $liste; $this->load->view('templates/liste_fuss', $this->data); unset($liste); }



    if( in_array( '-e', ICH['rechte'] ) ) {
      $this->load->view('templates/horizontale_linie', $this->data);
      $this->data['ueberschrift'] = 'Entwickler-Einstellungen'; $this->load->view('templates/ueberschrift', $this->data);
      $this->load->view('einstellungen/entwickler_timestamp', $this->data);
      $this->load->view('einstellungen/entwickler_datum_uhrzeit', $this->data);
    }

    $this->load->view('templates/footer', $this->data);
  }

  //------------------------------------------------------------------------------------------------------------------
  public function einstellungen_abwesenheit_eintragen() {
    $this->form_validation->set_rules('start', 'Start', 'required|callback_fv_datum');
    $this->form_validation->set_rules('ende', 'Ende', 'required|callback_fv_datum');
    $this->form_validation->set_rules('mitglied_id', 'Mitglied-ID', 'required|numeric');
    $this->form_validation->set_rules('bemerkung', 'Bemerkung', 'callback_fv_standard_textzeile');
    if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE ); else {
      $abwesenheit = array(
        'zeitpunkt' => time(),
        'mitglied_id' => $this->input->post('mitglied_id'),
        'start' => strtotime ( $this->input->post('start') ),
        'ende' => strtotime ( $this->input->post('ende') )+60*60*24-1,
        'bemerkung' =>  $this->input->post('bemerkung'),
      );
      if( $abwesenheit['ende'] < $abwesenheit['start'] ) status_feuern( 'danger', 'Das Enddatum muss zeitlich nach dem Anfangsdatum liegen.', FALSE );
      elseif( $this->mitglieder_model->mitglieder_abwesenheit_eintragen( $abwesenheit ) ) status_feuern( 'success', 'Abwesenheit'.STATUSMELDUNGEN['speichern_erfolgreich']['meldung'], FALSE );
      else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
    } redirect(ABSPRUNG);
  }

  public function abwesenheit_austragen() {
    $this->form_validation->set_rules('element_id', 'Abwesenheit-ID', 'required|numeric');
    if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE );
    elseif( $this->mitglieder_model->mitglieder_abwesenheit_austragen( intval($this->input->post('element_id')) ) ) status_feuern( 'danger', 'Abwesenheit'.STATUSMELDUNGEN['loeschen_erfolgreich']['meldung'], FALSE );
    else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
    redirect(ABSPRUNG);
  }

  //------------------------------------------------------------------------------------------------------------------
  public function einstellungen_rechte_aendern() {
    if ( !in_array( '-r', ICH['rechte'] ) ) $this->standard_404(); else {
      $this->form_validation->set_rules('mitglied_id', 'Mitglied-ID', 'required|numeric');
      $this->form_validation->set_rules('rechte[]', MITGLIEDER_KATEGORIEN['rechte']['beschriftung'], 'in_list['.implode( ',', array_keys(RECHTE) ).']');
      if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE );
      elseif( array_key_exists( intval($this->input->post('mitglied_id')), MITGLIEDER ) ) {
        if( !$this->input->post('rechte') OR empty($this->input->post('rechte')) ) $rechte = array(); else $rechte = $this->input->post('rechte');
        $mitglied = MITGLIEDER[ intval($this->input->post('mitglied_id')) ];
        foreach( RECHTE as $recht => $eigenschaften )
          if( $eigenschaften['veraenderbar'] AND !( !in_array( $recht, ICH['rechte_db'] ) AND in_array( $recht, ICH['rechte'] ) ) ) { // Recht ist veränderbar und kommt nicht durch Vertretungen o.ä.
            if( in_array( $recht, $rechte ) AND !in_array( $recht, $mitglied['rechte_db'] ) ) $mitglied['rechte_db'][] = $recht; // Recht wird hinzugefügt
            elseif( !in_array( $recht, $rechte ) AND in_array( $recht, $mitglied['rechte_db'] ) ) $mitglied['rechte_db'] = array_diff( $mitglied['rechte_db'], array( $recht ) ); // Recht wird weggenommen
            else { /* Es passiert nichts, kann aber eigentlich nicht vorkommen */ }
          }
        if( $this->mitglieder_model->mitglied_db_aktualisieren( $mitglied ) ) status_feuern( 'success', 'Rechte'.STATUSMELDUNGEN['speichern_erfolgreich']['meldung'], FALSE );
      } else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
      redirect(ABSPRUNG);
    }
  }

  //------------------------------------------------------------------------------------------------------------------
  public function einstellungen_vertretung_eintragen() {
    $this->form_validation->set_rules('vertretung_id', 'Vertretung-ID', 'required|numeric');
    $this->form_validation->set_rules('recht', 'Recht', 'required|alpha_dash');
    if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE ); else {
      $vertretung = array(
        'zeitpunkt' => time(),
        'mitglied_id' => ICH['id'],
        'vertretung_id' => intval($this->input->post('vertretung_id')),
        'recht' => $this->input->post('recht'),
      );
      if( $vertretung['mitglied_id'] == $vertretung['vertretung_id'] ) status_feuern( 'danger', 'Die Vertretung kann sich nicht selbst vertreten.', FALSE );
      elseif( $this->mitglieder_model->mitglieder_vertretungen( NULL, array( 'mitglied_id' => $vertretung['mitglied_id'], 'vertretung_id' => $vertretung['vertretung_id'], 'recht' => $vertretung['recht'] ) ) )
        status_feuern( 'danger', 'Diese Vertretung existiert bereits.', FALSE );
      elseif( !in_array( $vertretung['recht'], MITGLIEDER[ $vertretung['mitglied_id'] ]['rechte_db'] ) ) status_feuern( 'danger', 'Dieses Recht ist nicht verfügbar.', FALSE );
      elseif( in_array( $vertretung['recht'], MITGLIEDER[ $vertretung['vertretung_id'] ]['rechte'] ) ) status_feuern( 'danger', 'Die Vertretung hat dieses Recht bereits.', FALSE );
      elseif( $this->mitglieder_model->mitglieder_vertretung_eintragen( $vertretung ) ) status_feuern( 'success', 'Vertretung'.STATUSMELDUNGEN['speichern_erfolgreich']['meldung'], FALSE );
      else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
    }
    redirect(ABSPRUNG);
  }

  public function einstellungen_vertretung_austragen() {
    $this->form_validation->set_rules('vertretung_id', 'Vertretung-ID', 'required|numeric');
    if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE );
    elseif( $this->mitglieder_model->mitglieder_vertretung_austragen( intval($this->input->post('vertretung_id')) ) ) status_feuern( 'danger', 'Vertretung'.STATUSMELDUNGEN['loeschen_erfolgreich']['meldung'], FALSE );
    else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
    redirect(ABSPRUNG);
  }

  //------------------------------------------------------------------------------------------------------------------
  public function einstellungen_passwort_aendern() {
    if( !is_null(ICH['passwort']) ) $this->form_validation->set_rules( 'passwort', 'Altes Passwort', 'required' );
    $this->form_validation->set_rules( 'passwort_neu', 'Neues Passwort', 'required' );
    $this->form_validation->set_rules( 'passwort_neu2', 'Neues Passwort (Wiederholung)', 'required|matches[passwort_neu]' );
    if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE );
    elseif( !is_null(ICH['passwort']) AND !password_verify( $this->input->post('passwort'), ICH['passwort'] ) ) status_feuern( 'danger', 'Das eingegebene alte Passwort ist nicht korrekt.', FALSE );
    else {
      $mitglied = ICH;
      $mitglied['passwort'] = password_hash( $this->input->post('passwort_neu'), PASSWORD_DEFAULT );
      if( !is_null(ICH['passwort']) ) $status = 'Passwort erfolgreich geändert.'; else $status = 'Passwort erfolgreich vergeben.';
      if( !$this->mitglieder_model->mitglied_db_aktualisieren( $mitglied ) ) status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
      else {
        status_feuern( 'success', $status, FALSE );
        if( !$this->einstellungen_passwort_aendern_email( $mitglied ) ) status_feuern( 'danger', STATUSMELDUNGEN['email_fehlgeschlagen']['meldung'] );
        else status_feuern( 'success', 'Es wurde eine Email verschickt an '.$mitglied['email'].' mit einer Bestätigung.' );
      }
  }
    redirect(ABSPRUNG);
  }

  private function einstellungen_passwort_aendern_email( $mitglied ) {
    $this->data['mitglied'] = $mitglied;
    $this->data['email']['text'] = 'für deinen Zugang zur '.VEREINSAPP_NAME.' hast du erfolgreich ein neues Passwort vergeben. Mit einem Klick auf den folgenden Link kehrst du direkt zum Login zurück:';
    $this->data['email']['hinweis'] = 'Diese Email dient liediglich zur Information. Falls du dein Passwort nicht selbst vergeben hast, dann nimm bitte schnellstmöglich Kontakt mit den dir bekannten Ansprechpersonen auf!';
    $this->data['button']['beschriftung'] = 'Zurück zum Login';
    $this->data['button']['link'] = LOGIN;
    //$this->load->view('login/email', $this->data );
    return $this->mail_schicken( $mitglied['email'], 'Neues Passwort wurde erfolgreich vergeben', $this->load->view('login/email', $this->data, TRUE) );
  }

  //------------------------------------------------------------------------------------------------------------------
  public function einstellungen_login_erlaubt() {
    $this->form_validation->set_rules('mitglied_id', 'Mitglied-ID', 'required|numeric');
    $this->form_validation->set_rules('login_erlaubt[]', MITGLIEDER_KATEGORIEN['login_erlaubt']['beschriftung'], 'required|in_list['.implode( ',', array_keys(LOGIN_ERLAUBT) ).']');
    if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE );
    elseif( array_key_exists( intval($this->input->post('mitglied_id')), MITGLIEDER ) ) {
      $mitglied = MITGLIEDER[ intval($this->input->post('mitglied_id')) ];
      if( !empty($this->input->post('login_erlaubt')) AND !is_null($this->input->post('login_erlaubt')) ) {
        $mitglied['login_erlaubt'] = $this->input->post('login_erlaubt');
        if( !in_array( 'email_passwort', $this->input->post('login_erlaubt') ) ) $mitglied['passwort'] = NULL;
      } else $this->standard_404();
        
      if( $this->mitglieder_model->mitglied_db_aktualisieren( $mitglied ) ) status_feuern( 'success', 'Einstellung'.STATUSMELDUNGEN['speichern_erfolgreich']['meldung'], FALSE );
      else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
    } else $this->standard_404();
    redirect(ABSPRUNG);
  }


  //------------------------------------------------------------------------------------------------------------------
  public function entwickler_timestamp_generieren() {
    if ( !in_array( '-e', ICH['rechte'] ) ) $this->standard_404(); else {
      $this->form_validation->set_rules('zeitpunkt', 'Zeitpunkt', 'required|callback_fv_datum_zeit');
      if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE );
      else status_feuern( 'success', $this->input->post('zeitpunkt').' => '.strtotime( $this->input->post('zeitpunkt') ).' (Kontrolle: '.date( 'd.m.Y H:i:s', strtotime( $this->input->post('zeitpunkt') ) ).')', FALSE );
      redirect(ABSPRUNG);
    }
  }

  public function entwickler_datum_uhrzeit_generieren() {
    if ( !in_array( '-e', ICH['rechte'] ) ) $this->standard_404(); else {
      $this->form_validation->set_rules('zeitpunkt', 'Zeitpunkt', 'required|numeric');
      if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE );
      else status_feuern( 'success', $this->input->post('zeitpunkt').' => '.date( 'd.m.Y H:i:s', intval($this->input->post('zeitpunkt')) ).' (Kontrolle: '.strtotime( date( 'd.m.Y H:i:s', $this->input->post('zeitpunkt') ) ).')', FALSE );
      redirect(ABSPRUNG);
    }
  }

  
  //------------------------------------------------------------------------------------------------------------------
  public function einstellung_setzen( ) {
    $erfolgreich = array();
    foreach( EINSTELLUNGEN as $gruppe => $funktionen ) foreach( $funktionen as $funktion => $wert ) {
      $this->form_validation->set_rules( $gruppe.'_'.$funktion.'_wert', $gruppe.'_'.$funktion.'_wert', 'alpha_dash' );
      if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE );
      elseif( $this->input->post($gruppe.'_gruppe') AND $this->input->post($funktion.'_funktion') ) {
        $einstellung_db = array(
          'zeitpunkt' => time(),
          'mitglied_id' => ICH['id'],
          'gruppe' => $gruppe,
          'funktion' => $funktion,
          'wert' => $this->input->post($gruppe.'_'.$funktion.'_wert'),
        );

        if( !$this->einstellungen_model->einstellung_setzen( $einstellung_db ) )
          $erfolgreich[] = FALSE;
      }
    }
    if( !in_array( FALSE, $erfolgreich ) ) status_feuern( 'success', 'Einstellung'.STATUSMELDUNGEN['speichern_erfolgreich']['meldung'], FALSE );
    else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
    redirect(ABSPRUNG);
  }
  
}
