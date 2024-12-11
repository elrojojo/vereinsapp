<?php

namespace App\Controllers;

use App\Models\Strafkatalog\Strafe_Model;
use App\Models\Strafkatalog\Strafkatalog_Kassenbucheintrag_Model as Kassenbucheintrag_Model;

class Strafkatalog extends BaseController {

    public function strafkatalog() {

        $this->viewdata['liste']['aktueller_strafkatalog'] = array(
            'liste' => 'strafkatalog',
            'sortieren' => array(
                array( 'eigenschaft' => 'kategorie', 'richtung' => SORT_ASC, ),
                array( 'eigenschaft' => 'titel', 'richtung' => SORT_ASC, ),
                array( 'eigenschaft' => 'wert', 'richtung' => SORT_ASC, ),
            ),
            'group-flush' => TRUE,
            // 'link' => TRUE,
            'beschriftung' => '<span class="eigenschaft" data-eigenschaft="titel"></span>',
            'vorschau' => array( 'wert', 'kategorie' ),
            'werkzeugkasten' => array(
                'filtern' => array( 'klasse_id' => 'btn_filtern_modal_oeffnen', 'title' => 'Strafkatalog filtern', ),
                'sortieren' => array( 'klasse_id' => 'btn_sortieren_modal_oeffnen', 'title' => 'Strafkatalog sortieren', ),
            ),
        'listenstatistik' => array(),
        );

        if( auth()->user()->can( 'strafkatalog.verwaltung' ) ) {

            $this->viewdata['liste']['aktueller_strafkatalog']['werkzeugkasten_handle'] = TRUE;

            $this->viewdata['werkzeugkasten']['strafe_zuweisen'] = array(
                'klasse_id' => array('btn_strafe_zuweisen', 'auswahl_oeffnen'),
                'title' => 'Strafe einem Mitglied zuweisen',
            );

            $this->viewdata['liste']['mitglieder_auswahl'] = array(
                'liste' => 'mitglieder',
                'sortieren' => array(
                    array( 'eigenschaft' => 'nachname', 'richtung' => SORT_ASC, ),
                    array( 'eigenschaft' => 'vorname', 'richtung' => SORT_ASC, ),                
                    array( 'eigenschaft' => 'register', 'richtung' => SORT_ASC, ),                
                        ),
                'beschriftung' => '<span class="eigenschaft" data-eigenschaft="vorname"></span> <span class="eigenschaft" data-eigenschaft="nachname"></span>',
                'klasse_id' => array('btn_strafe_zuweisen', 'bestaetigung_einfordern'),
                'title' => 'Strafe einem Mitglied zuweisen',
                'werkzeugkasten' => array(
                    'filtern' => array( 'klasse_id' => 'btn_filtern_modal_oeffnen', 'title' => 'Mitglieder filtern', ),
                    'sortieren' => array( 'klasse_id' => 'btn_sortieren_modal_oeffnen', 'title' => 'Mitglieder sortieren', ),
                ),
                'listenstatistik' => array(),
            );

            $this->viewdata['werkzeugkasten']['aendern'] = array(
                'klasse_id' => array('btn_strafe_aendern', 'formular_oeffnen'),
                'title' => 'Strafe ändern',
            );
            $this->viewdata['werkzeugkasten']['duplizieren'] = array(
                'klasse_id' => array('btn_strafe_duplizieren', 'formular_oeffnen'),
                'title' => 'Strafe duplizieren',
            );
            $this->viewdata['werkzeugkasten']['loeschen'] = array(
                'klasse_id' => array('btn_strafe_loeschen', 'bestaetigung_einfordern'),
                'title' => 'Strafe löschen',
                'farbe' => 'danger',
            );

            $this->viewdata['liste']['aktueller_strafkatalog']['werkzeugkasten']['erstellen'] = array(
                'klasse_id' => array('btn_strafe_erstellen', 'formular_oeffnen'),
                'title' => 'Strafe erstellen',
            );
        }

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        echo view( 'Strafkatalog/strafkatalog', $this->viewdata );
    }

