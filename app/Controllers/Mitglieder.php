<?php

namespace App\Controllers;
use App\Models\Mitglieder\Mitglied_Model;
use CodeIgniter\Shield\Entities\User as Mitglied;

use App\Models\Termine\Termin_Model;

use CodeIgniter\I18n\Time;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Models\UserIdentityModel;
use CodeIgniter\Shield\Controllers\MagicLinkController;

class Mitglieder extends BaseController {

    public function mitglieder() {

        $this->viewdata['liste']['alle_mitglieder'] = HAUPTINSTANZEN['mitglieder'];
        $this->viewdata['liste']['alle_mitglieder']['group-flush'] = TRUE;
        $this->viewdata['liste']['alle_mitglieder']['link'] = TRUE;
        $this->viewdata['liste']['alle_mitglieder']['vorschau'] = MITGLIEDER_EIGENSCHAFTEN_VORSCHAU;

        $disabled_filtern = array();
        if( !( array_key_exists( 'termine.anwesenheiten', VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'termine.anwesenheiten' ) ) ) foreach( model(Termin_Model::class)->findAll() as $termin ) $disabled_filtern[] = array( 'operator' => '==', 'eigenschaft' => 'id', 'wert' => $termin['id'] );
        $this->viewdata['liste']['anwesenheiten_dokumentieren'] = HAUPTINSTANZEN['termine'];
        unset($this->viewdata['liste']['anwesenheiten_dokumentieren']['filtern']);
        $this->viewdata['liste']['anwesenheiten_dokumentieren']['beschriftung'] = '<span class="eigenschaft" data-eigenschaft="start"></span> <span class="eigenschaft" data-eigenschaft="titel"></span>';
        $this->viewdata['liste']['anwesenheiten_dokumentieren']['checkliste'] = 'anwesenheiten';
        $this->viewdata['liste']['anwesenheiten_dokumentieren']['disabled'] = array( 'liste' => 'termine', 'filtern' => array( array( 'verknuepfung' => '||', 'filtern' => $disabled_filtern, ), ), );
        $this->viewdata['liste']['anwesenheiten_dokumentieren']['bedingte_formatierung'] = array( 'liste' => 'terminrueckmeldungen', 'klasse' => array(
            'text-success' => array( 'operator' => '==', 'eigenschaft' => 'status', 'wert' => '1' ),
            'text-danger' => array( 'operator' => '==', 'eigenschaft' => 'status', 'wert' => '2' ),
        ), );

        if( array_key_exists( 'termine.anwesenheiten', VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'termine.anwesenheiten' ) ) {
            $this->viewdata['liste']['anwesenheiten_dokumentieren']['werkzeugkasten']['alle_checks_abwaehlen'] = array(
                'klasse_id' => array('btn_alle_checks_abwaehlen', 'bestaetigung_einfordern'),
                'title' => 'Alle abwählen',
            );
            $this->viewdata['liste']['anwesenheiten_dokumentieren']['werkzeugkasten']['alle_checks_anwaehlen'] = array(
                'klasse_id' => array('btn_alle_checks_anwaehlen', 'bestaetigung_einfordern'),
                'title' => 'Alle anwählen',
            );
        }

        $this->viewdata['werkzeugkasten']['anwesenheiten_dokumentieren'] = array(
            'klasse_id' => 'btn_anwesenheiten_dokumentieren',
            'title' => 'Anwesenheiten dokumentieren',
        );
        
        if( array_key_exists( 'strafkatalog.verwaltung', VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'strafkatalog.verwaltung' ) ) {
            $this->viewdata['liste']['alle_mitglieder']['werkzeugkasten_handle'] = TRUE;
            $this->viewdata['werkzeugkasten']['strafe_zuweisen'] = array(
                'klasse_id' => array('btn_strafe_zuweisen', 'auswahl_einfordern'),
                'title' => 'Strafe einem Mitglied zuweisen',
            );
        }

        if( auth()->user()->can( 'mitglieder.verwaltung' ) ) {

            $this->viewdata['liste']['alle_mitglieder']['werkzeugkasten_handle'] = TRUE;

            $this->viewdata['werkzeugkasten']['einmal_link_anzeigen'] = array(
                'klasse_id' => array('btn_mitglied_einmal_link_anzeigen', 'formular_oeffnen'),
                'title' => 'Einmal-Link erstellen und anzeigen',
            );
            $this->viewdata['werkzeugkasten']['einmal_link_email'] = array(
                'klasse_id' => array('btn_mitglied_einmal_link_email', 'bestaetigung_einfordern'),
                'title' => 'Einmal-Link per Email zuschicken',
            );
        
            $this->viewdata['werkzeugkasten']['aendern'] = array(
                'klasse_id' => array('btn_mitglied_aendern', 'formular_oeffnen'),
                'title' => 'Mitglied ändern',
            );
            $this->viewdata['werkzeugkasten']['duplizieren'] = array(
                'klasse_id' => array('btn_mitglied_duplizieren', 'formular_oeffnen'),
                'title' => 'Mitglied duplizieren',
            );
            $this->viewdata['werkzeugkasten']['loeschen'] = array(
                'klasse_id' => array('btn_mitglied_loeschen', 'bestaetigung_einfordern'),
                'title' => 'Mitglied löschen',
                'farbe' => 'danger',
            );

            $this->viewdata['liste']['alle_mitglieder']['werkzeugkasten']['erstellen'] = array(
                'klasse_id' => array('btn_mitglied_erstellen', 'formular_oeffnen'),
                'title' => 'Mitglied erstellen',
            );

        }

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        echo view( 'Mitglieder/mitglieder', $this->viewdata );
    }

