<?php
class Login_model extends CI_Model {

  public function __construct() {
    parent::__construct();
  }

  public function login( $mitglied_id, $passwort = NULL, $angemeldet_bleiben = FALSE ) {
    $mitglied = $this->mitglieder_model->mitglieder( intval($mitglied_id) ); if( !empty($mitglied) ) {  // Mitglied existiert und es wir die aktuelle Definition aus der DB geholt

      if( !is_null($passwort) AND password_needs_rehash( $mitglied['passwort'], PASSWORD_DEFAULT) ) // Prüfen ob verwendete Hash-Methode der aktuellen Methode entspricht
        $mitglied['passwort'] = password_hash( $passwort, PASSWORD_DEFAULT );

      $mitglied['loginversuche'] = LOGIN_VERSUCHE;  // Zurücksetzen der Loginversuche
      if( !$this->mitglieder_model->mitglied_db_aktualisieren( $mitglied ) ) return FALSE;

      if( $angemeldet_bleiben ) { // Wenn dauerhaft angemeldet bleiben soll
        $dauerhaft_angemeldet = $this->mitglieder_model->mitglieder_dauerhaft_angemeldet( NULL, array( 'identifier' => $this->input->cookie('vereinsapp_dauerhaft_angemeldet_identifier') ) );
        if( !empty($dauerhaft_angemeldet) ) $identifier = $dauerhaft_angemeldet[ array_key_last($dauerhaft_angemeldet) ]['identifier']; else $identifier = schluessel_generieren();
        $securitytoken = schluessel_generieren();
        $dauerhaft_angemeldet = array( 'zeitpunkt' => time(), 'mitglied_id' => $mitglied['id'], 'identifier' => $identifier, 'securitytoken' => $securitytoken, );
        $this->input->set_cookie( array( 'name' => 'vereinsapp_dauerhaft_angemeldet_identifier', 'value' => $dauerhaft_angemeldet['identifier'], 'expire' => LOGIN_COOKIE_EXPIRE ) );//, 'httponly' => TRUE ) ); // 'domain' => '', // 'path' => '', // 'prefix' => '', // 'secure' => TRUE,
        $this->input->set_cookie( array( 'name' => 'vereinsapp_dauerhaft_angemeldet_securitytoken', 'value' => $dauerhaft_angemeldet['securitytoken'], 'expire' => LOGIN_COOKIE_EXPIRE ) );//, 'httponly' => TRUE ) ); // 'domain' => '', // 'path' => '', // 'prefix' => '', // 'secure' => TRUE,
        $dauerhaft_angemeldet['securitytoken'] = password_hash( $dauerhaft_angemeldet['securitytoken'], PASSWORD_DEFAULT );
        if( !$this->mitglieder_model->mitglieder_dauerhaft_angemeldet_eintragen( $dauerhaft_angemeldet ) ) return FALSE;
      }
      //$this->session->sess_regenerate( TRUE );  // Zur Verhinderung von Session Hijacking
      $this->session->ich_id = $mitglied['id'];
      return TRUE;
      
    } return FALSE;  
  }

  public function dauerhaft_angemeldet() {
    $dauerhaft_angemeldet = $this->mitglieder_model->mitglieder_dauerhaft_angemeldet( NULL, array( 'identifier' => $this->input->cookie('vereinsapp_dauerhaft_angemeldet_identifier') ) );
    if( !empty($dauerhaft_angemeldet) ) {
      $dauerhaft_angemeldet = $dauerhaft_angemeldet[ array_key_last($dauerhaft_angemeldet) ];
      if( array_key_exists( 'securitytoken', $dauerhaft_angemeldet ) AND password_verify( $this->input->cookie('vereinsapp_dauerhaft_angemeldet_securitytoken'), $dauerhaft_angemeldet['securitytoken'] ) )
        return $this->login( intval($dauerhaft_angemeldet['mitglied_id']), NULL, TRUE );
    } else return FALSE;
  }

}