    //------------------------------------------------------------------------------------------------------------------
    public function kassenbuch() {

    $this->viewdata['liste']['aktuelles_kassenbuch'] = array(
        'liste' => 'kassenbuch',
        'sortieren' => array(
            array( 'eigenschaft' => 'erstellung', 'richtung' => SORT_DESC, ),
            array( 'eigenschaft' => 'titel', 'richtung' => SORT_ASC, ),
            array( 'eigenschaft' => 'wert', 'richtung' => SORT_ASC, ),
        ),
        'group-flush' => TRUE,
        // 'link' => TRUE,
        'beschriftung' => '<span class="eigenschaft" data-eigenschaft="titel"></span>',
        'vorschau' => array( 'erstellung', 'wert', 'mitglied_id' ),
        'zusatzsymbole' => array('offen_erledigt'),
        'bedingte_formatierung' => array(
            'klasse' => array(
                'text-danger' => array( 'operator' => '<=', 'eigenschaft' => 'wert', 'wert' => 0 ),
            ),
            'eigenschaft' => 'wert',
        ),
        'werkzeugkasten' => array(
            'filtern' => array( 'klasse_id' => 'btn_filtern_modal_oeffnen', 'title' => 'Kassenbuch filtern', ),
            'sortieren' => array( 'klasse_id' => 'btn_sortieren_modal_oeffnen', 'title' => 'Kassenbuch sortieren', ),
        ),
        'listenstatistik' => array(
            'summe' => 'wert',
        ),
    );

        if( auth()->user()->can( 'strafkatalog.verwaltung' ) ) {

            $this->viewdata['liste']['aktuelles_kassenbuch']['werkzeugkasten_handle'] = TRUE;

            $this->viewdata['werkzeugkasten']['offen_erledigt_markieren'] = array(
                'klasse_id' => array('btn_kassenbucheintrag_offen_erledigt_markieren', 'bestaetigung_einfordern'),
                'title' => 'Kassenbucheintrag als offen/erledigt markieren',
            );

            $this->viewdata['werkzeugkasten']['aendern'] = array(
                'klasse_id' => array('btn_kassenbucheintrag_aendern', 'formular_oeffnen'),
                'title' => 'Kassenbucheintrag ändern',
            );
            $this->viewdata['werkzeugkasten']['duplizieren'] = array(
                'klasse_id' => array('btn_kassenbucheintrag_duplizieren', 'formular_oeffnen'),
                'title' => 'Kassenbucheintrag duplizieren',
            );
            $this->viewdata['werkzeugkasten']['loeschen'] = array(
                'klasse_id' => array('btn_kassenbucheintrag_loeschen', 'bestaetigung_einfordern'),
                'title' => 'Kassenbucheintrag löschen',
                'farbe' => 'danger',
            );

            $this->viewdata['liste']['aktuelles_kassenbuch']['werkzeugkasten']['erstellen'] = array(
                'klasse_id' => array('btn_kassenbucheintrag_erstellen', 'formular_oeffnen'),
                'title' => 'Kassenbucheintrag erstellen',
            );

        }

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        echo view( 'Strafkatalog/kassenbuch', $this->viewdata );
    }

