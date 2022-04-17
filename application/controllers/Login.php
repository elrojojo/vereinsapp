<?php
class Login extends Vereinsapp_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
    if( $this->session->ich_id ) redirect(ABSPRUNG); else {
      
      $this->form_validation->set_rules( 'email', 'Email', 'required|valid_email' );
      $this->form_validation->set_rules( 'angemeldet_bleiben', 'Angemeldet-bleiben-Checkbox', 'regex_match[/angemeldet_bleiben/]' );
      $this->form_validation->set_rules( 'aktion', 'Aktion', 'required|in_list[login,passwort_vergessen,einmal_link_erzeugen]' );
      if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors() );
      else { $email = $this->input->post('email'); $mitglieder = $this->mitglieder_model->mitglieder( NULL, array( 'email' => $email ) );
        
        if( array_key_exists( array_key_last($mitglieder), $mitglieder ) AND array_key_exists( 'loginversuche', $mitglieder[ array_key_last($mitglieder) ] ) AND intval($mitglieder[ array_key_last($mitglieder) ]['loginversuche']) <= 0 )  // Überprüfung ob noch Loginversuche zur Verfügung stehen
          $this->load->view('templates/status', array( 'farbe' => 'danger', 'status' => 'Dieser Zugang ist gesperrt. Es wurde in der Vergangenheit eine Email verschickt an '.$email.' mit einem Link zum Entsperren deines Zugangs. Bitte prüfe dein Email-Postfach und folge dort den Anweisungen!<hr>
          Du kannst dir jetzt erneut eine Email zuschicken lassen mit einem Link zum Entsperren deines Zugangs.'.form_open( site_url().'zugang_entsperren' ).'<input type="text" class="invisible" name="email" value="'.$email.'" />
          <button type="submit" class="btn btn-outline-danger btn-block mt-3">Email erneut zuschicken lassen</button></form>', 'dismissible' => TRUE ) );
        else {

          if( $this->input->post('aktion') == 'login' ) { // Login-Versuch
            $passwort = $this->input->post('passwort');
            $angemeldet_bleiben = FALSE; if( $this->input->post('angemeldet_bleiben') ) $angemeldet_bleiben = TRUE;
            if( empty($mitglieder) ) status_feuern( 'danger', 'Die Email-Adresse oder das Passwort war nicht korrekt. Wenn du dein Passwort vergessen hast, dann verwende die Funktion zum Vergeben eines neuen Passworts!' );
            else{ $mitglied = $mitglieder[ array_key_last($mitglieder) ];
              if( array_key_exists( 'passwort', $mitglied ) AND !password_verify( $passwort, $mitglied['passwort'] ) ) { // Überprüfung ob das Passwort korrekt ist
                status_feuern( 'danger', 'Die Email-Adresse oder das Passwort war nicht korrekt. Wenn du dein Passwort vergessen hast, dann verwende die Funktion zum Vergeben eines neuen Passworts!' );
                $this->zugang_absichern( $mitglied['id'] );
              } elseif( array_key_exists( 'login_erlaubt', $mitglied ) AND !( is_null($mitglied['login_erlaubt']) OR in_array( 'email_passwort', $mitglied['login_erlaubt'] ) ) ) // Überprüfung ob Email & Passwort erlaubt ist
                status_feuern( 'danger', 'Ein Zugang mit Email & Passwort hast du nicht erlaubt.' );
              elseif ($this->login_model->login( $mitglied['id'], $passwort, $angemeldet_bleiben ) ) {  // Login ist erfolgreich
                  status_feuern( 'success', 'Hallo '.$mitglied['vorname'].', du hast dich erfolgreich in die '.VEREINSAPP_NAME.' eingeloggt.', FALSE );
                  redirect(ABSPRUNG);
              } else { /* Es passiert nichts. */ }
            }
          }
          elseif( $this->input->post('aktion') == 'passwort_vergessen' ) {  // Passwort vergessen
            if( empty($mitglieder) ) status_feuern( 'danger', STATUSMELDUNGEN['email_fehlgeschlagen']['meldung'] );
            else{ $mitglied = $mitglieder[ array_key_last($mitglieder) ]; 
              if( array_key_exists( 'login_erlaubt', $mitglied ) AND ( is_null($mitglied['login_erlaubt']) OR !in_array( 'email_passwort', $mitglied['login_erlaubt'] ) ) ) // Überprüfung ob Email & Passwort erlaubt ist
                status_feuern( 'danger', 'Ein Zugang mit Email & Passwort hast du nicht erlaubt. Deshalb kannst du auch kein neues Passwort vergeben.' );
              else {
                $schluessel = schluessel_generieren();
                $mitglied['login_schluessel'] = password_hash( $schluessel, PASSWORD_DEFAULT );
                $mitglied['login_schluessel_zeitpunkt'] = time();
                if( !$this->mitglieder_model->mitglied_db_aktualisieren( $mitglied ) ) status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
                else {
                  if( !$this->passwort_vergeben_email( $mitglied, $schluessel ) ) status_feuern( 'danger', STATUSMELDUNGEN['email_fehlgeschlagen']['meldung'] );
                  else status_feuern( 'success', 'Es wurde eine Email verschickt an '.$mitglied['email'].' mit einem Link zum Vergeben eines neuen Passworts. Bitte prüfe dein Email-Postfach und folge dort den Anweisungen!' );
                }
              }
            }
          }
          elseif( $this->input->post('aktion') == 'einmal_link_erzeugen' ) {  // Einmal-Link erzeugen
            if( empty($mitglieder) ) status_feuern( 'danger', STATUSMELDUNGEN['email_fehlgeschlagen']['meldung'] );
            else{ $mitglied = $mitglieder[ array_key_last($mitglieder) ]; 
              if( array_key_exists( 'login_erlaubt', $mitglied ) AND !( is_null($mitglied['login_erlaubt']) OR in_array( 'einmal_link', $mitglied['login_erlaubt'] ) ) ) // Überprüfung ob Email & Passwort erlaubt ist oder die Entscheidung noch nicht gefällt wurde
                status_feuern( 'danger', 'Ein Zugang mit Einmal-Link hast du nicht erlaubt. Deshalb kannst du auch keinen Einmal-Link erzeugen.' );
              else {
                $schluessel = schluessel_generieren();
                $mitglied['login_schluessel'] = password_hash( $schluessel, PASSWORD_DEFAULT );
                $mitglied['login_schluessel_zeitpunkt'] = time();
                if( !$this->mitglieder_model->mitglied_db_aktualisieren( $mitglied ) ) status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
                else {
                  if( !$this->einmal_link_erzeugen_email( $mitglied, $schluessel ) ) status_feuern( 'danger', STATUSMELDUNGEN['email_fehlgeschlagen']['meldung'] );
                  else status_feuern( 'success', 'Es wurde eine Email verschickt an '.$mitglied['email'].' mit dem erzeugten Einmal-Link. Bitte prüfe dein Email-Postfach!' );
                }
              }
            }
          }
          else { /* Es passiert nichts. */ }
        }
      }
      
      if( !empty($this->input->post('email')) ) $this->data['login']['email'] = $this->input->post('email');
      $this->data['login']['aktion'] = 'login'; if( $this->input->post('aktion') ) $this->data['login']['aktion'] = $this->input->post('aktion');
      $this->load->view('login/login', $this->data);

      $this->load->view('templates/footer', $this->data);
    }
  }


  //------------------------------------------------------------------------------------------------------------------
  public function verknuepfen( $mitglied_id = NULL, $schluessel = NULL ) {
    if( is_null($mitglied_id) ) $this->standard_404();

    elseif( array_key_exists( $mitglied_id, MITGLIEDER ) AND // Mitglied existiert tatsächlich
        MITGLIEDER[ $mitglied_id ]['loginversuche'] > 0 AND // Mitglied ist nicht gesperrt
        array_key_exists( 'login_erlaubt', MITGLIEDER[ $mitglied_id ] ) AND ( is_null(MITGLIEDER[ $mitglied_id ]['login_erlaubt']) OR in_array( 'einmal_link', MITGLIEDER[ $mitglied_id ]['login_erlaubt'] ) ) AND  // Überprüfung ob Einmal-Links erlaubt sind oder ob die Entscheidung noch nicht gefällt wurde
        !is_null( MITGLIEDER[ $mitglied_id ]['login_schluessel'] ) AND password_verify( urldecode( $schluessel ), MITGLIEDER[ $mitglied_id ]['login_schluessel'] ) AND
        MITGLIEDER[ $mitglied_id ]['login_schluessel_zeitpunkt']+LOGIN_EINMAL_LINK_EXPIRE > time() ) {
      $mitglied = MITGLIEDER[ intval($mitglied_id) ];
      $mitglied['login_schluessel'] = NULL;
      $mitglied['login_schluessel_zeitpunkt'] = NULL;

      if( !$this->mitglieder_model->mitglied_db_aktualisieren( $mitglied ) OR !$this->login_model->login( intval($mitglied_id), NULL, TRUE ) ) status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
      else {
        status_feuern( 'success', 'Hallo '.$mitglied['vorname'].', du hast dein Gerät erfolgreich mit der '.VEREINSAPP_NAME.' verknüpft.', FALSE );
        if( !$this->verknuepfen_bestaetigung_email( $mitglied ) ) status_feuern( 'danger', STATUSMELDUNGEN['email_fehlgeschlagen']['meldung'] );
        else status_feuern( 'success', 'Es wurde eine Email verschickt an '.$mitglied['email'].' mit einer Bestätigung.' );
      }
    } else { $this->zugang_absichern( intval($mitglied_id) ); $this->standard_404(); }

    redirect(STARTSEITE);
  }

  private function einmal_link_erzeugen_email( $mitglied, $schluessel ) {
    $this->data['mitglied'] = $mitglied;
    $this->data['email']['text'] = 'für deinen Zugang zur '.VEREINSAPP_NAME.' hast du einen Einmal-Link erzeugt. Du kannst diesen Link sofort benutzen um dieses Gerät mit der '.VEREINSAPP_NAME.' zu verknuepfen:';
    $this->data['email']['hinweis'] = 'Diese Email mitsamt dem darin enthaltenen Link ist max. '.floor( LOGIN_EINMAL_LINK_EXPIRE/(60*60) ).' Stunden gültig und alle vorher erzeugten Einmal-Links sind jetzt ungültig. Falls du garkeinen Einmal-Link erzeugen wolltest, dann ignoriere diese E-Mail einfach!';
    $this->data['button']['beschriftung'] = 'Einmal-Link benutzen';
    $this->data['button']['link'] = site_url().'verknuepfen/'.$mitglied['id'].'/'.urlencode($schluessel);
    //$this->load->view('login/email', $this->data );
    return $this->mail_schicken( $mitglied['email'], 'Einmal-Link', $this->load->view('login/email', $this->data, TRUE) );
  }

  private function verknuepfen_bestaetigung_email( $mitglied ) {
    $this->data['mitglied'] = $mitglied;
    $this->data['email']['text'] = 'du hast dein Gerät erfolgreich mit der '.VEREINSAPP_NAME.' verknüpft, z.B. mit einem Einmal-Link. Mit einem Klick auf den folgenden Link kehrst du direkt dorthin zurück:';
    $this->data['email']['hinweis'] = 'Diese Email dient lediglich zur Information. Falls du dein Gerät nicht selbst verknüpft hast, dann nimm bitte schnellstmöglich Kontakt mit den dir bekannten Ansprechpersonen auf!';
    $this->data['button']['beschriftung'] = 'Zur '.VEREINSAPP_NAME;
    $this->data['button']['link'] = STARTSEITE;
    //$this->load->view('login/email', $this->data );
    return $this->mail_schicken( $mitglied['email'], 'Dein Geraet wurde erfolgreich verknuepft!', $this->load->view('login/email', $this->data, TRUE) );
  }


  //------------------------------------------------------------------------------------------------------------------
  public function passwort_vergeben( $mitglied_id = NULL, $schluessel = NULL ) {
    if( is_null($mitglied_id) ) $this->standard_404();
    elseif( array_key_exists( $mitglied_id, MITGLIEDER ) AND // Mitglied existiert tatsächlich
        MITGLIEDER[ $mitglied_id ]['loginversuche'] > 0 AND // Mitglied ist nicht gesperrt
        array_key_exists( 'login_erlaubt', MITGLIEDER[ $mitglied_id ] ) AND in_array( 'einmal_link', MITGLIEDER[ $mitglied_id ]['login_erlaubt'] ) AND  // Überprüfung ob Email & Passwprt erlaubt ist
        !is_null( MITGLIEDER[ $mitglied_id ]['login_schluessel'] ) AND password_verify( urldecode( $schluessel ), MITGLIEDER[ $mitglied_id ]['login_schluessel'] ) AND
        MITGLIEDER[ $mitglied_id ]['login_schluessel_zeitpunkt']+LOGIN_PASSWORT_VERGEBEN_EXPIRE > time() ) {

      $this->form_validation->set_rules( 'passwort_neu', 'Passwort', 'required' );
      $this->form_validation->set_rules( 'passwort_neu2', 'Passwort-Wiederholung', 'required|matches[passwort_neu]' );
      if ( !$this->form_validation->run() ) {
        if( !empty(validation_errors()) ) status_feuern( 'danger', validation_errors() );
        $this->data['mitglied_id'] = $mitglied_id;
        $this->data['schluessel'] = urlencode($schluessel);
        $this->load->view('login/passwort_vergeben', $this->data);
        $this->load->view('templates/footer', $this->data);
      }

      else {
        $mitglied = MITGLIEDER[ intval($mitglied_id) ];
        $mitglied['passwort'] = password_hash( $this->input->post('passwort_neu'), PASSWORD_DEFAULT );
        $mitglied['login_schluessel'] = NULL;
        $mitglied['login_schluessel_zeitpunkt'] = NULL;
        if( !$this->mitglieder_model->mitglied_db_aktualisieren( $mitglied ) ) status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
        else {
          status_feuern( 'success', 'Du hast erfolgreich ein neues Passwort vergeben.', FALSE );
          if( !$this->passwort_vergeben_bestaetigung_email( $mitglied ) ) status_feuern( 'danger', STATUSMELDUNGEN['email_fehlgeschlagen']['meldung'] );
          else status_feuern( 'success', 'Es wurde eine Email verschickt an '.$mitglied['email'].' mit einer Bestätigung.' );
        }
        redirect(LOGIN);
      }
    } else { $this->zugang_absichern( $mitglied_id ); $this->standard_404(); }
  }

  private function passwort_vergeben_email( $mitglied, $schluessel ) {
    $this->data['mitglied'] = $mitglied;
    $this->data['email']['text'] = 'für deinen Zugang zur '.VEREINSAPP_NAME.' möchtest du ein neues Passwort vergeben. Mit einem Klick auf den folgenden Link kannst du ein neues Passwort vergeben:';
    $this->data['email']['hinweis'] = 'Diese Email mitsamt dem darin enthaltenen Link ist max. '.floor( LOGIN_PASSWORT_VERGEBEN_EXPIRE/(60*60) ).' Stunden gültig. Falls dir dein Passwort wieder eingefallen ist oder falls du dein Passwort garnicht neu vergeben willst, dann ignoriere diese E-Mail einfach!';
    $this->data['button']['beschriftung'] = 'Neues Passwort vergeben';
    $this->data['button']['link'] = site_url().'passwort_vergeben/'.$mitglied['id'].'/'.urlencode($schluessel);
    //$this->load->view('login/email', $this->data );
    return $this->mail_schicken( $mitglied['email'], 'Neues Passwort vergeben', $this->load->view('login/email', $this->data, TRUE) );
  }

  private function passwort_vergeben_bestaetigung_email( $mitglied ) {
    $this->data['mitglied'] = $mitglied;
    $this->data['email']['text'] = 'für deinen Zugang zur '.VEREINSAPP_NAME.' hast du erfolgreich ein neues Passwort vergeben. Mit einem Klick auf den folgenden Link kehrst du direkt zum Login zurück:';
    $this->data['email']['hinweis'] = 'Diese Email dient lediglich zur Information. Falls du dein Passwort nicht selbst vergeben hast, dann nimm bitte schnellstmöglich Kontakt mit den dir bekannten Ansprechpersonen auf!';
    $this->data['button']['beschriftung'] = 'Zurück zum Login';
    $this->data['button']['link'] = LOGIN;
    //$this->load->view('login/email', $this->data );
    return $this->mail_schicken( $mitglied['email'], 'Neues Passwort wurde erfolgreich vergeben', $this->load->view('login/email', $this->data, TRUE) );
  }


  //------------------------------------------------------------------------------------------------------------------
  public function zugang_entsperren( $mitglied_id = NULL, $schluessel = NULL ) {

    $this->form_validation->set_rules( 'email', 'Email', 'required|valid_email' );
    if( $this->form_validation->run() ) {
      $mitglieder = $this->mitglieder_model->mitglieder( NULL, array( 'email' => $this->input->post('email') ) );
      if( !empty($mitglieder) ) { $mitglied = $mitglieder[ array_key_last($mitglieder) ];
        $schluessel = schluessel_generieren();
        $mitglied['login_schluessel'] = password_hash( $schluessel, PASSWORD_DEFAULT );
        $mitglied['login_schluessel_zeitpunkt'] = time();
        if( !$this->mitglieder_model->mitglied_db_aktualisieren( $mitglied ) ) status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
        else {
          if( !$this->zugang_entsperren_email( $mitglied, $schluessel ) ) status_feuern( 'danger', STATUSMELDUNGEN['email_fehlgeschlagen']['meldung'], FALSE );
          else status_feuern( 'success', 'Es wurde eine Email verschickt an '.$mitglied['email'].' mit einem Link zum Entsperren deines Zugangs. Bitte prüfe dein Email-Postfach und folge dort den Anweisungen!' );
        }
      } else $this->standard_404();
    }

    elseif( is_null($mitglied_id) ) $this->standard_404();
    elseif( array_key_exists( $mitglied_id, MITGLIEDER ) AND // Mitglied existiert tatsächlich
            !is_null( MITGLIEDER[ $mitglied_id ]['login_schluessel'] ) AND password_verify( urldecode( $schluessel ), MITGLIEDER[ $mitglied_id ]['login_schluessel'] ) AND
            MITGLIEDER[ $mitglied_id ]['login_schluessel_zeitpunkt']+LOGIN_ZUGANG_ENTSPERREN_EXPIRE > time() ) {
      $mitglied = MITGLIEDER[ intval($mitglied_id) ];
      $mitglied['loginversuche'] = LOGIN_VERSUCHE;  // Zurücksetzen der Loginversuche
      $mitglied['login_schluessel'] = NULL;
      $mitglied['login_schluessel_zeitpunkt'] = NULL;
      if( !$this->mitglieder_model->mitglied_db_aktualisieren( $mitglied ) ) status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
      else {
        status_feuern( 'success', 'Du hast deinen Zugang erfolgreich entsperrt.', FALSE );  // AND $this->login_model->login( $mitglied_id )
        if( !$this->zugang_entsperren_bestaetigung_email( $mitglied ) ) status_feuern( 'danger', STATUSMELDUNGEN['email_fehlgeschlagen']['meldung'] );
        else status_feuern( 'success', 'Es wurde eine Email verschickt an '.$mitglied['email'].' mit einer Bestätigung.' );
      }
    } else { $this->zugang_absichern( $mitglied_id ); $this->standard_404(); }

    redirect(LOGIN);
  }

  private function zugang_entsperren_email( $mitglied, $schluessel ) {
    $this->data['mitglied'] = $mitglied;
    $this->data['email']['text'] = 'dein Zugang zur '.VEREINSAPP_NAME.' wurde gesperrt. Dies liegt wahrscheinlich daran, dass du dein Passwort zu oft falsch eingegeben hast. Mit einem Klick auf den folgenden Link kannst du deinen Zugang entsperren:';
    $this->data['email']['hinweis'] = 'Diese Email mitsamt dem darin enthaltenen Link ist max. '.floor( LOGIN_ZUGANG_ENTSPERREN_EXPIRE/(60*60) ).' Stunden gültig. Falls du dir sicher bist, dass du dein Passwort nicht mehrmalig falsch eingegeben hast, dann kann die Ursache der Sperrung auch ein Angriffsversuch auf die '.VEREINSAPP_NAME.' sein. Nimm in diesem Fall bitte schnellstmöglich Kontakt mit den dir bekannten Ansprechpersonen auf!';
    $this->data['button']['beschriftung'] = 'Zugang entsperren';
    $this->data['button']['link'] = site_url().'zugang_entsperren/'.$mitglied['id'].'/'.urlencode($schluessel);
    //$this->load->view('login/email', $this->data );
    return $this->mail_schicken( $mitglied['email'], 'Dein Zugang wurde gesperrt!', $this->load->view('login/email', $this->data, TRUE) );
  }

  private function zugang_entsperren_bestaetigung_email( $mitglied ) {
    $this->data['mitglied'] = $mitglied;
    $this->data['email']['text'] = 'dein Zugang zur '.VEREINSAPP_NAME.' wurde erfolgreich entsperrt. Du kannst deinen Zugang nun wieder wie gewohnt nutzen. Mit einem Klick auf den folgenden Link kehrst du direkt zum Login zurück:';
    $this->data['email']['hinweis'] = 'Diese Email dient lediglich zur Information.';
    $this->data['button']['beschriftung'] = 'Zurück zum Login';
    $this->data['button']['link'] = LOGIN;
    //$this->load->view('login/email', $this->data );
    return $this->mail_schicken( $mitglied['email'], 'Dein Zugang wurde erfolgreich entsperrt!', $this->load->view('login/email', $this->data, TRUE) );
  }


  //------------------------------------------------------------------------------------------------------------------
  private function zugang_absichern( $mitglied_id ) {
    if( array_key_exists( $mitglied_id, MITGLIEDER ) ) { $mitglied = MITGLIEDER[ $mitglied_id ]; // Mitglied existiert tatsächlich
      $mitglied['loginversuche']--;

      if( intval($mitglied['loginversuche']) > 0 ) {
        if( $this->mitglieder_model->mitglied_db_aktualisieren( $mitglied ) ) status_feuern( 'danger', 'Du hast noch '.$mitglied['loginversuche'].' Versuche bis dein Zugang aus Sicherheitsgründen gesperrt wird.' );
      } elseif( intval($mitglied['loginversuche']) == 0 ) {  // Zugang wird gesperrt
        $schluessel = schluessel_generieren();
        $mitglied['login_schluessel'] = password_hash( $schluessel, PASSWORD_DEFAULT );
        $mitglied['login_schluessel_zeitpunkt'] = time();
        if( !$this->mitglieder_model->mitglied_db_aktualisieren( $mitglied ) ) status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
        else {
          if( !$this->zugang_entsperren_email( $mitglied, $schluessel ) ) status_feuern( 'danger', STATUSMELDUNGEN['email_fehlgeschlagen']['meldung'], FALSE );
          else status_feuern( 'success', 'Es wurde eine Email verschickt an '.$mitglied['email'].' mit einem Link zum Entsperren deines Zugangs. Bitte prüfe dein Email-Postfach und folge dort den Anweisungen!' );
        }
      } else { /* Wenn loginversuche < 0 (also wenn das Mitglied gesperrt ist) passiert nichts. */ }
    } else { /* Wenn mitglied_id kein Index von MITGLIEDER ist (also wenn das Mitglied nicht existiert) passiert nichts. */ }
  }
  

  //------------------------------------------------------------------------------------------------------------------
  public function logout() {
    if( $this->session->ich_id AND session_destroy() ) {  // Logout ist erfolgreich
      if( $this->input->cookie('vereinsapp_dauerhaft_angemeldet_identifier') ) $this->mitglieder_model->mitglieder_dauerhaft_angemeldet_austragen( $this->input->cookie('vereinsapp_dauerhaft_angemeldet_identifier') );
      delete_cookie( 'vereinsapp_dauerhaft_angemeldet_identifier' );  // php in model Login_model
      delete_cookie( 'vereinsapp_dauerhaft_angemeldet_securitytoken' ); // php in model Login_model
      $this->load->view('login/logout');
      $this->load->view('templates/status', array( 'farbe' => 'success', 'status' => 'Du hast dich erfolgreich aus der '.VEREINSAPP_NAME.' ausgeloggt. Kehre zum Login zurück Um dich erneut einloggen zu können! <a class="btn btn-outline-success btn-block mt-3" href="'.LOGIN.'">Zurück zum Login</a>' ) );
    } else redirect(LOGIN);
  }
  
  public function ajax_datenschutz_richtlinie() {
    echo $this->load->view('login/datenschutz_richtlinie', $this->data, TRUE );
  }

}