    //------------------------------------------------------------------------------------------------------------------
    public function details( $mitglied_id ) {
      if( empty( model(Mitglied_Model::class)->find( $mitglied_id ) ) ) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $this->viewdata['element_id'] = $mitglied_id;

        $disabled_filtern = array();
        if( !( array_key_exists( 'termine.anwesenheiten', VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'termine.anwesenheiten' ) ) ) foreach( model(Termin_Model::class)->findAll() as $termin ) $disabled_filtern[] = array( 'operator' => '==', 'eigenschaft' => 'id', 'wert' => $termin['id'] );
        $this->viewdata['liste']['anwesenheiten_dokumentieren'] = HAUPTINSTANZEN['termine'];
        unset($this->viewdata['liste']['anwesenheiten_dokumentieren']['filtern']);
        $this->viewdata['liste']['anwesenheiten_dokumentieren']['beschriftung'] = '<span class="eigenschaft" data-eigenschaft="start"></span> <span class="eigenschaft" data-eigenschaft="titel"></span>';
        $this->viewdata['liste']['anwesenheiten_dokumentieren']['checkliste'] = 'anwesenheiten';
        $this->viewdata['liste']['anwesenheiten_dokumentieren']['disabled'] = array( 'liste' => 'termine', 'filtern' => array( array( 'verknuepfung' => '||', 'filtern' => $disabled_filtern, ), ), );
        $this->viewdata['liste']['anwesenheiten_dokumentieren']['bedingte_formatierung'] = array( 'liste' => 'terminrueckmeldungen', 'klasse' => array(
            'text-success' => array( 'operator' => '==', 'eigenschaft' => 'status', 'wert' => '1' ),
            'text-danger' => array( 'operator' => '==', 'eigenschaft' => 'status', 'wert' => '2' ),
        ), );

        if( array_key_exists( 'termine.anwesenheiten', VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'termine.anwesenheiten' ) ) {
            $this->viewdata['liste']['anwesenheiten_dokumentieren']['werkzeugkasten']['alle_checks_abwaehlen'] = array(
                'klasse_id' => array('btn_alle_checks_abwaehlen', 'bestaetigung_einfordern'),
                'title' => 'Alle abwählen',
            );
            $this->viewdata['liste']['anwesenheiten_dokumentieren']['werkzeugkasten']['alle_checks_anwaehlen'] = array(
                'klasse_id' => array('btn_alle_checks_anwaehlen', 'bestaetigung_einfordern'),
                'title' => 'Alle anwählen',
            );
        }

        $this->viewdata['werkzeugkasten']['anwesenheiten_dokumentieren'] = array(
            'klasse_id' => 'btn_anwesenheiten_dokumentieren',
            'title' => 'Anwesenheiten dokumentieren',
        );

        if( auth()->user()->can( 'mitglieder.rechte' ) ) {
            $disabled_filtern = array();
            $disabled_filtern[] = array( 'operator' => '==', 'eigenschaft' => 'id', 'wert' => VERFUEGBARE_RECHTE['global.einstellungen']['id'] );
            if( !auth()->user()->can( 'global.einstellungen' ) ) $disabled_filtern[] = array( 'operator' => '==', 'eigenschaft' => 'id', 'wert' => VERFUEGBARE_RECHTE['mitglieder.rechte']['id'] );
            if( !auth()->user()->can( 'mitglieder.rechte' ) ) foreach( VERFUEGBARE_RECHTE as $verfuegbares_recht ) if( $verfuegbares_recht['permission'] != 'global.einstellungen' AND $verfuegbares_recht['permission'] != 'mitglieder.rechte' ) $disabled_filtern[] = array( 'operator' => '==', 'eigenschaft' => 'id', 'wert' => $verfuegbares_recht['id'] );
            $this->viewdata['liste']['rechte_vergeben'] = HAUPTINSTANZEN['verfuegbare_rechte'];
            $this->viewdata['liste']['rechte_vergeben']['checkliste'] = 'vergebene_rechte';
            $this->viewdata['liste']['rechte_vergeben']['gegen_liste'] = 'mitglieder';
            $this->viewdata['liste']['rechte_vergeben']['gegen_element_id'] = $mitglied_id;
            $this->viewdata['liste']['rechte_vergeben']['disabled'] = array( 'liste' => 'verfuegbare_rechte', 'filtern' => array( array( 'verknuepfung' => '||', 'filtern' => $disabled_filtern, ), ), );
        }

        if( array_key_exists( 'termine.verwaltung', VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'termine.verwaltung' ) ) {
            $this->viewdata['liste']['bevorstehende_termine_mitglied'] = HAUPTINSTANZEN['termine'];
            $this->viewdata['liste']['bevorstehende_termine_mitglied']['link'] = TRUE;
            $this->viewdata['liste']['bevorstehende_termine_mitglied']['beschriftung'] = '<i class="bi bi-'.SYMBOLE['termine']['bootstrap'].'"></i> '.HAUPTINSTANZEN['termine']['beschriftung'];
            $this->viewdata['liste']['bevorstehende_termine_mitglied']['vorschau'] = array( 'start', 'ort' );
            $this->viewdata['liste']['bevorstehende_termine_mitglied']['views'] = array( array( 'view' => 'Termine/terminrueckmeldung_basiseigenschaften', 'data' => array( 'mitglied_id' => $mitglied_id ) ) );
        }

        if( array_key_exists( 'strafkatalog.verwaltung', VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'strafkatalog.verwaltung' ) ) {

            $this->viewdata['liste']['kassenbuch_offene_eintraege_mitglied'] = HAUPTINSTANZEN['kassenbuch'];
            unset($this->viewdata['liste']['kassenbuch_offene_eintraege_mitglied']['werkzeugkasten']);
            $this->viewdata['liste']['kassenbuch_offene_eintraege_mitglied']['filtern'] = array( array( 'verknuepfung' => '&&', 'filtern' => array(
                array( 'operator' => '==', 'eigenschaft' => 'mitglied_id', 'wert' => $mitglied_id ),
                array( 'operator' => '==', 'eigenschaft' => 'erledigt_janein', 'wert' => false ),
            ), ), );
            $this->viewdata['liste']['kassenbuch_offene_eintraege_mitglied']['klasse_id'] = array('btn_kassenbucheintrag_offen_erledigt_markieren', 'bestaetigung_einfordern');
            $this->viewdata['liste']['kassenbuch_offene_eintraege_mitglied']['title'] = 'Kassenbucheintrag als offen/erledigt markieren';
            $this->viewdata['liste']['kassenbuch_offene_eintraege_mitglied']['beschriftung'] = '<i class="bi bi-'.SYMBOLE['kassenbuch']['bootstrap'].'"></i> <span class="eigenschaft" data-eigenschaft="titel"></span>';
            $this->viewdata['liste']['kassenbuch_offene_eintraege_mitglied']['vorschau'] = array( 'erstellung', 'wert' );
            $this->viewdata['liste']['kassenbuch_offene_eintraege_mitglied']['zusatzsymbole'] = array( 'offen_erledigt_markieren' );

            $this->viewdata['werkzeugkasten']['strafe_zuweisen'] = array(
                'klasse_id' => array('btn_strafe_zuweisen', 'auswahl_einfordern'),
                'title' => 'Strafe einem Mitglied zuweisen',
            );

        }

        $this->viewdata['liste']['zugeordnete_aufgaben'] = HAUPTINSTANZEN['aufgaben'];
        unset($this->viewdata['liste']['zugeordnete_aufgaben']['werkzeugkasten']);
        $this->viewdata['liste']['zugeordnete_aufgaben']['filtern'] = array( array( 'verknuepfung' => '&&', 'filtern' => array(
            array( 'eigenschaft' => 'zugeordnete_liste', 'operator' => '==', 'wert' => "mitglieder", ),
            array( 'eigenschaft' => 'zugeordnete_element_id', 'operator' => '==', 'wert' => $mitglied_id, ),
        ), ), );
        $this->viewdata['liste']['zugeordnete_aufgaben']['beschriftung'] = '<i class="bi bi-'.SYMBOLE['aufgaben']['bootstrap'].'"></i> '.HAUPTINSTANZEN['aufgaben']['beschriftung'];
        $this->viewdata['liste']['zugeordnete_aufgaben']['views'] = array( array( 'view' => 'Aufgaben/eingeplantes_mitglied' ), );

        if( array_key_exists( 'aufgaben.verwaltung', VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'aufgaben.verwaltung' ) ) {

            $this->viewdata['liste']['zugeordnete_aufgaben']['zusatzsymbole'] = array( 'aendern', 'duplizieren', 'loeschen', );

            $this->viewdata['liste']['aufgaben_offen_mitglied_geplant'] = HAUPTINSTANZEN['aufgaben'];
            unset($this->viewdata['liste']['aufgaben_offen_mitglied_geplant']['werkzeugkasten']);
                $this->viewdata['liste']['aufgaben_offen_mitglied_geplant']['filtern'] = array( array( 'verknuepfung' => '&&', 'filtern' => array(
                array( 'eigenschaft' => 'mitglied_id', 'operator' => '==', 'wert' => $mitglied_id, ),
                array( 'eigenschaft' => 'erledigt_janein', 'operator' => '==', 'wert' => false ),
            ), ), );
            $this->viewdata['liste']['aufgaben_offen_mitglied_geplant']['beschriftung'] = '<i class="bi bi-'.SYMBOLE['aufgaben']['bootstrap'].'"></i> '.HAUPTINSTANZEN['aufgaben']['beschriftung'];
            $this->viewdata['liste']['aufgaben_offen_mitglied_geplant']['vorschau'] = array( 'zugeordnetes_element' );
            $this->viewdata['liste']['aufgaben_offen_mitglied_geplant']['views'] = array( array( 'view' => 'Aufgaben/eingeplantes_mitglied' ), );

        }

        if( auth()->user()->can( 'mitglieder.verwaltung' ) ) {

            $this->viewdata['werkzeugkasten']['einmal_link_anzeigen'] = array(
                'klasse_id' => array('btn_mitglied_einmal_link_anzeigen', 'formular_oeffnen'),
                'title' => 'Einmal-Link erstellen und anzeigen',
            );
            $this->viewdata['werkzeugkasten']['einmal_link_email'] = array(
                'klasse_id' => array('btn_mitglied_einmal_link_email', 'bestaetigung_einfordern'),
                'title' => 'Einmal-Link per Email zuschicken',
            );
            $this->viewdata['werkzeugkasten']['aendern'] = array(
                'klasse_id' => array('btn_mitglied_aendern', 'formular_oeffnen'),
                'title' => 'Mitglied ändern',
            );
            $this->viewdata['werkzeugkasten']['duplizieren'] = array(
                'klasse_id' => array('btn_mitglied_duplizieren', 'formular_oeffnen'),
                'title' => 'Mitglied duplizieren',
            );
            $this->viewdata['werkzeugkasten']['loeschen'] = array(
                'klasse_id' => array('btn_mitglied_loeschen', 'bestaetigung_einfordern'),
                'title' => 'Mitglied löschen',
                'farbe' => 'danger',
                'weiterleiten' => 'mitglieder',
            );

        } elseif( ICH['id'] == $mitglied_id )
            $this->viewdata['werkzeugkasten']['aendern'] = array(
                'klasse_id' => array('btn_mitglied_aendern', 'formular_oeffnen'),
                'title' => 'Meine Daten ändern',
            );

        $this->viewdata['element_navigation'] = array(
            'instanz' => 'alle_mitglieder',
            'sortieren' => array(
                array( 'eigenschaft' => 'nachname', 'richtung' => SORT_ASC, ),
                array( 'eigenschaft' => 'vorname', 'richtung' => SORT_ASC, ),                
                array( 'eigenschaft' => 'register', 'richtung' => SORT_ASC, ),                
            ),
        );

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        echo view( 'Mitglieder/mitglied_details', $this->viewdata );
    }
    //------------------------------------------------------------------------------------------------------------------
    public function ajax_mitglied_speichern() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'id' => [ 'label' => 'ID', 'rules' => [ 'if_exist', 'is_natural_no_zero' ] ],
            'email' => [ 'label' => EIGENSCHAFTEN['mitglieder']['email']['beschriftung'], 'rules' => [ 'required', 'valid_email' ] ],
            'vorname' => [ 'label' => EIGENSCHAFTEN['mitglieder']['vorname']['beschriftung'], 'rules' => [ 'required' ] ],
            'nachname' => [ 'label' => EIGENSCHAFTEN['mitglieder']['nachname']['beschriftung'], 'rules' => [ 'required' ] ],
            'geburt' => [ 'label' => EIGENSCHAFTEN['mitglieder']['geburt']['beschriftung'], 'rules' => [ 'required', 'valid_date' ] ],
            'postleitzahl' => [ 'label' => EIGENSCHAFTEN['mitglieder']['postleitzahl']['beschriftung'], 'rules' => [ 'required', 'is_natural_no_zero', 'greater_than_equal_to[10000]', 'less_than_equal_to[99999]', ] ],
            'wohnort' => [ 'label' => EIGENSCHAFTEN['mitglieder']['wohnort']['beschriftung'], 'rules' => [ 'required' ] ],
            'geschlecht' => [ 'label' => EIGENSCHAFTEN['mitglieder']['geschlecht']['beschriftung'], 'rules' => [ 'required', 'in_list['.implode( ', ', array_keys( VORGEGEBENE_WERTE['mitglieder']['geschlecht'] ) ).']', ] ],
        );
        if( array_key_exists( 'register', EIGENSCHAFTEN['mitglieder'] ) ) $validation_rules['register'] = [ 'label' => EIGENSCHAFTEN['mitglieder']['register']['beschriftung'], 'rules' => [ 'required', 'in_list['.implode( ', ', array_keys( VORGEGEBENE_WERTE['mitglieder']['register'] ) ).']', ] ];
        if( array_key_exists( 'auto', EIGENSCHAFTEN['mitglieder'] ) ) $validation_rules['auto'] = [ 'label' => EIGENSCHAFTEN['mitglieder']['auto']['beschriftung'], 'rules' => [ 'required', 'in_list['.implode( ', ', array_keys( VORGEGEBENE_WERTE['mitglieder']['auto'] ) ).']', ] ];
        if( array_key_exists( 'funktion', EIGENSCHAFTEN['mitglieder'] ) ) $validation_rules['funktion'] = [ 'label' => EIGENSCHAFTEN['mitglieder']['funktion']['beschriftung'], 'rules' => [ 'required', 'in_list['.implode( ', ', array_keys( VORGEGEBENE_WERTE['mitglieder']['funktion'] ) ).']', ] ];
        if( array_key_exists( 'vorstandschaft', EIGENSCHAFTEN['mitglieder'] ) ) $validation_rules['vorstandschaft'] = [ 'label' => EIGENSCHAFTEN['mitglieder']['vorstandschaft']['beschriftung'], 'rules' => [ 'required', 'in_list['.implode( ', ', array_keys( VORGEGEBENE_WERTE['mitglieder']['vorstandschaft'] ) ).']', ] ];
        if( array_key_exists( 'aktiv', EIGENSCHAFTEN['mitglieder'] ) ) $validation_rules['aktiv'] = [ 'label' => EIGENSCHAFTEN['mitglieder']['aktiv']['beschriftung'], 'rules' => [ 'required', 'in_list['.implode( ', ', array_keys( VORGEGEBENE_WERTE['mitglieder']['aktiv'] ) ).']', ] ];

        if( array_key_exists( 'id', $this->request->getPost() ) AND !empty( $this->request->getPost()['id'] ) ) $validation_rules['email']['rules'][] = 'is_unique[mitglieder_zugaenge.secret,user_id,{id}]';
        else $validation_rules['email']['rules'][] = 'is_unique[mitglieder_zugaenge.secret]';

        if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->user()->can( 'mitglieder.verwaltung' ) AND !(!empty( $this->request->getPost()['id'] ) AND ICH['id'] == $this->request->getPost()['id'] ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else {
            $mitglieder_Model = model(Mitglied_Model::class);
            $mitglied = array(
                'username' => NULL,
                'email' => $this->request->getPost()['email'],
                'vorname' => $this->request->getpost()['vorname'],
                'nachname' => $this->request->getpost()['nachname'],
                'geburt' => $this->request->getPost()['geburt'],
                'postleitzahl' => $this->request->getpost()['postleitzahl'],
                'wohnort' => $this->request->getpost()['wohnort'],
                'geschlecht' => $this->request->getpost()['geschlecht'],
            );
            if( array_key_exists( 'register', EIGENSCHAFTEN['mitglieder'] ) ) $mitglied['register'] = $this->request->getpost()['register'];
            if( array_key_exists( 'auto', EIGENSCHAFTEN['mitglieder'] ) ) $mitglied['auto'] = $this->request->getpost()['auto'];
            if( array_key_exists( 'funktion', EIGENSCHAFTEN['mitglieder'] ) ) $mitglied['funktion'] = $this->request->getpost()['funktion'];
            if( array_key_exists( 'vorstandschaft', EIGENSCHAFTEN['mitglieder'] ) ) $mitglied['vorstandschaft'] = $this->request->getpost()['vorstandschaft'];
            if( array_key_exists( 'aktiv', EIGENSCHAFTEN['mitglieder'] ) ) $mitglied['aktiv'] = $this->request->getpost()['aktiv'];
    
            if( !empty( $this->request->getPost()['id'] ) ) {
                $mitglied = $mitglieder_Model->findById( $this->request->getPost()['id'] )->fill($mitglied);
                $mitglieder_Model->save( $mitglied );
            } else {
                helper('text'); $mitglied['password'] = random_string('crypto', 20);
                $mitglieder_Model->save( new Mitglied( $mitglied ) );
                $ajax_antwort['mitglied_id'] = (int)$mitglieder_Model->getInsertID();
                $mitglieder_Model->addToDefaultGroup( $mitglieder_Model->findById( $ajax_antwort['mitglied_id'] ) );
            }
        }

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_mitglied_passwort_aendern() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'id' => [ 'label' => 'ID', 'rules' => [ 'required', 'is_natural_no_zero' ] ],
            'passwort_alt' => [ 'label' => 'Altes Passwort', 'rules' => [ 'required' ] ],
            'passwort_neu' => [ 'label' => 'Neues Passwort', 'rules' => [ 'required', 'strong_password' ] ],
            'passwort_neu2' => [ 'label' => 'Neues Passwort (Wiederholung)', 'rules' => [ 'required', 'matches[passwort_neu]' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->user()->can( 'global.einstellungen' ) AND $this->request->getPost()['id'] != ICH['id'] ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else if( !auth()->check( array( 'email' => model(Mitglied_Model::class)->findById( $this->request->getPost()['id'] )->email, 'password' => $this->request->getpost()['passwort_alt'] ) )->isOK() ) $ajax_antwort['validation'] = array( 'passwort_alt' => 'Das alte Passwort ist nicht korrekt.' );
        else {
            $mitglieder_Model = model(Mitglied_Model::class);
            $mitglied = array(
                'password' => $this->request->getpost()['passwort_neu'],
            );
            $mitglied = $mitglieder_Model->findById( $this->request->getPost()['id'] )->fill($mitglied);
            $mitglieder_Model->save( $mitglied );
            
            $mitglied->undoForcePasswordReset();
        }

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_mitglied_passwort_festlegen() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'id' => [ 'label' => 'ID', 'rules' => [ 'required', 'is_natural_no_zero' ] ],
            'passwort_neu' => [ 'label' => 'Neues Passwort', 'rules' => [ 'required', 'strong_password' ] ],
            'passwort_neu2' => [ 'label' => 'Neues Passwort (Wiederholung)', 'rules' => [ 'required', 'matches[passwort_neu]' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->user()->can( 'global.einstellungen' ) AND $this->request->getPost()['id'] != ICH['id'] ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else {
            $mitglieder_Model = model(Mitglied_Model::class);
            $mitglied = array(
                'password' => $this->request->getpost()['passwort_neu'],
            );
            $mitglied = $mitglieder_Model->findById( $this->request->getPost()['id'] )->fill($mitglied);
            $mitglieder_Model->save( $mitglied );

            $mitglied->undoForcePasswordReset();
        }

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function mitglied_einmal_link_email() {
        $rules = [ 'email' => config('Auth')->emailValidationRules, ];

        $providerClass = setting('Auth.userProvider');

        $provider = new $providerClass();

        if (! setting('Auth.allowMagicLinkLogins')) {
            return redirect()->route('login')->with('error', lang('Auth.magicLinkDisabled'));
        }

        // Validate email format
        // $rules = $MagicLinkController->getValidationRules();
        if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            return redirect()->route('magic-link')->with('errors', $this->validator->getErrors());
        }

        // Check if the user exists
        $email = $this->request->getPost('email');
        $user  = $provider->findByCredentials(['email' => $email]);

        if ($user === null) {
            return redirect()->route('magic-link')->with('error', lang('Auth.invalidEmail'));
        }

        $mitglied = $user;
        $token = $this->einmal_link_token_generieren( $mitglied );
        if( !$this->einmal_link_email_verschicken( $mitglied, $token ) ) {
            return redirect()->route('magic-link')->with('error', lang('Auth.unableSendEmailToUser', [$user->email]));
        }

        return view(setting('Auth.views')['magic-link-message']);
    }

    private function einmal_link_token_generieren( $mitglied ) { $user = $mitglied;
        /** @var UserIdentityModel $identityModel */
        $identityModel = model(UserIdentityModel::class);

        // Delete any previous magic-link identities
        $identityModel->deleteIdentitiesByType($user, Session::ID_TYPE_MAGIC_LINK);

        // Generate the code and save it as an identity
        helper('text');
        $token = random_string('crypto', 20);

        $identityModel->insert([
            'user_id' => $user->id,
            'type'    => Session::ID_TYPE_MAGIC_LINK,
            'secret'  => $token,
            'expires' => Time::now('Europe/Berlin')->addSeconds(setting('Auth.magicLinkLifetime'))->format('Y-m-d H:i:s'),
        ]);

        $user->forcePasswordReset();

        return $token;
    }

    private function einmal_link_email_verschicken( $mitglied, $token ) { $user = $mitglied;
        $send_status = TRUE;

        /** @var IncomingRequest $request */
        $request = service('request');

        $ipAddress = $request->getIPAddress();
        $userAgent = (string) $request->getUserAgent();
        $date      = Time::now('Europe/Berlin')->toDateTimeString();

        // Send the user an email with the code
        helper('email');
        $email = emailer()->setFrom(setting('Email.fromEmail'), VEREIN_NAME ?? '');
        $email->setTo($user->email);
        $email->setSubject(VEREINSAPP_NAME.' - Einmal-Link');
        $email->setMessage(view(setting('Auth.views')['magic-link-email'], ['mitglied_name' => $mitglied->vorname, 'token' => $token, 'ipAddress' => $ipAddress, 'userAgent' => $userAgent, 'date' => $date]));

        if ($email->send(false) === false) {
            log_message('error', $email->printDebugger(['headers']));
            $send_status = FALSE;
        }

        // Clear the email
        $email->clear();

        return $send_status;
    }

    public function ajax_mitglied_einmal_link_erstellen() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'id' => [ 'label' => 'ID', 'rules' => [ 'required', 'is_natural_no_zero' ] ],
            'email' => [ 'label' => 'Per Email verschicken', 'rules' => [ 'if_exist', 'in_list[ true, false ]' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->user()->can( 'mitglieder.verwaltung' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else if( !setting('Auth.allowMagicLinkLogins') ) $ajax_antwort['validation'] = 'Einmal-Links sind nicht aktiviert!';
        // else if( empty( $this->request->getPost()['id'] ) ) $ajax_antwort['validation'] = 'Mitglied nicht gefunden!';
        else {
            $mitglieder_Model = model(Mitglied_Model::class);
            $mitglied = $mitglieder_Model->findById( $this->request->getPost()['id'] );
            if ( $mitglied === NULL ) $ajax_antwort['validation'] = 'Mitglied nicht gefunden!';
            else {
                $token = $this->einmal_link_token_generieren( $mitglied );
                $ajax_antwort['einmal_link'] = url_to('verify-magic-link').'?token='.$token;
                if( array_key_exists( 'email', $this->request->getPost() ) AND !empty( $this->request->getPost()['email'] ) && filter_var( $this->request->getpost()['email'], FILTER_VALIDATE_BOOLEAN) )
                    if( !$this->einmal_link_email_verschicken( $mitglied, $token ) ) $ajax_antwort['validation'] = 'Email konnte nicht versandt werden!';
            }

        }

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_mitglied_loeschen() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'id' => [ 'label' => 'ID', 'rules' => [ 'required', 'is_natural_no_zero' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->user()->can( 'mitglieder.verwaltung' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else if( $this->request->getPost()['id'] == ICH['id'] ) $ajax_antwort['validation'] = 'Du kannst dich nicht selbst löschen!';
        else model(Mitglied_Model::class)->delete( $this->request->getPost()['id'], TRUE );

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    //------------------------------------------------------------------------------------------------------------------
    public function ajax_vergebenes_recht_speichern() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'mitglied_id' => [ 'label' => EIGENSCHAFTEN['vergebene_rechte']['mitglied_id']['beschriftung'], 'rules' => [ 'required', 'is_natural_no_zero' ] ],
            'verfuegbares_recht_id' => [ 'label' => EIGENSCHAFTEN['vergebene_rechte']['verfuegbares_recht_id']['beschriftung'], 'rules' => [ 'required', 'is_natural_no_zero' ] ],
            'status' => [ 'label' => EIGENSCHAFTEN['anwesenheiten']['status']['beschriftung'], 'rules' => [ 'required', 'is_natural' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->user()->can( 'mitglieder.rechte' ) AND
                 !( auth()->user()->can( 'global.einstellungen' ) AND VERFUEGBARE_RECHTE['mitglieder.rechte']['id'] == $this->request->getPost()['verfuegbares_recht_id'] )
            ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else {
            $permission = NULL; foreach( VERFUEGBARE_RECHTE as $verfuegbares_recht ) if( $verfuegbares_recht['id'] == $this->request->getPost()['verfuegbares_recht_id'] ) $permission = $verfuegbares_recht['permission'];
            model(Mitglied_Model::class)->findById( $this->request->getPost()['mitglied_id'] )->removePermission( $permission );
            if( filter_var( $this->request->getpost()['status'], FILTER_VALIDATE_BOOLEAN) ) model(Mitglied_Model::class)->findById( $this->request->getPost()['mitglied_id'] )->addPermission( $permission );
        }
        
        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

}