    //------------------------------------------------------------------------------------------------------------------
    public function ajax_strafe_speichern() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'id' => [ 'label' => 'ID', 'rules' => [ 'if_exist', 'is_natural_no_zero' ] ],
            'titel' => [ 'label' => EIGENSCHAFTEN['strafkatalog']['titel']['beschriftung'], 'rules' => [ 'required' ] ],
            'wert' => [ 'label' => EIGENSCHAFTEN['strafkatalog']['wert']['beschriftung'], 'rules' => [ 'required', 'decimal', 'greater_than_equal_to[0]' ] ],
            'kategorie' => [ 'label' => EIGENSCHAFTEN['strafkatalog']['kategorie']['beschriftung'], 'rules' => [ 'required', 'in_list['.implode( ', ', array_keys( VORGEGEBENE_WERTE['strafkatalog']['kategorie'] ) ).']' ] ],
            'bemerkung' => [ 'label' => EIGENSCHAFTEN['strafkatalog']['bemerkung']['beschriftung'], 'rules' => [ 'if_exist', 'permit_empty' ] ],
        );
        if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->user()->can( 'strafkatalog.verwaltung' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else {
            $strafkatalog_Model = model(Strafe_Model::class);
            $strafe = array(
                'titel' => $this->request->getpost()['titel'],
                'wert' => $this->request->getPost()['wert'],
                'kategorie' => $this->request->getPost()['kategorie'],
            );
            if( array_key_exists( 'bemerkung', $this->request->getpost() ) ) $strafe['bemerkung'] = $this->request->getpost()['bemerkung']; else $strafe['bemerkung'] = '';

            if( array_key_exists( 'id', $this->request->getPost() ) AND !empty( $this->request->getPost()['id'] ) ) $strafkatalog_Model->update( $this->request->getpost()['id'], $strafe );
            else {
                $strafkatalog_Model->save( $strafe );
                $ajax_antwort['strafe_id'] = (int)$strafkatalog_Model->getInsertID();
            }
        }

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_strafe_loeschen() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'id' => [ 'label' => 'ID', 'rules' => [ 'required', 'is_natural_no_zero' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->user()->can( 'strafkatalog.verwaltung' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else model(Strafe_Model::class)->delete( $this->request->getPost()['id'] );
        
        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    //------------------------------------------------------------------------------------------------------------------
    public function ajax_kassenbucheintrag_speichern() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'id' => [ 'label' => 'ID', 'rules' => [ 'if_exist', 'is_natural_no_zero' ] ],
            'titel' => [ 'label' => EIGENSCHAFTEN['kassenbuch']['titel']['beschriftung'], 'rules' => [ 'required' ] ],
            'wert' => [ 'label' => EIGENSCHAFTEN['kassenbuch']['wert']['beschriftung'], 'rules' => [ 'required', 'decimal' ] ],
            'mitglied_id' => [ 'label' => EIGENSCHAFTEN['kassenbuch']['mitglied_id']['beschriftung'], 'rules' => [ 'required', 'is_natural_no_zero' ] ],
            'erledigt' => [ 'label' => EIGENSCHAFTEN['kassenbuch']['erledigt']['beschriftung'], 'rules' => [ 'if_exist', 'valid_date', 'permit_empty' ] ],
            'bemerkung' => [ 'label' => EIGENSCHAFTEN['kassenbuch']['bemerkung']['beschriftung'], 'rules' => [ 'if_exist', 'permit_empty' ] ],
        );
        if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->user()->can( 'strafkatalog.verwaltung' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else {
            $kassenbuch_Model = model(Kassenbucheintrag_Model::class);
            $kassenbucheintrag = array(
                'titel' => $this->request->getpost()['titel'],
                'wert' => $this->request->getPost()['wert'],
                'mitglied_id' => $this->request->getPost()['mitglied_id'],
            );
            if( array_key_exists( 'erledigt', $this->request->getpost() ) ) { if( !empty( $this->request->getpost()['erledigt'] ) ) $kassenbucheintrag['erledigt'] = $this->request->getpost()['erledigt']; else $kassenbucheintrag['erledigt'] = NULL; }
            if( array_key_exists( 'bemerkung', $this->request->getpost() ) ) $kassenbucheintrag['bemerkung'] = $this->request->getpost()['bemerkung']; else $kassenbucheintrag['bemerkung'] = '';

            if( array_key_exists( 'id', $this->request->getPost() ) AND !empty( $this->request->getPost()['id'] ) ) $kassenbuch_Model->update( $this->request->getpost()['id'], $kassenbucheintrag );
            else {
                $kassenbuch_Model->save( $kassenbucheintrag );
                $ajax_antwort['kassenbucheintrag_id'] = (int)$kassenbuch_Model->getInsertID();
            }
        }

        $ajax_antwort['info'] = "Test";

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_kassenbucheintrag_loeschen() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'id' => [ 'label' => 'ID', 'rules' => [ 'required', 'is_natural_no_zero' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->user()->can( 'strafkatalog.verwaltung' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else model(Kassenbucheintrag_Model::class)->delete( $this->request->getPost()['id'] );
        
        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

}
