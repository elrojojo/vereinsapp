<?php
class Mitglieder extends Vereinsapp_Controller {

  public function __construct() {
    parent::__construct();


    if( !isset( $this->session->mitglieder_sortieren ) OR empty( $this->session->mitglieder_sortieren ) )
      $this->session->mitglieder_sortieren = array_values( array( array( 'kategorie' => $this->einstellungen_model->standard_einstellung( 'mitglieder', 'sortieren_nach', ICH['id'] ), 'richtung' => SORT_ASC ) ) );
  }

  public function index() {
    $sortieren = $this->session->mitglieder_sortieren;
    $filtern = array(); $parameter = array();
    if( isset( $this->session->mitglieder_filtern ) AND !empty( $this->session->mitglieder_filtern ) ) {
      foreach( $this->session->mitglieder_filtern as $filter )
        $parameter[ $filter['kategorie'] ] = $this->parameter_aus_filter( MITGLIEDER_FILTERBARE_KATEGORIEN, $filter, MITGLIEDER, MITGLIEDER_KATEGORIEN_DB );
      $filtern = $this->session->mitglieder_filtern;
    }

    $mitglieder = $this->mitglieder_model->mitglieder( NULL, $parameter, mitglieder_kategorie_sortierkorrektur( $sortieren ) );

    $liste = array( 'beschriftung_h5' => TRUE, /*'sortable' => TRUE*/ ); //$position = 1;
    if( !empty($mitglieder) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_kopf', $this->data); unset($liste['kopf']); }
    foreach( $mitglieder as $mitglied ) {
      //$liste['element']['id'] = $mitglied['id']; $liste['element']['sortable'] = TRUE; $liste['element']['position'] = $position; $position++;
      $liste['element']['beschriftung'] = $mitglied['vorname'].' '.$mitglied['nachname'];

      $liste['element']['truncate'] = ''; foreach( MITGLIEDER_KATEGORIEN_VORSCHAU as $id => $vorschau_kategorie ) {
        if( empty($mitglied[ $vorschau_kategorie ]) ) continue; else {
          $aufsteigend = NULL; foreach( $sortieren as $prioritaet => $reihenfolge ) if( $vorschau_kategorie == $reihenfolge['kategorie'] ) {
            $prioritaet_real = $prioritaet+1;
            if( $reihenfolge['richtung'] == SORT_DESC ) $aufsteigend = FALSE; else $aufsteigend = TRUE;
          }
          $liste['element']['truncate'] .= mitglied_wert_formatiert( $mitglied[ $vorschau_kategorie ], $vorschau_kategorie );
          if( !is_null($aufsteigend) ) {
            $liste['element']['truncate'] .= ' <span class="badge badge-primary"><i class="bi bi-';
            if( $aufsteigend ) $liste['element']['truncate'] .= SYMBOLE['aufsteigend']['bootstrap']; else $liste['element']['truncate'] .= SYMBOLE['absteigend']['bootstrap'];
            $liste['element']['truncate'] .= '"></i><span class="small">'.$prioritaet_real.'</span></span>';
          }
          if( array_key_last( MITGLIEDER_KATEGORIEN_VORSCHAU ) != $id ) $liste['element']['truncate'] .= '<i class="bi bi-dot"></i>';
        }
      }

      $liste['element']['float_right'] = '';
      if( in_array( '-m', ICH['rechte'] ) AND intval($mitglied['loginversuche']) == 0 ) $liste['element']['float_right'] .= '<span class="stretched-link-unwirksam ml-1 text-danger" role="button" data-toggle="popover" data-placement="left" data-content="'.MITGLIEDER_GESPERRT_STANDARD.'" tabindex="0" data-trigger="focus">'.SYMBOLE['gesperrt']['html'].'</span>';
      if( date( 'd.m.', $mitglied['geburtstag'] ) == date( 'd.m.' ) ) $liste['element']['float_right'] .= '<span class="stretched-link-unwirksam ml-1" role="button" data-toggle="popover" data-placement="left" data-content="'.MITGLIEDER_GEBURTSTAG_STANDARD_PRE.floor( ( intval($mitglied['geburtstag']) - intval($mitglied['geburt']) ) / SEK_PRO_JAHR ).MITGLIEDER_GEBURTSTAG_STANDARD_POST.'" tabindex="0" data-trigger="focus">'.SYMBOLE['geburtstag']['html'].'</span>';
      $mitglied_abwesenheit = $this->mitglieder_model->mitglieder_abwesenheiten( NULL, array( 'mitglied_id' => intval($mitglied['id']), 'start<=' => time(), 'ende>=' => time(), ) ); if( !empty($mitglied_abwesenheit) ) {
        $mitglied_abwesenheit = $mitglied_abwesenheit[ array_key_last($mitglied_abwesenheit) ]; if( empty($mitglied_abwesenheit['bemerkung']) ) $mitglied_abwesenheit['bemerkung'] = MITGLIEDER_ABWESENHEITEN_BEMERKUNG_STANDARD;
        $liste['element']['float_right'] .= '<span class="stretched-link-unwirksam ml-1" role="button" data-toggle="popover" data-placement="left" data-content="'.$mitglied_abwesenheit['bemerkung'].'" tabindex="0" data-trigger="focus">'.SYMBOLE['abwesend']['html'].'</span>';
      }

      $liste['element']['symbol'] = SYMBOLE['info']['bootstrap'];
      $liste['element']['link'] = CONTROLLER.'/details/'.$mitglied['id'];

      if( in_array( '-m', ICH['rechte'] ) ) {
        $this->data['eintragen']['mitglieder'][ intval($mitglied['id']) ] = $mitglied;
        $this->data['austragen']['id'] = 'mitglied_austragen'; $this->data['austragen']['elemente'][ intval($mitglied['id']) ] = array( 'beschriftung' => $mitglied['vorname'] .' '.$mitglied['nachname'] );

        $this->data['liste_element_werkzeugkasten'] = array( 'id' => $mitglied['id'], 'werkzeugkasten' => array(), );
        $this->data['liste_element_werkzeugkasten']['werkzeugkasten'][] = array( 'ziel' => $this->data['austragen']['id'], 'symbol' => SYMBOLE['loeschen']['bootstrap'], 'farbe' => 'danger', 'data' => array( 'element_id' => intval($mitglied['id']), ), );
        $this->data['liste_element_werkzeugkasten']['werkzeugkasten'][] = array( 'ziel' => 'mitglied_eintragen', 'symbol' => SYMBOLE['duplizieren']['bootstrap'], 'data' => array( 'mitglied_id' => intval($mitglied['id']), 'aktion' => 'duplizieren', ), );
        $this->data['liste_element_werkzeugkasten']['werkzeugkasten'][] = array( 'ziel' => 'mitglied_eintragen', 'symbol' => SYMBOLE['aendern']['bootstrap'], 'data' => array( 'mitglied_id' => intval($mitglied['id']), 'aktion' => 'aendern', ), );
        $this->data['liste_element_werkzeugkasten'] = $this->load->view('templates/liste_element_werkzeugkasten', $this->data, TRUE);
      }

      $this->data['liste'] = $liste; $this->load->view('templates/liste_element', $this->data); unset($liste['element']);
    }
    if( !empty($mitglieder) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_fuss', $this->data); unset($liste); }

    if( in_array( '-m', ICH['rechte'] ) ) {
      $this->data['werkzeugkasten'][] = array( 'ziel' => 'mitglieder_auswaehlen', 'symbol' => SYMBOLE['email']['bootstrap'], 'data' => array( 'element_id' => 1 ) );
      $this->data['werkzeugkasten'][] = array( 'ziel' => 'mitglieder_auswaehlen', 'symbol' => SYMBOLE['link']['bootstrap'], 'data' => array( 'element_id' => 0 ) );
      $mitglieder_einnmal_link_erlaubt = array(); foreach( MITGLIEDER as $mitglied ) if( is_null($mitglied['login_erlaubt']) OR in_array( 'einmal_link', $mitglied['login_erlaubt'] ) ) $mitglieder_einnmal_link_erlaubt[ intval($mitglied['id']) ] = $mitglied;
      $mitglieder_auswaehlen_checked = array();
      $mitglieder_auswaehlen_css = array(); foreach( MITGLIEDER as $mitglied )
        if( !is_null($mitglied['login_schluessel']) AND $mitglied['login_schluessel_zeitpunkt']+max( LOGIN_EINMAL_LINK_EXPIRE, LOGIN_PASSWORT_VERGEBEN_EXPIRE, LOGIN_ZUGANG_ENTSPERREN_EXPIRE ) > time() ) $mitglieder_auswaehlen_css[ $mitglied['id'] ] = 'text-danger';
      $this->data['mitglieder_auswaehlen'] = array(
        'form' => site_url().CONTROLLER.'/einmal_links_erzeugen', // immer gleich -> STRING
        'beschriftung' => 'Einmal-Links erzeugen',  // meistens immer gleich -> STRING
        'mitglieder_cluster' => tabelle_clustern( $mitglieder_einnmal_link_erlaubt, $this->einstellungen_model->standard_einstellung( 'mitglieder', 'gruppieren_nach', ICH['id'] ) ),  // immer gleich -> ARRAY nach mitglied_id
        'mitglieder_gruppieren_nach' => $this->einstellungen_model->standard_einstellung( 'mitglieder', 'gruppieren_nach', ICH['id'] ),  // immer gleich -> STRING
        'elemente' => array(
          0 => array( // = element_id -> NUM
            'bemerkung' => 'Einmal-Link erzeugen und direkt anzeigen (nicht-angezeigte Mitglieder haben den Zugang mit Einmal-Link nicht erlaubt)',  // diesmal immer gleich -> STRING
            'checked' => $mitglieder_auswaehlen_checked,  // diesmal immer gleich -> ARRAY nach mitglied_id
            'css' => $mitglieder_auswaehlen_css,  // diesmal immer gleich -> ARRAY nach mitglied_id    
          ),
          1 => array( // = element_id -> NUM
            'bemerkung' => 'Einmal-Link erzeugen und direkt per Email verschicken (nicht-angezeigte Mitglieder haben den Zugang mit Einmal-Link nicht erlaubt)',  // diesmal immer gleich -> STRING
            'checked' => $mitglieder_auswaehlen_checked,  // diesmal immer gleich -> ARRAY nach mitglied_id
            'css' => $mitglieder_auswaehlen_css,  // diesmal immer gleich -> ARRAY nach mitglied_id    
          ),
        )
      );
      $this->load->view('mitglieder/mitglieder_auswaehlen_modal', $this->data);
    }

    if( in_array( '-m', ICH['rechte'] ) ) {
      $this->data['werkzeugkasten'][] = array( 'ziel' => 'mitglied_eintragen',  'symbol' => SYMBOLE['hinzufuegen']['bootstrap'], 'data' => array( 'aktion' => 'eintragen', ) );

      $this->data['eintragen']['form'] = site_url().CONTROLLER.'/eintragen';
      $this->data['eintragen']['titel'] =  array( 'eintragen' => 'Mitglied eintragen', 'duplizieren' => 'Mitglied duplizieren', 'aendern' => 'Mitglied ändern', );
      $this->data['eintragen']['submit'] = array( 'eintragen' => 'Mitglied speichern', 'duplizieren' => 'Mitglied speichern', 'aendern' => 'Speichern', );
      $this->load->view('mitglieder/eintragen_modal', $this->data);

      $this->data['austragen']['form'] = site_url().CONTROLLER.'/austragen';
      $this->data['austragen']['titel'] = 'Mitglied';
      //$this->data['austragen']['submit'] = array( 'austragen' => 'Mitglied löschen', );
      if( !empty($mitglieder) ) $this->load->view('templates/austragen_modal', $this->data);
    }

    $this->data['filtern'] = $filtern; $this->data['sortieren'] = $sortieren;
    //$this->data['werkzeugkasten'][] = array( 'typ' => 'modal', 'ziel' => CONTROLLER.'_filtern', 'symbol' => SYMBOLE['filtern']['bootstrap'] );
    //$this->data['view'] = array( 'filterbare_kategorien' => MITGLIEDER_FILTERBARE_KATEGORIEN, 'kategorien' => MITGLIEDER_KATEGORIEN, 'objekte' => MITGLIEDER ); $this->load->view('templates/filtern', $this->data);
    $this->data['werkzeugkasten'][] = array( 'typ' => 'modal', 'ziel' => CONTROLLER.'_sortieren', 'symbol' => SYMBOLE['sortieren']['bootstrap'] );
    $this->data['view'] = array( 'sortierbare_kategorien' => MITGLIEDER_SORTIERBARE_KATEGORIEN, 'kategorien' => MITGLIEDER_KATEGORIEN ); $this->load->view('templates/sortieren', $this->data);

    $this->data['werkzeugkasten'][] = array( 'typ' => 'modal', 'ziel' => 'einstellungen', 'symbol' => SYMBOLE['einstellungen']['bootstrap'] );
    $this->data['einstellungen'] = array( 'mitglieder' => array( 'sortieren_nach' => NULL, ), );
    foreach( $this->data['einstellungen'] as $gruppe => $funktionen ) foreach( $funktionen as $funktion => $wert )
      $this->data['einstellungen'][ $gruppe ][ $funktion ] = $this->einstellungen_model->standard_einstellung( $gruppe, $funktion, ICH['id'] );
    $this->load->view('einstellungen/einstellungen_modal', $this->data);

    $this->load->view('templates/footer', $this->data);
  }

  //------------------------------------------------------------------------------------------------------------------
  public function sortieren( $kategorie ) {
    $sortieren = array( array( 'kategorie' => urldecode( $kategorie ), 'richtung' => SORT_ASC ) );
    $this->session->mitglieder_sortieren = array_values($sortieren);
    redirect(ABSPRUNG);
  }

  public function sortieren_hinzu( $kategorie ) {
    $sortieren = $this->session->mitglieder_sortieren; if( !is_array($sortieren) ) $sortieren = array();
    $sortieren[] = array( 'kategorie' => urldecode( $kategorie ), 'richtung' => SORT_ASC );
    $this->session->mitglieder_sortieren = array_values($sortieren);
    redirect(ABSPRUNG);
  }

  public function sortieren_umkehren( $kategorie ) {
    $sortieren = $this->session->mitglieder_sortieren; if( !is_array($sortieren) ) $sortieren = array();
    foreach( $sortieren as $prioritaet => $reihenfolge )
      if( urldecode( $kategorie ) == $reihenfolge['kategorie'] ) if( $reihenfolge['richtung'] == SORT_DESC ) $sortieren[ $prioritaet ]['richtung'] = SORT_ASC; else $sortieren[ $prioritaet ]['richtung'] = SORT_DESC;
    $this->session->mitglieder_sortieren = array_values($sortieren);
    redirect(ABSPRUNG);
  }

  public function sortieren_loeschen( $kategorie ) {
    $sortieren = $this->session->mitglieder_sortieren; if( !is_array($sortieren) ) $sortieren = array();
    foreach( $sortieren as $prioritaet => $reihenfolge )
      if( urldecode( $kategorie ) == $reihenfolge['kategorie'] ) unset( $sortieren[ $prioritaet ] );
    $this->session->mitglieder_sortieren = array_values($sortieren);
    redirect(ABSPRUNG);
  }

  public function filtern_hinzu( $kategorie, $filter1 = NULL, $filter2 = NULL ) {
    if( is_null($filter1) ) {
      if( in_array( MITGLIEDER_FILTERBARE_KATEGORIEN[ urldecode( $kategorie ) ], array( 'verfuegbare_werte' ) ) ) {
        $this->form_validation->set_rules( $kategorie.'_filter1', MITGLIEDER_KATEGORIEN[ $kategorie ]['beschriftung'].'-Wert', 'required|callback_fv_standard_textzeile');
        if( !$this->form_validation->run() ) redirect(ABSPRUNG); else {
          $filter1 = $this->input->post($kategorie.'_filter1');
        }
      } elseif( in_array( MITGLIEDER_FILTERBARE_KATEGORIEN[ urldecode( $kategorie ) ], array( 'zeitraum', 'zeitraum_jahr' ) ) ) {
        $this->form_validation->set_rules( $kategorie.'_filter1', MITGLIEDER_KATEGORIEN[ $kategorie ]['beschriftung'].'-Start', 'required|callback_fv_datum_zeit');
        $this->form_validation->set_rules( $kategorie.'_filter2', MITGLIEDER_KATEGORIEN[ $kategorie ]['beschriftung'].'-Ende', 'required|callback_fv_datum_zeit');
        if( !$this->form_validation->run() ) redirect(ABSPRUNG); else {
          $filter1 = strtotime( $this->input->post($kategorie.'_filter1') );
          $filter2 = strtotime( $this->input->post($kategorie.'_filter2') );
        }
      } elseif( in_array( MITGLIEDER_FILTERBARE_KATEGORIEN[ urldecode( $kategorie ) ], array( 'zahlenraum' ) ) ) {
        $this->form_validation->set_rules( $kategorie.'_filter1', MITGLIEDER_KATEGORIEN[ $kategorie ]['beschriftung'].'-Start', 'required|numeric');
        $this->form_validation->set_rules( $kategorie.'_filter2', MITGLIEDER_KATEGORIEN[ $kategorie ]['beschriftung'].'-Ende', 'required|numeric');
        if( !$this->form_validation->run() ) redirect(ABSPRUNG); else {
          $filter1 = intval( $this->input->post($kategorie.'_filter1') );
          $filter2 = intval( $this->input->post($kategorie.'_filter2') ); 
        }
      }
    }
    $filtern = $this->session->mitglieder_filtern; if( !is_array($filtern) ) $filtern = array();
    foreach( $filtern as $prioritaet => $filter ) if( urldecode( $kategorie ) == $filter['kategorie'] ) unset( $filtern[ $prioritaet ] );
    if( in_array( MITGLIEDER_FILTERBARE_KATEGORIEN[ urldecode( $kategorie ) ], array( 'zeitraum', 'zeitraum_jahr', 'zahlenraum' ) ) ) $filter = array( 'start' => $filter1, 'ende' => $filter2, ); else $filter = $filter1;
    $filtern[] = array( 'kategorie' => urldecode( $kategorie ), 'filter' => $filter );
    $this->session->mitglieder_filtern = array_values($filtern);
    redirect(ABSPRUNG);
  }

  public function filtern_loeschen( $kategorie ) {
    $filtern = $this->session->mitglieder_filtern; if( !is_array($filtern) ) $filtern = array();
    foreach( $filtern as $prioritaet => $filter ) if( urldecode( $kategorie ) == $filter['kategorie'] ) unset( $filtern[ $prioritaet ] );
    $this->session->mitglieder_filtern = array_values($filtern);
    redirect(ABSPRUNG);
  }

  //------------------------------------------------------------------------------------------------------------------
  public function details( $id ) {
    if( !array_key_exists( intval($id), MITGLIEDER ) ) redirect(CONTROLLER); else {

      $this->data['mitglied'] = MITGLIEDER[ intval($id) ];

      $this->data['vorheriges_mitglied'] = FALSE; $this->data['naechstes_mitglied'] = FALSE;
      if( array_key_exists( intval($id), MITGLIEDER ) ) {
        $mitglieder_ids = array_column( MITGLIEDER, 'id' ); $position = array_search( $this->data['mitglied']['id'], $mitglieder_ids );
        if( $this->data['mitglied']['id'] != array_key_first(MITGLIEDER) ) $this->data['vorheriges_mitglied'] = MITGLIEDER[ $mitglieder_ids[ $position-1 ] ];
        if( $this->data['mitglied']['id'] != array_key_last(MITGLIEDER) ) $this->data['naechstes_mitglied'] = MITGLIEDER[ $mitglieder_ids[ $position+1 ] ];
      }
  
      $this->data['details']['float_right'] = '';
      if( in_array( '-m', ICH['rechte'] ) AND intval($this->data['mitglied']['loginversuche']) == 0 ) $this->data['details']['float_right'] .= '<span class="stretched-link-unwirksam ml-1 text-danger" role="button" data-toggle="popover" data-placement="left" data-content="'.MITGLIEDER_GESPERRT_STANDARD.'" tabindex="0" data-trigger="focus">'.SYMBOLE['gesperrt']['html'].'</span>';
      if( date( 'd.m.', $this->data['mitglied']['geburtstag'] ) == date( 'd.m.' ) ) $this->data['details']['float_right'] .= '<span class="stretched-link-unwirksam ml-1" role="button" data-toggle="popover" data-placement="left" data-content="'.MITGLIEDER_GEBURTSTAG_STANDARD_PRE.floor( ( intval($this->data['mitglied']['geburtstag']) - intval($this->data['mitglied']['geburt']) ) / SEK_PRO_JAHR ).MITGLIEDER_GEBURTSTAG_STANDARD_POST.'" tabindex="0" data-trigger="focus">'.SYMBOLE['geburtstag']['html'].'</span>';
      $mitglied_abwesenheit = $this->mitglieder_model->mitglieder_abwesenheiten( NULL, array( 'mitglied_id' => intval($this->data['mitglied']['id']), 'start<=' => time(), 'ende>=' => time(), ) ); if( !empty($mitglied_abwesenheit) ) {
        $mitglied_abwesenheit = $mitglied_abwesenheit[ array_key_last($mitglied_abwesenheit) ]; if( empty($mitglied_abwesenheit['bemerkung']) ) $mitglied_abwesenheit['bemerkung'] = MITGLIEDER_ABWESENHEITEN_BEMERKUNG_STANDARD;
        $this->data['details']['float_right'] .= '<span class="stretched-link-unwirksam ml-1" role="button" data-toggle="popover" data-placement="left" data-content="'.$mitglied_abwesenheit['bemerkung'].'" tabindex="0" data-trigger="focus">'.SYMBOLE['abwesend']['html'].'</span>';
      }
      
      $this->load->view('mitglieder/details', $this->data);
      $this->load->view('mitglieder/steckbrief', $this->data);

      if( in_array( '-m', ICH['rechte'] ) ) {

        $this->load->view('mitglieder/verwaltung', $this->data);

        $abwesenheiten = $this->mitglieder_model->mitglieder_abwesenheiten( NULL, array( 'mitglied_id' => $this->data['mitglied']['id'] ) );
        $this->load->view('templates/horizontale_linie', $this->data);
        $this->data['ueberschrift'] = 'Abwesenheiten'; $this->load->view('templates/ueberschrift', $this->data);
        $liste = array(); if( !empty($abwesenheiten ) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_kopf', $this->data); unset($liste['kopf']); }
        foreach( $abwesenheiten as $abwesenheit ) {
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
        if( !empty($abwesenheiten ) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_fuss', $this->data); unset($liste); }
        $this->data['austragen']['form'] = site_url().'einstellungen/abwesenheit_austragen';
        $this->data['austragen']['titel'] = 'Abwesenheit';
        //$this->data['austragen']['submit'] = array( 'austragen' => 'Abwesenheit löschen', );
        if( !empty($abwesenheiten ) ) $this->load->view('templates/austragen_modal', $this->data);
        $this->load->view('einstellungen/abwesenheit_eintragen', $this->data);

        $liste = array( 'form' => site_url().'einstellungen/einstellungen_rechte_aendern' ); 
        if( !empty(RECHTE) ) {
          $this->load->view('templates/horizontale_linie', $this->data);
          $this->data['ueberschrift'] = MITGLIEDER_KATEGORIEN['rechte']['beschriftung']; $this->load->view('templates/ueberschrift', $this->data);
          $this->data['liste'] = $liste; $this->load->view('templates/liste_kopf', $this->data); unset($liste['kopf']); }
        foreach( RECHTE as $recht => $eigenschaften ) {
          $liste['element']['beschriftung'] = '<div class="input-group flex-nowrap"><input class="form-check-input-lg" type="checkbox" value="'.$recht.'" name="rechte[]" id="'.$recht.'"';
          if( !$eigenschaften['veraenderbar'] // Recht darf nicht verändert werden
           OR ( !in_array( $recht, $this->data['mitglied']['rechte_db'] ) AND in_array( $recht, $this->data['mitglied']['rechte'] ) ) // Recht kommt durch Vertretungen o.ä.
           OR !in_array( '-r', ICH['rechte'] ) // ICH hat keine Rechte zum Ändern der Rechte
          ) $liste['element']['beschriftung'] .= ' disabled'; else $liste['element']['beschriftung'] .= ' onclick="this.form.submit();"';
          if( in_array( $recht, $this->data['mitglied']['rechte'] ) ) $liste['element']['beschriftung'] .= ' checked';
          $liste['element']['beschriftung'] .= ' /><label class="form-check-label" for="'.$recht.'">'.$eigenschaften['beschriftung'].'</label></div>';
          if( array_key_exists( 'bemerkung', $eigenschaften ) ) $liste['element']['small'] = $eigenschaften['bemerkung'];
          $this->data['liste'] = $liste; $this->load->view('templates/liste_element', $this->data); unset($liste['element']);
        }
        if( !empty(RECHTE) ) { $liste['form_inputs'] = array( 'mitglied_id' => $this->data['mitglied']['id'] ); $this->data['liste'] = $liste; $this->load->view('templates/liste_fuss', $this->data); unset($liste); }    

        $liste = array( 'form' => site_url().'einstellungen/einstellungen_login_erlaubt' );
        if( !empty(LOGIN_ERLAUBT) ) {
          $this->load->view('templates/horizontale_linie', $this->data);
          $this->data['ueberschrift'] = MITGLIEDER_KATEGORIEN['login_erlaubt']['beschriftung']; $this->load->view('templates/ueberschrift', $this->data);
          $this->data['liste'] = $liste; $this->load->view('templates/liste_kopf', $this->data); unset($liste['kopf']); }
        foreach( LOGIN_ERLAUBT as $login_erlaubt => $eigenschaften ) {
          $liste['element']['beschriftung'] = '<div class="input-group flex-nowrap"><input class="form-check-input-lg" type="checkbox" value="'.$login_erlaubt.'" name="login_erlaubt[]" id="'.$login_erlaubt.'" onclick="this.form.submit();"';
          if( !is_null($this->data['mitglied']['login_erlaubt']) AND in_array( $login_erlaubt, $this->data['mitglied']['login_erlaubt'] ) ) $liste['element']['beschriftung'] .= ' checked';
          $liste['element']['beschriftung'] .= ' /><label class="form-check-label" for="'.$login_erlaubt.'">'.$eigenschaften['beschriftung'].'</label></div>';
          //if( array_key_exists( 'bemerkung', $eigenschaften ) ) $liste['element']['small'] = $eigenschaften['bemerkung'];
          $this->data['liste'] = $liste; $this->load->view('templates/liste_element', $this->data); unset($liste['element']);
        }
        if( !empty(LOGIN_ERLAUBT) ) { $liste['form_inputs'] = array( 'mitglied_id' => $this->data['mitglied']['id'] ); $this->data['liste'] = $liste; $this->load->view('templates/liste_fuss', $this->data); unset($liste); }

        if( in_array( 'strafkatalog', AKTIVE_CONTROLLER ) ) { $this->load->model('strafkatalog_model');
          $strafkatalog_eintraege = $this->strafkatalog_model->strafkatalog_eintraege( NULL, array( 'mitglied_id' => $this->data['mitglied']['id'] ) );
          $this->load->view('templates/horizontale_linie', $this->data);
          $this->data['ueberschrift'] = 'Einträge im Kassenbuch'; $this->load->view('templates/ueberschrift', $this->data);
          $liste = array(); if( !empty($strafkatalog_eintraege ) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_kopf', $this->data); unset($liste['kopf']); }
          foreach( $strafkatalog_eintraege as $eintrag ) {
            if( $eintrag['erledigt_zeitpunkt'] > 0 ) $farbe = 'body'; else $farbe = 'danger';
            $liste['element']['beschriftung'] = '<div class="small">'.date( 'd.m.Y', $eintrag['zeitpunkt'] );
            if( !empty($eintrag['erledigt_zeitpunkt']) AND intval($eintrag['erledigt_zeitpunkt']) > 0 ) $liste['element']['beschriftung'] .= ' - <span class="text-success">'.date( 'd.m.Y', $eintrag['erledigt_zeitpunkt'] ).'</span>';
            $liste['element']['beschriftung'] .= '</div>';
            $liste['element']['beschriftung'] .= '<span class="text-'.$farbe.'">'.$eintrag['strafe_grund'].'</span>';
            $liste['element']['float_right'] = '<span class="text-'.$farbe.'">'.html_waehrung( $eintrag['strafe_betrag'] ).'</span>';
            if( !empty($eintrag['strafe_bemerkung']) ) $liste['element']['small'] = $eintrag['strafe_bemerkung'];
      
            if( in_array( '-s', ICH['rechte'] ) ) {
              if( $eintrag['erledigt_zeitpunkt'] > 0 ) {
                $liste['element']['symbol'] = SYMBOLE['kein_haken']['bootstrap'];
                $liste['element']['symbol_farbe'] = 'danger';
                $this->data['eintrag_erledigen']['eintraege'][ $eintrag['id'] ] = array( 'beschriftung' => 'Strafe über '.html_waehrung( $eintrag['strafe_betrag'] ).' für '.$this->data['mitglied']['vorname'].' '.$this->data['mitglied']['nachname'].' reaktivieren?' );
              } else {
                $liste['element']['symbol'] = SYMBOLE['haken']['bootstrap']; 
                $liste['element']['symbol_farbe'] = 'success';
                $this->data['eintrag_erledigen']['eintraege'][ $eintrag['id'] ] = array( 'beschriftung' => 'Strafe über '.html_waehrung( $eintrag['strafe_betrag'] ).' wurde von '.$this->data['mitglied']['vorname'].' '.$this->data['mitglied']['nachname'].' bezahlt?' );
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
      
          $this->data['eintraege_betrag'] = array( 'beschriftung' => 'aller Einträge:', 'betrag' => $this->strafkatalog_model->strafkatalog_eintraege_betrag( $strafkatalog_eintraege ) );
          $this->load->view('strafkatalog/eintraege_betrag', $this->data);

          if( !empty($strafkatalog_eintraege) ) {
            $this->data['eintraege_betrag'] = array( 'beschriftung' => 'aller bezahlten Einträge:', 'farbe' => 'success', 'betrag' => $this->strafkatalog_model->strafkatalog_eintraege_betrag( $this->strafkatalog_model->strafkatalog_eintraege( NULL, array( 'mitglied_id' => $this->data['mitglied']['id'], 'erledigt_zeitpunkt>=' => 1 ) ) ) );
            $this->load->view('strafkatalog/eintraege_betrag', $this->data);
        
            $this->data['eintraege_betrag'] = array( 'beschriftung' => 'aller offenen Einträge:', 'farbe' => 'danger', 'betrag' => $this->strafkatalog_model->strafkatalog_eintraege_betrag( $this->strafkatalog_model->strafkatalog_eintraege( NULL, array( 'mitglied_id' => $this->data['mitglied']['id'], 'erledigt_zeitpunkt<=' => 0 ) ) ) );
            $this->load->view('strafkatalog/eintraege_betrag', $this->data);
          }
          
          if( in_array( '-s', ICH['rechte'] ) ) {
            $this->data['eintragen']['form'] = site_url().'strafkatalog/eintrag_eintragen';
            $this->data['eintragen']['titel'] =  array( 'aendern' => 'Eintrag ändern', );
            $this->data['eintragen']['submit'] = array( 'aendern' => 'Speichern', );
            $this->load->view('strafkatalog/eintrag_eintragen_modal', $this->data);
      
            $this->data['austragen']['form'] = site_url().'strafkatalog/eintrag_austragen';
            $this->data['austragen']['titel'] = 'Eintrag';
            //$this->data['austragen']['submit'] = array( 'austragen' => 'Eintrag löschen', );
            if( !empty($strafkatalog_eintraege) ) $this->load->view('templates/austragen_modal', $this->data);
      
            if( !empty($strafkatalog_eintraege) ) $this->load->view('strafkatalog/eintrag_erledigen_modal', $this->data);
          }
        }
      }
  

      if( in_array( '-m', ICH['rechte'] ) ) {
        $this->data['austragen']['mitglieder'][ intval($this->data['mitglied']['id']) ] = $this->data['mitglied'];
        $this->data['austragen']['id'] = 'mitglied_austragen'; $this->data['austragen']['elemente'][ intval($this->data['mitglied']['id']) ] = array( 'beschriftung' => $this->data['mitglied']['vorname'] .' '.$this->data['mitglied']['nachname'] );
        $this->data['austragen']['form'] = site_url().CONTROLLER.'/austragen';
        $this->data['austragen']['titel'] = 'Mitglied';
        //$this->data['austragen']['submit'] = array( 'austragen' => 'Mitglied löschen', );
        $this->load->view('templates/austragen_modal', $this->data);
        $this->data['werkzeugkasten'][] = array( 'ziel' => $this->data['austragen']['id'], 'symbol' => SYMBOLE['loeschen']['bootstrap'], 'farbe' => 'danger', 'data' => array( 'element_id' => intval($this->data['mitglied']['id']), ), );

        $this->data['eintragen']['form'] = site_url().CONTROLLER.'/eintragen';

        $this->data['eintragen']['titel']['duplizieren'] =  'Mitglied duplizieren';
        $this->data['eintragen']['submit']['duplizieren'] = 'Mitglied speichern';
        $this->data['werkzeugkasten'][] = array( 'ziel' => 'mitglied_eintragen', 'symbol' => SYMBOLE['duplizieren']['bootstrap'], 'data' => array( 'mitglied_id' => intval($this->data['mitglied']['id']), 'aktion' => 'duplizieren', ), );
        
        $this->data['eintragen']['mitglieder'][ intval($this->data['mitglied']['id']) ] = $this->data['mitglied'];
        $this->data['eintragen']['titel']['aendern'] =  'Mitglied ändern';
        $this->data['eintragen']['submit']['aendern'] = 'Speichern';
        $this->data['werkzeugkasten'][] = array( 'ziel' => 'mitglied_eintragen', 'symbol' => SYMBOLE['aendern']['bootstrap'], 'data' => array( 'mitglied_id' => intval($this->data['mitglied']['id']), 'aktion' => 'aendern', ), );
        
        $this->load->view('mitglieder/eintragen_modal', $this->data);
      }

      $this->data['werkzeugkasten'][] = array( 'typ' => 'modal', 'ziel' => 'einstellungen', 'symbol' => SYMBOLE['einstellungen']['bootstrap'] );
      $this->data['einstellungen'] = array( 'mitglieder' => array( 'sortieren_nach' => NULL, ), );
      foreach( $this->data['einstellungen'] as $gruppe => $funktionen ) foreach( $funktionen as $funktion => $wert )
        $this->data['einstellungen'][ $gruppe ][ $funktion ] = $this->einstellungen_model->standard_einstellung( $gruppe, $funktion, ICH['id'] );
      $this->load->view('einstellungen/einstellungen_modal', $this->data);

      $this->data['links'][] = array( 'ziel' => site_url().CONTROLLER, 'symbol' => SYMBOLE['ebene_hoch']['bootstrap'] );

      $this->load->view('templates/footer', $this->data);
    }
  }
  
  //------------------------------------------------------------------------------------------------------------------
  public function eintragen() {
    if ( !in_array( '-m', ICH['rechte'] ) ) $this->standard_404(); else {
      $this->form_validation->set_rules('vorname', MITGLIEDER_KATEGORIEN['vorname']['beschriftung'], 'required|callback_fv_standard_textzeile');
      $this->form_validation->set_rules('nachname', MITGLIEDER_KATEGORIEN['nachname']['beschriftung'], 'required|callback_fv_standard_textzeile');
      $this->form_validation->set_rules('geburt', MITGLIEDER_KATEGORIEN['geburt']['beschriftung'], 'required|callback_fv_datum');
      $this->form_validation->set_rules('geschlecht', MITGLIEDER_KATEGORIEN['geschlecht']['beschriftung'], 'required|in_list['.implode( ',', array_keys( VORGEGEBENE_WERTE['mitglieder']['geschlecht'] ) ).']');
      $this->form_validation->set_rules('email', MITGLIEDER_KATEGORIEN['email']['beschriftung'], 'valid_email');
      if( array_key_exists( 'adresse', MITGLIEDER_KATEGORIEN ) ) $this->form_validation->set_rules('adresse', MITGLIEDER_KATEGORIEN['adresse']['beschriftung'], 'required|callback_fv_standard_textzeile');
      if( array_key_exists( 'postleitzahl', MITGLIEDER_KATEGORIEN ) ) $this->form_validation->set_rules('postleitzahl', MITGLIEDER_KATEGORIEN['postleitzahl']['beschriftung'], 'required|numeric');
      if( array_key_exists( 'wohnort', MITGLIEDER_KATEGORIEN ) ) $this->form_validation->set_rules('wohnort', MITGLIEDER_KATEGORIEN['wohnort']['beschriftung'], 'required|callback_fv_standard_textzeile');
      if( array_key_exists( 'register', MITGLIEDER_KATEGORIEN ) ) $this->form_validation->set_rules('register', MITGLIEDER_KATEGORIEN['register']['beschriftung'], 'in_list['.implode( ',', array_keys( VORGEGEBENE_WERTE['mitglieder']['register'] ) ).']');
      if( array_key_exists( 'funktion', MITGLIEDER_KATEGORIEN ) ) $this->form_validation->set_rules('funktion', MITGLIEDER_KATEGORIEN['funktion']['beschriftung'], 'in_list['.implode( ',', array_keys( VORGEGEBENE_WERTE['mitglieder']['funktion'] ) ).']');
      if( array_key_exists( 'vorstandschaft', MITGLIEDER_KATEGORIEN ) ) $this->form_validation->set_rules('vorstandschaft', MITGLIEDER_KATEGORIEN['vorstandschaft']['beschriftung'], 'in_list['.implode( ',', array_keys( VORGEGEBENE_WERTE['mitglieder']['vorstandschaft'] ) ).']');
      if( array_key_exists( 'aktiv', MITGLIEDER_KATEGORIEN ) ) $this->form_validation->set_rules('aktiv', MITGLIEDER_KATEGORIEN['aktiv']['beschriftung'], 'in_list['.implode( ',', array_keys( VORGEGEBENE_WERTE['mitglieder']['aktiv'] ) ).']');
      $this->form_validation->set_rules('mitglied_id', 'Mitglied-ID', 'numeric');
      if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE ); else {

        $mitglied['zeitpunkt'] = time();
        $mitglied['vorname'] = $this->input->post('vorname');
        $mitglied['nachname'] = $this->input->post('nachname');
        $mitglied['geburt'] = strtotime( $this->input->post('geburt') );
        $mitglied['geschlecht'] = $this->input->post('geschlecht');
        if( array_key_exists( 'adresse', MITGLIEDER_KATEGORIEN ) ) $mitglied['adresse'] = $this->input->post('ort');
        if( array_key_exists( 'postleitzahl', MITGLIEDER_KATEGORIEN ) ) $mitglied['postleitzahl'] = intval($this->input->post('postleitzahl'));
        if( array_key_exists( 'wohnort', MITGLIEDER_KATEGORIEN ) ) $mitglied['wohnort'] = $this->input->post('wohnort');
        if( array_key_exists( 'register', MITGLIEDER_KATEGORIEN ) ) $mitglied['register'] = $this->input->post('register');
        if( array_key_exists( 'funktion', MITGLIEDER_KATEGORIEN ) ) $mitglied['funktion'] = $this->input->post('funktion');
        if( array_key_exists( 'vorstandschaft', MITGLIEDER_KATEGORIEN ) ) $mitglied['vorstandschaft'] = intval($this->input->post('vorstandschaft'));
        if( array_key_exists( 'aktiv', MITGLIEDER_KATEGORIEN ) ) $mitglied['aktiv'] = intval($this->input->post('aktiv'));
        
        if( !empty($this->input->post('mitglied_id')) ) {               // Mitglied wird geändert
          if( $this->input->post('email') != MITGLIEDER[ intval($this->input->post('mitglied_id')) ]['email'] ) $this->form_validation->set_rules('email', MITGLIEDER_KATEGORIEN['email']['beschriftung'], 'is_unique[mitglieder.email]');
          if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE ); else {
            $mitglied['email'] = $this->input->post('email');
            $mitglied['id'] = intval($this->input->post('mitglied_id'));
            if( $this->mitglieder_model->mitglied_db_aktualisieren( $mitglied ) ) status_feuern( 'success', 'Mitglied'.STATUSMELDUNGEN['speichern_erfolgreich']['meldung'], FALSE );
            else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
          }
        } else {                                                      // Mitglied wird neu erstellt
          $this->form_validation->set_rules('email', MITGLIEDER_KATEGORIEN['email']['beschriftung'], 'is_unique[mitglieder.email]');
          if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE ); else {
            $mitglied['email'] = $this->input->post('email');
            if( $this->mitglieder_model->mitglied_eintragen( $mitglied ) ) status_feuern( 'success', 'Mitglied'.STATUSMELDUNGEN['speichern_erfolgreich']['meldung'], FALSE );
            else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
          }
        }
      }

      redirect(ABSPRUNG);
    }
  }

  public function austragen() {
    if ( !in_array( '-m', ICH['rechte'] ) ) $this->standard_404(); else {
      $this->form_validation->set_rules( 'element_id', 'Mitglied-ID', 'required|numeric' );
      if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE ); else {
        $mitglied = $this->mitglieder_model->mitglieder( intval($this->input->post('element_id')) );
        $mitglied['archiv'] = 1;
        if( $this->mitglieder_model->mitglied_db_aktualisieren( $mitglied ) ) status_feuern( 'danger', 'Mitglied'.STATUSMELDUNGEN['loeschen_erfolgreich']['meldung'], FALSE );
        else status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE );
      }
      redirect(ABSPRUNG);
    }
  }

  //------------------------------------------------------------------------------------------------------------------
  public function einmal_links_erzeugen() {
    if( !in_array( '-m', ICH['rechte'] ) ) $this->standard_404(); else {
      $einmal_links = array();
      $this->form_validation->set_rules('element_id', 'Weg-ID', 'required|numeric'); if( $this->input->post('element_id') == 1 ) $email = TRUE; else $email = FALSE;
      $this->form_validation->set_rules('mitglieder[]', 'Mitglieder-ID', 'numeric');
      if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), !$email ); else {
        if( is_null( $this->input->post('mitglieder') ) ) $mitglieder = array(); else $mitglieder = $this->input->post('mitglieder');
        $durchgelaufen = TRUE; foreach( MITGLIEDER as $mitglied ) {
          if( in_array( $mitglied['id'], $mitglieder ) AND
              array_key_exists( 'login_erlaubt', $mitglied ) AND ( is_null($mitglied['login_erlaubt']) OR in_array( 'einmal_link', $mitglied['login_erlaubt'] ) ) ) { // Überprüfung ob Email & Passwort erlaubt ist oder die Entscheidung noch nicht gefällt wurde
            $schluessel = schluessel_generieren();
            $mitglied['login_schluessel'] = password_hash( $schluessel, PASSWORD_DEFAULT );
            $mitglied['login_schluessel_zeitpunkt'] = time();
            if( !$this->mitglieder_model->mitglied_db_aktualisieren( $mitglied ) ) $durchgelaufen = FALSE;
            else {
              if( $email ) {
                $this->data['mitglied'] = $mitglied;
                $this->data['email']['text'] = 'für deinen Zugang zur '.VEREINSAPP_NAME.' schickt dir '.ICH['vorname'].' '.ICH['nachname'].' einen Einmal-Link. Du kannst diesen Link sofort benutzen um dieses Gerät mit der '.VEREINSAPP_NAME.' zu verknuepfen:';
                $this->data['email']['hinweis'] = 'Diese Email mitsamt dem darin enthaltenen Link ist max. '.floor( LOGIN_EINMAL_LINK_EXPIRE/(60*60) ).' Stunden gültig und alle vorher erzeugten Einmal-Links sind jetzt ungültig. Falls du diesen Einmal-Link nicht benutzen möchtest, dann ignoriere diese E-Mail einfach!';
                $this->data['button']['beschriftung'] = 'Einmal-Link benutzen';
                $this->data['button']['link'] = site_url().'verknuepfen/'.$mitglied['id'].'/'.urlencode($schluessel);
                //$this->load->view('login/email', $this->data );
                if( !$this->mail_schicken( $mitglied['email'], 'Einmal-Link', $this->load->view('login/email', $this->data, TRUE) ) ) $durchgelaufen = FALSE;
                else $status = 'Einmal-Links erfolgreich verschickt.';
              } else {
                $einmal_links[ intval($mitglied['id']) ] = site_url().'verknuepfen/'.$mitglied['id'].'/'.urlencode($schluessel);
                $status = 'Einmal-Links erfolgreich erzeugt.';
              }
            }
          }
        }
        if( $durchgelaufen ) status_feuern( 'success', $status, !$email );
        else { status_feuern( 'danger', STATUSMELDUNGEN['speichern_fehlgeschlagen']['meldung'], FALSE ); redirect(ABSPRUNG); }
      }

      if( $email ) redirect(ABSPRUNG);
      else {
        $liste = array( 'beschriftung_h5' => TRUE, );
        if( !empty($einmal_links) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_kopf', $this->data); unset($liste['kopf']); }
        foreach( $einmal_links as $this->data['mitglied_id'] => $this->data['einmal_link'] ) $this->load->view('mitglieder/einmal_link_anzeigen', $this->data);
        if( !empty($einmal_links) ) { $this->data['liste'] = $liste; $this->load->view('templates/liste_fuss', $this->data); unset($liste); }

        $this->load->view('mitglieder/mitglieder_auswaehlen_modal', $this->data);

        $this->data['links'][] = array( 'ziel' => site_url().CONTROLLER, 'symbol' => SYMBOLE['ebene_hoch']['bootstrap'] );
        
        $this->load->view('templates/footer', $this->data);
      }
    }
  }

  //------------------------------------------------------------------------------------------------------------------
  public function zugang_entsperren() {
    $this->form_validation->set_rules( 'mitglied_id', 'Mitglied-ID', 'required' );
    if( !$this->form_validation->run() AND !empty(validation_errors()) ) status_feuern( 'danger', validation_errors(), FALSE );
    else {
      $mitglied = MITGLIEDER[ intval($this->input->post('mitglied_id')) ];
      $mitglied['loginversuche'] = 3;
      if( !$this->mitglieder_model->mitglied_db_aktualisieren( $mitglied ) ) status_feuern( 'danger', 'Zugang wurde nicht entsperrt!', FALSE );
      else {
        status_feuern( 'success', 'Zugang erfolgreich entsperrt.', FALSE );
        if( !$this->zugang_entsperren_bestaetigung_email( $mitglied ) ) status_feuern( 'danger', STATUSMELDUNGEN['email_fehlgeschlagen']['meldung'] );
        else status_feuern( 'success', 'Es wurde eine Email verschickt an '.$mitglied['email'].' mit einer Bestätigung.' );
      }
  }
    redirect(ABSPRUNG);
  }

  private function zugang_entsperren_bestaetigung_email( $mitglied ) {
    $this->data['mitglied'] = $mitglied;
    $this->data['email']['text'] = 'dein Zugang zur '.VEREINSAPP_NAME.' wurde erfolgreich von '.ICH['vorname'].' '.ICH['nachname'].' entsperrt. Du kannst deinen Zugang nun wieder wie gewohnt nutzen. Mit einem Klick auf den folgenden Link kehrst du direkt zum Login zurück:';
    $this->data['email']['hinweis'] = 'Diese Email dient lediglich zur Information.';
    $this->data['button']['beschriftung'] = 'Zurück zum Login';
    $this->data['button']['link'] = LOGIN;
    //$this->load->view('login/email', $this->data );
    return $this->mail_schicken( $mitglied['email'], 'Dein Zugang wurde erfolgreich entsperrt!', $this->load->view('login/email', $this->data, TRUE) );
  }

}