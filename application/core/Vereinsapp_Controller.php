<?php
class Vereinsapp_Controller extends CI_Controller {

  public function __construct() {
    parent::__construct();

    $this->load->database();
    $this->load->library('form_validation');
    $this->form_validation_fehlermeldungen();
    $this->load->library('session');
    $this->load->library('email');
    $this->load->library('user_agent'); if( $this->agent->is_robot() ) redirect( OFFIZIELLE_WEBSITE );

    $config['protocol'] = 'sendmail';
    $config['mailpath'] = '/usr/sbin/sendmail';
    $config['charset'] = 'iso-8859-1';
    $config['wordwrap'] = FALSE;
    $config['mailtype'] = 'html';

    $this->email->initialize($config);

    $this->load->helper('url');
    $this->load->helper('form');
    $this->load->helper('cookie');
    $this->load->helper('vereinsapp');
    $this->load->helper('tabelle');
    $this->load->helper('verzeichnis');

    //$this->load->model('vereinsapp_model');
    $this->load->model('login_model');
    $this->load->model('einstellungen_model');
    $this->load->model('mitglieder_model');


    defined('HEAD_STYLESHEET') OR define( 'HEAD_STYLESHEET', array( 
      'bootstrap.min.css' => array( 'href' => 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css', 'integrity' => 'sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l', 'crossorigin' => 'anonymous', ),
      'bootstrap-icons.css' => array( 'href' => 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css', ),
      'vereinsapp.css' => array( 'href' => base_url('css/vereinsapp/vereinsapp.css'), ),
    ) );
    defined('HEAD_SCRIPT') OR define( 'HEAD_SCRIPT', array( 
      'jquery.js' => array( 'src' => 'https://code.jquery.com/jquery-3.6.0.js', ),
      'jquery.ui.js' => array( 'src' => 'https://code.jquery.com/ui/1.13.0/jquery-ui.js', ),
      'jquery.ui.touch-punch.min.js' => array( 'src' => 'https://cdn.jsdelivr.net/npm/jquery-ui-touch-punch@0.2.3/jquery.ui.touch-punch.min.js', ),
      'bootstrap.bundle.min.js' => array( 'src' => 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js', 'integrity' => 'sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns', 'crossorigin' => 'anonymous', ),
      'dayjs.min.js' => array( 'src' => 'https://cdn.jsdelivr.net/npm/dayjs@1.11.1/dayjs.min.js', ),
      'isToday.js' => array( 'src' => 'https://cdn.jsdelivr.net/npm/dayjs@1.11.1/plugin/isToday.js', ),
      'sha256.min.js' => array( 'src' => base_url('js/sha256/sha256.min.js'), ), // https://www.npmjs.com/package/js-sha256
      'vereinsapp.js' => array( 'src' => base_url('js/vereinsapp/vereinsapp.js'), ),
    ) );

    defined('LOGIN') OR define( 'LOGIN', site_url().'login' );
    defined('STARTSEITE') OR define( 'STARTSEITE', site_url().'startseite' );
    defined('DATENACHUTZ_RICHTLINIE_DATUM') OR define( 'DATENACHUTZ_RICHTLINIE_DATUM', 20210629 );

    defined('AJAX_REFRESH_INTERVALL') OR define( 'AJAX_REFRESH_INTERVALL', 5 );

    defined('BASE_URL') OR define( 'BASE_URL', $this->config->item('base_url') );
    defined('CONTROLLER') OR define( 'CONTROLLER', $this->router->fetch_class() );
    defined('METHOD') OR define( 'METHOD', $this->router->fetch_method() );


    defined('CONTROLLER_INT') OR define('CONTROLLER_INT', array(
      'startseite' => array ( 'titel' => 'Willkommen', 'symbol' => '', 'absprung' => array( 'index', ), ),
      'termine' => array ( 'titel' => 'Termine', 'symbol' => 'calendar-month', 'absprung' => array( 'index', 'details', 'anwesenheiten', ), ),
      'strafkatalog' => array ( 'titel' => 'Strafkatalog', 'symbol' => 'piggy-bank', 'absprung' => array( 'index', 'kassenbuch' ), ),
      'notenbank' => array ( 'titel' => 'Notenbank', 'symbol' => 'file-earmark-music', 'absprung' => array( 'index', 'titel', 'bewertung_notenverzeichnis', ), ),
      'umfragen' => array ( 'titel' => 'Umfragen', 'symbol' => 'signpost-split', 'absprung' => array( 'index', ), ), //stoplights   signpost-split
      'mitglieder' => array ( 'titel' => 'Mitglieder', 'symbol' => 'people', 'absprung' => array( 'index', 'details' ), ),
      'einstellungen' => array ( 'titel' => 'Einstellungen', 'symbol' => SYMBOLE['einstellungen']['bootstrap'], 'absprung' => array( 'index', ), ),
    ) );

    defined('CONTROLLER_EXT') OR define('CONTROLLER_EXT', array(
      'login' => array ( 'titel' => 'Login', 'symbol' => 'person', 'absprung' => array(), ),
    ) );

    defined('CONTROLLER_INT_EXT') OR define('CONTROLLER_INT_EXT', array_merge( CONTROLLER_INT, CONTROLLER_EXT ) );

    if( array_key_exists( CONTROLLER, CONTROLLER_INT_EXT ) AND in_array( METHOD, CONTROLLER_INT_EXT[ CONTROLLER ]['absprung'] ) ) $this->session->absprung = uri_string(); defined('ABSPRUNG') OR define( 'ABSPRUNG', $this->session->absprung );
    
    //echo 'TAGEBUCH='; $tagebuch = $this->session->tagebuch; $tagebuch[] = CONTROLLER.'/'.METHOD; $this->session->tagebuch = $tagebuch; print_r( $this->session->tagebuch );
    if( array_key_exists( CONTROLLER, CONTROLLER_INT ) AND
        !$this->session->ich_id AND
        !$this->login_model->dauerhaft_angemeldet()
    ) redirect(LOGIN);
    
    defined('ICH_ID') OR define('ICH_ID', $this->session->ich_id );

    defined('MITGLIEDER') OR define( 'MITGLIEDER', $this->mitglieder_model->mitglieder( NULL, array(), array( array( 'kategorie' => $this->einstellungen_model->standard_einstellung( 'mitglieder', 'sortieren_nach', $this->session->ich_id ), 'richtung' => SORT_ASC ) ) ) );
    if( array_key_exists( ICH_ID, MITGLIEDER ) ) defined('ICH') OR define( 'ICH', MITGLIEDER[ intval(ICH_ID) ] ); else defined('ICH') OR define( 'ICH', array() );


    $this->data['status_anzeigen_liste'] = array(); if( is_array( $this->session->status ) AND !empty( $this->session->status ) )
      foreach( $this->session->status as $status ) $this->data['status_anzeigen_liste'][] = array( 'view' => $this->load->view('templates/status_dynamisch', $status, TRUE ) );
    $this->session->status = array();


    $this->data['modals_anzeigen_liste'] = array();
    if( array_key_exists( CONTROLLER, CONTROLLER_INT ) AND array_key_exists( 'login_erlaubt', ICH ) AND is_null(ICH['login_erlaubt']) ) $this->data['modals_anzeigen_liste']['login_erlaubt'] = array( 'view' => $this->load->view('einstellungen/login_erlaubt_modal', $this->data, TRUE ) );
    if( ( array_key_exists( 'login_erlaubt', ICH ) AND ( is_null(ICH['login_erlaubt']) OR in_array( 'email_passwort', ICH['login_erlaubt'] ) ) ) AND
        ( array_key_exists( 'passwort', ICH ) AND is_null(ICH['passwort']) AND intval($this->input->cookie( 'vereinsapp_passwort_vergeben' ))+(60*60*24) < time() ) ) $this->data['modals_anzeigen_liste']['passwort_vergeben'] = array( 'view' => $this->load->view('einstellungen/passwort_vergeben_modal', $this->data, TRUE ) );

    if( strpos( METHOD, 'ajax' ) === FALSE ) $this->load->view('templates/header', $this->data ); 
    $this->data['links'] = array();
    $this->data['werkzeugkasten'] = array();
  }

  public $data = array();

  //------------------------------------------------------------------------------------------------------------------
  private function form_validation_fehlermeldungen() {
    $this->form_validation->set_message('required', 'Die Eingabe für %s ist zwingend erforderlich.');
    $this->form_validation->set_message('numeric', '%s enthält unzulässige Zeichen.');
    $this->form_validation->set_message('decimal', '%s enthält unzulässige Zeichen.');
    $this->form_validation->set_message('alpha', ' %s enthält unzulässige Zeichen.');
    $this->form_validation->set_message('alpha_dash', '%s enthält unzulässige Zeichen.');
    $this->form_validation->set_message('is_unique', '%s ist bereits verwendet und darf nicht mehrfach verwendet werden.');
  }

  //------------------------------------------------------------------------------------------------------------------
  public function fv_standard_textzeile($str) {
      if ( !preg_match('/^[a-zA-Z0-9,.:\- ÄäÖöÜüß]*$/', $str) ) { // --
        $this->form_validation->set_message('fv_standard_textzeile', 'Die Eingabe für %s enthält unzulässige Zeichen.');
        return FALSE;
      } else return TRUE;
  }

  public function fv_standard_rueckmeldung($str) {
    if ( !preg_match('/^[a-zA-Z0-9,\- ÄäÖöÜüß]*$/', $str) ) { // --
      $this->form_validation->set_message('fv_standard_rueckmeldung', 'Die Eingabe für %s enthält unzulässige Zeichen.');
      return FALSE;
    } else return TRUE;
  }

  public function fv_zeit($str) {
    if ( !preg_match('/^[0-9:]*$/', $str) ) {
        $this->form_validation->set_message('fv_zeit', 'Die Eingabe für %s enthält unzulässige Zeichen.');
        return FALSE;
    } else return TRUE;
  }

  public function fv_datum($str) {
    if ( !preg_match('/^[0-9\-]*$/', $str) ) {
        $this->form_validation->set_message('fv_datum', 'Die Eingabe für %s enthält unzulässige Zeichen.');
        return FALSE;
    } else return TRUE;
  }

  public function fv_datum_zeit($str) {
    if ( !preg_match('/^[T0-9:\-]*$/', $str) ) {
        $this->form_validation->set_message('fv_datum_zeit', 'Die Eingabe für %s enthält unzulässige Zeichen.');
        return FALSE;
    } else return TRUE;
  }


  //------------------------------------------------------------------------------------------------------------------
  public function standard_404() {
    //show_404();
    redirect( LOGIN );
  }

  //------------------------------------------------------------------------------------------------------------------
  protected function mail_schicken( $email, $betreff, $inhalt ) {
		$this->email->from( OFFIZIELLE_MAILADRESSE, VEREINSAPP_NAME ); //$this->email->from( 'noreply@mv-schwarzach.de', VEREINSAPP_NAME );
		$this->email->to( $email );
		$this->email->subject( htmlentities( VEREINSAPP_NAME.' - '.$betreff ) );
		$this->email->message( $inhalt );
		return $this->email->send();
  }
  
  //------------------------------------------------------------------------------------------------------------------
  public function parameter_aus_filter( $filterbare_kategorien, $filter, $tabelle = array(), $kategorien_db = array() ) {

    if( in_array( $filterbare_kategorien[ $filter['kategorie'] ], array( 'anfangsbuchstabe', ) ) ) {
      $verfuegbare_werte = array(); foreach( $tabelle as $zeile ) if( lcfirst( $zeile[ $filter['kategorie'] ][0] ) == lcfirst( $filter['filter'] ) ) $verfuegbare_werte[] = $zeile[ $filter['kategorie'] ];
      if( !empty( $verfuegbare_werte ) ) return array_unique( $verfuegbare_werte ); else return $filter['filter'];
    }

    elseif( in_array( $filterbare_kategorien[ $filter['kategorie'] ], array( 'verfuegbare_werte', 'vorgegebene_werte' ) ) ) return $filter['filter'];

    elseif( in_array( $filterbare_kategorien[ $filter['kategorie'] ], array( 'zahlenraum' ) ) )
      if( in_array( $filter['kategorie'], $kategorien_db ) ) { $parameter[ $filter['kategorie'].'>=' ] = $filter['filter']['start']; $parameter[ $filter['kategorie'].'<=' ] = $filter['filter']['ende']; }
      else return $filter['filter'];

    elseif( in_array( $filterbare_kategorien[ $filter['kategorie'] ], array( 'zeitraum', 'zeitraum_jahr' ) ) )
      if( in_array( $filter['kategorie'], $kategorien_db ) ) { $parameter[ $filter['kategorie'].'>=' ] =  $filter['filter']['start']; $parameter[ $filter['kategorie'].'<=' ] =  $filter['filter']['ende']; }
      else return  $filter['filter'];

  }

}