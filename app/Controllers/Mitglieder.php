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

        $this->viewdata['liste']['alle_mitglieder'] = array(
            'liste' => 'mitglieder',
            // 'filtern' => array( array( 'operator' => '==', 'eigenschaft' => 'aktiv', 'wert' => '1' ), ),
            'sortieren' => array(
                array( 'eigenschaft' => 'nachname', 'richtung' => SORT_ASC, ),
                array( 'eigenschaft' => 'vorname', 'richtung' => SORT_ASC, ),                
                array( 'eigenschaft' => 'register', 'richtung' => SORT_ASC, ),                
            ),
            'beschriftung' => array(
                'beschriftung' => '<span class="eigenschaft" data-eigenschaft="vorname"></span> <span class="eigenschaft" data-eigenschaft="nachname"></span>',
                'h5' => TRUE,
            ),
            // 'sortable' => TRUE,
            'link' => TRUE,
            // 'klasse_id' => array('btn_', 'bestaetigung_einfordern'),
            // 'title' => 'Titel für bspw. ein Modal',
            'vorschau' => '',
            // 'views' => view( 'Termine/rueckmeldung_basiseigenschaften', array( 'mitglied_id' => ICH['id'] ) ),
            'zusatzsymbole' => '<span class="zusatzsymbol" data-zusatzsymbol="geburtstag"></span><span class="zusatzsymbol" data-zusatzsymbol="abwesend"></span>',
            // 'checkliste' => 'vergebene_rechte',
            // 'gegen_liste' => 'termine',
            // 'gegen_element_id' => 42,
            // 'disabled' => array(
            //     'liste' => 'termine',
            //     'filtern' => array( array(
            //         'verknuepfung' => '||',
            //         'filtern' => $disabled_filtern,
            //     ), ),
            // ),
            // 'bedingte_formatierung' => array(
            //     'liste' => 'rueckmeldungen',
            //     'klasse' => array(
            //         'text-success' => array( 'operator' => '==', 'eigenschaft' => 'status', 'wert' => '1' ),
            //         'text-danger' => array( 'operator' => '==', 'eigenschaft' => 'status', 'wert' => '2' ),
            //     ),
            // ),
            'listenstatistik' => array(),
        );
        foreach( MITGLIEDER_EIGENSCHAFTEN_VORSCHAU as $vorschau ) $this->viewdata['liste']['alle_mitglieder']['vorschau'] .= '<span class="eigenschaft" data-eigenschaft="'.$vorschau.'"></span><i class="bi bi-'.SYMBOLE['spacer']['bootstrap'].' spacer"></i>';

        $disabled_filtern = array();
        if( !( array_key_exists( 'termine.anwesenheiten', VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'termine.anwesenheiten' ) ) ) foreach( model(Termin_Model::class)->findAll() as $termin ) $disabled_filtern[] = array( 'operator' => '==', 'eigenschaft' => 'id', 'wert' => $termin['id'] );
        $this->viewdata['liste']['anwesenheiten_dokumentieren'] = array(
            'liste' => 'termine',
            'sortieren' => array(
                array( 'eigenschaft' => 'start', 'richtung' => SORT_ASC, ),             
            ),
            'beschriftung' => array(
                'beschriftung' => '<span class="eigenschaft" data-eigenschaft="start"></span> <span class="eigenschaft" data-eigenschaft="titel"></span>',
            ),
            'zusatzsymbole' => '<span class="zusatzsymbol" data-zusatzsymbol="kategorie"></span>',
            'checkliste' => 'anwesenheiten',
            'disabled' => array(
                'liste' => 'termine',
                'filtern' => array( array(
                    'verknuepfung' => '||',
                    'filtern' => $disabled_filtern,
                ), ),
            ),
            'bedingte_formatierung' => array(
                'liste' => 'rueckmeldungen',
                'klasse' => array(
                    'text-success' => array( 'operator' => '==', 'eigenschaft' => 'status', 'wert' => '1' ),
                    'text-danger' => array( 'operator' => '==', 'eigenschaft' => 'status', 'wert' => '2' ),
                ),
            ),
            'listenstatistik' => array(),
        );

        if( array_key_exists( 'termine.anwesenheiten', VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'termine.anwesenheiten' ) )
            $this->viewdata['liste']['anwesenheiten_dokumentieren']['werkzeugkasten']['alle_checks_abwaehlen'] = array(
                'klasse_id' => 'btn_alle_checks_abwaehlen',
                'title' => 'Alle abwählen',
            );

        if( array_key_exists( 'termine.anwesenheiten', VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'termine.anwesenheiten' ) )
            $this->viewdata['liste']['anwesenheiten_dokumentieren']['werkzeugkasten']['alle_checks_anwaehlen'] = array(
                'klasse_id' => 'btn_alle_checks_anwaehlen',
                'title' => 'Alle anwählen',
            );

        $this->viewdata['liste']['anwesenheiten_dokumentieren']['werkzeugkasten']['filtern'] = array(
            'klasse_id' => 'btn_filtern_modal_oeffnen',
            'title' => 'Mitglieder filtern',
        );

        $this->viewdata['liste']['anwesenheiten_dokumentieren']['werkzeugkasten']['sortieren'] = array(
            'klasse_id' => 'btn_sortieren_modal_oeffnen',
            'title' => 'Mitglieder sortieren',
        );

        $this->viewdata['werkzeugkasten']['anwesenheiten_dokumentieren'] = array(
            'klasse_id' => 'btn_anwesenheiten_dokumentieren',
            'title' => 'Anwesenheiten dokumentieren',
        );
        
        if( array_key_exists( 'strafkatalog.verwaltung', VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'strafkatalog.verwaltung' ) ) {
            $this->viewdata['liste']['alle_mitglieder']['werkzeugkasten_handle'] = TRUE;

            $this->viewdata['werkzeugkasten']['strafe_zuweisen'] = array(
                'klasse_id' => array('btn_strafe_zuweisen', 'auswahl_oeffnen'),
                'title' => 'Strafe einem Mitglied zuweisen',
            );

            $this->viewdata['liste']['strafkatalog_auswahl'] = array(
                'liste' => 'strafkatalog',
                'sortieren' => array(
                    array( 'eigenschaft' => 'kategorie', 'richtung' => SORT_ASC, ),
                    array( 'eigenschaft' => 'titel', 'richtung' => SORT_ASC, ),
                    array( 'eigenschaft' => 'wert', 'richtung' => SORT_ASC, ),
                    ),
                'beschriftung' => array(
                    'beschriftung' => '<span class="eigenschaft" data-eigenschaft="titel"></span>',
                ),
                'klasse_id' => array('btn_strafe_zuweisen', 'bestaetigung_einfordern'),
                'title' => 'Strafe zuweisen',
                'listenstatistik' => array(),
            );

            $this->viewdata['liste']['strafkatalog_auswahl']['werkzeugkasten']['filtern'] = array(
                'klasse_id' => 'btn_filtern_modal_oeffnen',
                'title' => 'Strafkatalog filtern',
            );

            $this->viewdata['liste']['strafkatalog_auswahl']['werkzeugkasten']['sortieren'] = array(
                'klasse_id' => 'btn_sortieren_modal_oeffnen',
                'title' => 'Strafkatalog sortieren',
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

        $this->viewdata['liste']['alle_mitglieder']['werkzeugkasten']['filtern'] = array(
            'klasse_id' => 'btn_filtern_modal_oeffnen',
            'title' => 'Mitglieder filtern',
        );

        $this->viewdata['liste']['alle_mitglieder']['werkzeugkasten']['sortieren'] = array(
            'klasse_id' => 'btn_sortieren_modal_oeffnen',
            'title' => 'Mitglieder sortieren',
        );

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        echo view( 'Mitglieder/mitglieder', $this->viewdata );
    }

    //------------------------------------------------------------------------------------------------------------------
    public function details( $mitglied_id ) {
      if( empty( model(Mitglied_Model::class)->find( $mitglied_id ) ) ) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $this->viewdata['element_id'] = $mitglied_id;

        $disabled_filtern = array();
        if( !( array_key_exists( 'termine.anwesenheiten', VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'termine.anwesenheiten' ) ) ) foreach( model(Termin_Model::class)->findAll() as $termin ) $disabled_filtern[] = array( 'operator' => '==', 'eigenschaft' => 'id', 'wert' => $termin['id'] );
        $this->viewdata['liste']['anwesenheiten_dokumentieren'] = array(
            'liste' => 'termine',
            'sortieren' => array(
                array( 'eigenschaft' => 'start', 'richtung' => SORT_ASC, ),             
            ),
            'beschriftung' => array(
                'beschriftung' => '<span class="eigenschaft" data-eigenschaft="start"></span> <span class="eigenschaft" data-eigenschaft="titel"></span>',
            ),
            'zusatzsymbole' => '<span class="zusatzsymbol" data-zusatzsymbol="kategorie"></span>',
            'checkliste' => 'anwesenheiten',
            'disabled' => array(
                'liste' => 'termine',
                'filtern' => array( array(
                    'verknuepfung' => '||',
                    'filtern' => $disabled_filtern,
                ), ),
            ),
            'bedingte_formatierung' => array(
                'liste' => 'rueckmeldungen',
                'klasse' => array(
                    'text-success' => array( 'operator' => '==', 'eigenschaft' => 'status', 'wert' => '1' ),
                    'text-danger' => array( 'operator' => '==', 'eigenschaft' => 'status', 'wert' => '2' ),
                ),
            ),
            'listenstatistik' => array(),
        );

        if( array_key_exists( 'termine.anwesenheiten', VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'termine.anwesenheiten' ) )
            $this->viewdata['liste']['anwesenheiten_dokumentieren']['werkzeugkasten']['alle_checks_abwaehlen'] = array(
                'klasse_id' => 'btn_alle_checks_abwaehlen',
                'title' => 'Alle abwählen',
            );

        if( array_key_exists( 'termine.anwesenheiten', VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'termine.anwesenheiten' ) )
            $this->viewdata['liste']['anwesenheiten_dokumentieren']['werkzeugkasten']['alle_checks_anwaehlen'] = array(
                'klasse_id' => 'btn_alle_checks_anwaehlen',
                'title' => 'Alle anwählen',
            );

        $this->viewdata['liste']['anwesenheiten_dokumentieren']['werkzeugkasten']['filtern'] = array(
            'klasse_id' => 'btn_filtern_modal_oeffnen',
            'title' => 'Mitglieder filtern',
        );

        $this->viewdata['liste']['anwesenheiten_dokumentieren']['werkzeugkasten']['sortieren'] = array(
            'klasse_id' => 'btn_sortieren_modal_oeffnen',
            'title' => 'Mitglieder sortieren',
        );

        $this->viewdata['werkzeugkasten']['anwesenheiten_dokumentieren'] = array(
            'klasse_id' => 'btn_anwesenheiten_dokumentieren',
            'title' => 'Anwesenheiten dokumentieren',
        );
        
        if( array_key_exists( 'strafkatalog.verwaltung', VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'strafkatalog.verwaltung' ) ) {
            $this->viewdata['liste']['kassenbuch_offene_eintraege_mitglied'] = array(
                'liste' => 'kassenbuch',
                'filtern' => array( array(
                    'verknuepfung' => '&&',
                    'filtern' => array(
                        array( 'operator' => '==', 'eigenschaft' => 'mitglied_id', 'wert' => $mitglied_id ),
                        array( 'operator' => '==', 'eigenschaft' => 'aktiv', 'wert' => 0 ),
                    ),
                ), ),
                'sortieren' => array(
                    array( 'eigenschaft' => 'erstellung', 'richtung' => SORT_ASC, ),
                    array( 'eigenschaft' => 'titel', 'richtung' => SORT_ASC, ),
                    array( 'eigenschaft' => 'wert', 'richtung' => SORT_ASC, ),
                ),
                'beschriftung' => array(
                    'beschriftung' => '<span class="eigenschaft" data-eigenschaft="titel"></span>',
                ),
                'klasse_id' => array('btn_kassenbucheintrag_de_aktivieren', 'bestaetigung_einfordern'),
                'title' => 'Kassenbucheintrag (de)aktivieren',
                'vorschau' => '<div class="small"><span class="eigenschaft" data-eigenschaft="erstellung"></span><i class="bi bi-'.SYMBOLE['spacer']['bootstrap'].' spacer"></i><span class="eigenschaft" data-eigenschaft="wert"></span></div>',
                'zusatzsymbole' => '<span class="zusatzsymbol" data-zusatzsymbol="de_aktivieren"></span>',
                'listenstatistik' => array(
                    'summe' => 'wert',
                ),
            );

            $this->viewdata['werkzeugkasten']['strafe_zuweisen'] = array(
                'klasse_id' => array('btn_strafe_zuweisen', 'auswahl_oeffnen'),
                'title' => 'Strafe einem Mitglied zuweisen',
            );

            $this->viewdata['liste']['strafkatalog_auswahl'] = array(
                'liste' => 'strafkatalog',
                'sortieren' => array(
                    array( 'eigenschaft' => 'kategorie', 'richtung' => SORT_ASC, ),
                    array( 'eigenschaft' => 'titel', 'richtung' => SORT_ASC, ),
                    array( 'eigenschaft' => 'wert', 'richtung' => SORT_ASC, ),
                    ),
                'beschriftung' => array(
                    'beschriftung' => '<span class="eigenschaft" data-eigenschaft="titel"></span>',
                ),
                'klasse_id' => array('btn_strafe_zuweisen', 'bestaetigung_einfordern'),
                'title' => 'Strafe zuweisen',
                'listenstatistik' => array(),
            );

            $this->viewdata['liste']['strafkatalog_auswahl']['werkzeugkasten']['filtern'] = array(
                'klasse_id' => 'btn_filtern_modal_oeffnen',
                'title' => 'Strafkatalog filtern',
            );

            $this->viewdata['liste']['strafkatalog_auswahl']['werkzeugkasten']['sortieren'] = array(
                'klasse_id' => 'btn_sortieren_modal_oeffnen',
                'title' => 'Strafkatalog sortieren',
            );
        }

        if( auth()->user()->can( 'mitglieder.verwaltung' ) ) {
            if( auth()->user()->can( 'mitglieder.rechte' ) ) {
                $disabled_filtern = array();
                $disabled_filtern[] = array( 'operator' => '==', 'eigenschaft' => 'id', 'wert' => VERFUEGBARE_RECHTE['global.einstellungen']['id'] );
                if( !auth()->user()->can( 'global.einstellungen' ) ) $disabled_filtern[] = array( 'operator' => '==', 'eigenschaft' => 'id', 'wert' => VERFUEGBARE_RECHTE['mitglieder.rechte']['id'] );
                if( !auth()->user()->can( 'mitglieder.rechte' ) ) foreach( VERFUEGBARE_RECHTE as $verfuegbares_recht ) if( $verfuegbares_recht['permission'] != 'global.einstellungen' AND $verfuegbares_recht['permission'] != 'mitglieder.rechte' ) $disabled_filtern[] = array( 'operator' => '==', 'eigenschaft' => 'id', 'wert' => $verfuegbares_recht['id'] );
                $this->viewdata['liste']['rechte_vergeben'] = array(
                    'liste' => 'verfuegbare_rechte',
                    'beschriftung' => array(
                        'beschriftung' => '<span class="eigenschaft" data-eigenschaft="beschriftung">',
                    ),
                    'checkliste' => 'vergebene_rechte',
                    'gegen_liste' => 'mitglieder',
                    'gegen_element_id' => $mitglied_id,
                    'disabled' => array(
                        'liste' => 'verfuegbare_rechte',
                        'filtern' => array( array(
                            'verknuepfung' => '||',
                            'filtern' => $disabled_filtern,
                        ), ),
                    ),
                        );
            }

            $this->viewdata['liste']['bevorstehende_termine_mitglied'] = array(
                'liste' => 'termine',
                'filtern' => array( array(
                    'verknuepfung' => '&&',
                    'filtern' => array(
                        array( 'operator' => '>=', 'eigenschaft' => 'start', 'wert' => Time::today( 'Europe/Berlin' )->toDateTimeString() ),
                    ),
                ), ),
                'sortieren' => array(
                    array( 'eigenschaft'=> 'start', 'richtung'=> SORT_ASC, ),
                ),
                'beschriftung' => array(
                    'beschriftung' => '<span class="eigenschaft" data-eigenschaft="titel"></span>',
                ),
                'link' => TRUE,
                'vorschau' =>   '<div class="row g-0 my-1 small">'.
                                    '<div class="col nowrap"><i class="bi bi-'.SYMBOLE['datum']['bootstrap'].'"></i> <span class="eigenschaft" data-eigenschaft="start"></span></div>'.
                                '</div>',
                'views' => view( 'Termine/rueckmeldung_basiseigenschaften', array( 'mitglied_id' => $mitglied_id ) ),
                'zusatzsymbole' => '<span class="zusatzsymbol" data-zusatzsymbol="kategorie"></span>',
            );

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
    public function ajax_mitglieder() { $ajax_antwort = array( CSRF_NAME => csrf_hash(), 'tabelle' => array() );
        $validation_rules = array(
            // 'hash' => 'required|alpha_numeric',
            'ajax_id' => 'required|is_natural',
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else foreach( model(Mitglied_Model::class)->findAll() as $mitglied_ ) {
                $mitglied = array(
                    'id' => $mitglied_->id,
                    'vorname' => $mitglied_->vorname,
                    'nachname' => $mitglied_->nachname,
                    'geburt' => $mitglied_->geburt,
                    'postleitzahl' => $mitglied_->postleitzahl,
                    'wohnort' => $mitglied_->wohnort,
                    'geschlecht' => $mitglied_->geschlecht,
                );
                if( array_key_exists( 'register', EIGENSCHAFTEN['mitglieder'] ) ) $mitglied['register'] = $mitglied_->register;
                if( array_key_exists( 'auto', EIGENSCHAFTEN['mitglieder'] ) ) $mitglied['auto'] = $mitglied_->auto;
                if( array_key_exists( 'funktion', EIGENSCHAFTEN['mitglieder'] ) ) $mitglied['funktion'] = $mitglied_->funktion;
                if( array_key_exists( 'vorstandschaft', EIGENSCHAFTEN['mitglieder'] ) ) $mitglied['vorstandschaft'] = $mitglied_->vorstandschaft;
                if( array_key_exists( 'aktiv', EIGENSCHAFTEN['mitglieder'] ) ) $mitglied['aktiv'] = $mitglied_->aktiv;

                if( auth()->user()->can( 'mitglieder.verwaltung' ) ) {
                    // $mitglied = json_decode( json_encode( $mitglied ), TRUE );
                    $mitglied['email'] = $mitglied_->email;
                    $mitglied['erstellung'] = $mitglied_->created_at;
                    if( $mitglied['erstellung'] != NULL ) $mitglied['erstellung'] = $mitglied['erstellung']->setTimezone('Europe/Berlin')->toDateTimeString();
                    $mitglied['letzte_aktivitaet'] = $mitglied_->last_active;
                    if( $mitglied['letzte_aktivitaet'] != NULL ) $mitglied['letzte_aktivitaet'] = $mitglied['letzte_aktivitaet']->setTimezone('Europe/Berlin')->toDateTimeString();
                } elseif( ICH['id'] == $mitglied['id'] )
                    $mitglied['email'] = $mitglied_->email;

                foreach( $mitglied as $eigenschaft => $wert ) if( is_numeric( $wert ) )
                    if( (int) $wert == $wert ) $mitglied[ $eigenschaft ] = (int)$wert;
                    elseif( (float) $wert == $wert ) $mitglied[ $eigenschaft ] = (float)$wert;
                $ajax_antwort['tabelle'][] = $mitglied;
            }
            // if( hash( 'sha256', json_encode( $ajax_antwort['tabelle'], JSON_UNESCAPED_UNICODE ) ) == $this->request->getPost()['hash'] ) TRUE; //$ajax_antwort['tabelle'] = array();

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

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
            'expires' => JETZT->addSeconds(setting('Auth.magicLinkLifetime'))->format('Y-m-d H:i:s'),
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
        $date      = JETZT->toDateTimeString();

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
        else if( $this->request->getPost()['id'] == ICH['id'] ) $ajax_antwort['info'] = 'Du kannst dich nicht selbst löschen!';
        else model(Mitglied_Model::class)->delete( $this->request->getPost()['id'], TRUE );

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    //------------------------------------------------------------------------------------------------------------------
    public function ajax_verfuegbare_rechte() { $ajax_antwort = array( CSRF_NAME => csrf_hash(), 'tabelle' => array() );
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else foreach( VERFUEGBARE_RECHTE as $verfuegbares_recht ) {
                $verfuegbares_recht = json_decode( json_encode( $verfuegbares_recht ), TRUE );
                foreach( $verfuegbares_recht as $eigenschaft => $wert ) if( is_numeric( $wert ) )
                    if( (int) $wert == $wert ) $verfuegbares_recht[ $eigenschaft ] = (int)$wert;
                    elseif( (float) $wert == $wert ) $verfuegbares_recht[ $eigenschaft ] = (float)$wert;
                $ajax_antwort['tabelle'][] = $verfuegbares_recht;
            }
        
        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }
    
    public function ajax_vergebene_rechte() { $ajax_antwort = array( CSRF_NAME => csrf_hash(), 'tabelle' => array() );
        $id = 1;
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else foreach( model(Mitglied_Model::class)->findAll() as $mitglied ) {
            if( auth()->user()->can( 'mitglieder.rechte' ) OR $mitglied->id == ICH['id'] )
                foreach( $mitglied->getPermissions() as $permission ) if( array_key_exists( $permission, VERFUEGBARE_RECHTE ) ) {
                    $vergebenes_recht['id'] = $id;
                    $vergebenes_recht['mitglied_id'] = $mitglied->id;
                    $vergebenes_recht['verfuegbares_recht_id'] = VERFUEGBARE_RECHTE[ $permission ]['id'];
                    $vergebenes_recht = json_decode( json_encode( $vergebenes_recht ), TRUE );
                    foreach( $vergebenes_recht as $eigenschaft => $wert )
                    if( !array_key_exists( $eigenschaft, EIGENSCHAFTEN['vergebene_rechte'] ) ) unset( $vergebenes_recht[$eigenschaft] );
                    elseif( is_numeric( $wert ) ) {
                        if( (int) $wert == $wert ) $vergebenes_recht[ $eigenschaft ] = (int)$wert;
                        elseif( (float) $wert == $wert ) $vergebenes_recht[ $eigenschaft ] = (float)$wert;
                    }
                    $ajax_antwort['tabelle'][] = $vergebenes_recht;
                    $id++;
                }
            }

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

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
