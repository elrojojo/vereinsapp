<?php

namespace App\Controllers;
use App\Models\Umfragen\Umfrage_Model;
use App\Models\Umfragen\Rueckmeldung_Model;

use CodeIgniter\I18n\Time;

class Umfragen extends BaseController {

    public function umfragen() {

        $this->viewdata['liste']['aktuelle_umfragen'] = HAUPTINSTANZEN['umfragen'];
        $this->viewdata['liste']['aktuelle_umfragen']['group-flush'] = TRUE;
        $this->viewdata['liste']['aktuelle_umfragen']['link'] = TRUE;
        $this->viewdata['liste']['aktuelle_umfragen']['views'] = array( array( 'view' => 'Umfragen/rueckmeldung_basiseigenschaften', 'data' => array( 'mitglied_id' => ICH['id'] ) ) );

        if( auth()->user()->can( 'umfragen.verwaltung' ) ) {

            $this->viewdata['liste']['aktuelle_umfragen']['werkzeugkasten_handle'] = TRUE;

            $this->viewdata['werkzeugkasten']['aendern'] = array(
                'klasse_id' => array('btn_umfrage_aendern', 'formular_oeffnen'),
                'title' => 'Umfrage ändern',
            );
            $this->viewdata['werkzeugkasten']['duplizieren'] = array(
                'klasse_id' => array('btn_umfrage_duplizieren', 'formular_oeffnen'),
                'title' => 'Umfrage duplizieren',
            );
            $this->viewdata['werkzeugkasten']['loeschen'] = array(
                'klasse_id' => array('btn_umfrage_loeschen', 'bestaetigung_einfordern'),
                'title' => 'Umfrage löschen',
                'farbe' => 'danger',
            );

            $this->viewdata['liste']['aktuelle_umfragen']['werkzeugkasten']['erstellen'] = array(
                'klasse_id' => array('btn_umfrage_erstellen', 'formular_oeffnen'),
                'title' => 'Umfrage erstellen',
            );

        }

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        echo view( 'Umfragen/umfragen', $this->viewdata );
    }

    //------------------------------------------------------------------------------------------------------------------
    public function details( $umfrage_id ) {
        if( empty( model(Umfrage_Model::class)->find( $umfrage_id ) ) ) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $this->viewdata['element_id'] = $umfrage_id;

        $this->viewdata['auswertungen'][ 'rueckmeldungen_umfrage' ] = array(
            // 'auswertungen' => 'rueckmeldungen',
            // 'status_auswahl' => array( 1 => "ZUSAGEN", 2 => "ABSAGEN" ),
            // 'liste' => array( 'liste' => 'mitglieder', 'gruppieren' => 'register', 'filtern' => $this->umfrage_filtern_mitglieder_kombiniert( $umfrage_id ), ),
            // 'gegen_liste' => 'umfragen',
            // 'gegen_element_id' => $umfrage_id,
        );

        $this->viewdata['auswertungen']['rueckmeldungen_umfrage']['werkzeugkasten']['gruppieren'] = array(
            'klasse_id' => 'btn_gruppieren_modal_oeffnen',
            'title' => 'Auswertung gruppieren',
        );

        $this->viewdata['auswertungen']['rueckmeldungen_umfrage']['werkzeugkasten']['filtern'] = array(
            'klasse_id' => 'btn_filtern_modal_oeffnen',
            'title' => 'Auswertung filtern',
        );

        $this->viewdata['liste']['zugeordnete_aufgaben'] = HAUPTINSTANZEN['aufgaben'];
        unset($this->viewdata['liste']['zugeordnete_aufgaben']['werkzeugkasten']);
        $this->viewdata['liste']['zugeordnete_aufgaben']['filtern'] = array( array( 'verknuepfung' => '&&', 'filtern' => array(
            array( 'eigenschaft' => 'zugeordnete_liste', 'operator' => '==', 'wert' => "umfragen", ),
            array( 'eigenschaft' => 'zugeordnete_element_id', 'operator' => '==', 'wert' => $umfrage_id, ),
        ), ), );
        $this->viewdata['liste']['zugeordnete_aufgaben']['beschriftung'] = '<i class="bi bi-'.SYMBOLE['aufgaben']['bootstrap'].'"></i> '.HAUPTINSTANZEN['aufgaben']['beschriftung'];
        $this->viewdata['liste']['zugeordnete_aufgaben']['views'] = array( array( 'view' => 'Aufgaben/eingeplantes_mitglied' ), );

        if( array_key_exists( 'aufgaben.verwaltung', VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'aufgaben.verwaltung' ) )
            $this->viewdata['liste']['zugeordnete_aufgaben']['zusatzsymbole'] = array( 'aendern', 'duplizieren', 'loeschen', );

        if( auth()->user()->can( 'umfragen.verwaltung' ) ) {
            $this->viewdata['werkzeugkasten']['aendern'] = array(
                'klasse_id' => array('btn_umfrage_aendern', 'formular_oeffnen'),
                'title' => 'Umfrage ändern',
            );
            $this->viewdata['werkzeugkasten']['duplizieren'] = array(
                'klasse_id' => array('btn_umfrage_duplizieren', 'formular_oeffnen'),
                'title' => 'Umfrage duplizieren',
            );
            $this->viewdata['werkzeugkasten']['loeschen'] = array(
                'klasse_id' => array('btn_umfrage_loeschen', 'bestaetigung_einfordern'),
                'title' => 'Umfrage löschen',
                'farbe' => 'danger',
                'weiterleiten' => 'umfragen',
            );
        }

        $this->viewdata['element_navigation'] = array(
            'instanz' => 'bevorstehende_umfragen',
            'filtern' => array(
                array( 'operator' => '>=', 'eigenschaft' => 'start', 'wert' => Time::today( 'Europe/Berlin' )->toDateTimeString() ),
            ),
            'sortieren' => array(
                array( 'eigenschaft'=> 'start', 'richtung'=> SORT_ASC, ),
            ),
        );

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        if( array_key_exists( 'auswertungen', $this->viewdata ) ) foreach( $this->viewdata['auswertungen'] as $id => $auswertungen ) $this->viewdata['auswertungen'][ $id ]['id'] = $id;
        echo view( 'Umfragen/umfrage_details', $this->viewdata );
    }

    //------------------------------------------------------------------------------------------------------------------
    public function ajax_umfrage_speichern() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'id' => [ 'label' => 'ID', 'rules' => [ 'if_exist', 'is_natural_no_zero' ] ],
            'titel' => [ 'label' => EIGENSCHAFTEN['umfragen']['titel']['beschriftung'], 'rules' => [ 'required' ] ],
            'bemerkung' => [ 'label' => EIGENSCHAFTEN['umfragen']['bemerkung']['beschriftung'], 'rules' => [ 'field_exists' ] ],
        );
        if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->user()->can( 'umfragen.verwaltung' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else {
            $umfragen_Model = model(Umfrage_Model::class);
            $umfrage = array(
                'titel' => $this->request->getpost()['titel'],
            );
            if( array_key_exists( 'bemerkung', $this->request->getpost() ) ) $umfrage['bemerkung'] = $this->request->getpost()['bemerkung']; else $umfrage['bemerkung'] = '';

            if( array_key_exists( 'id', $this->request->getPost() ) AND !empty( $this->request->getPost()['id'] ) ) $umfragen_Model->update( $this->request->getpost()['id'], $umfrage );
            else {
                $umfragen_Model->save( $umfrage );
                $ajax_antwort['umfrage_id'] = (int)$umfragen_Model->getInsertID();
            }
        }

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_umfrage_loeschen() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'id' => [ 'label' => 'ID', 'rules' => [ 'required', 'is_natural_no_zero' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->user()->can( 'umfragen.verwaltung' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else model(Umfrage_Model::class)->delete( $this->request->getPost()['id'] );

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    //------------------------------------------------------------------------------------------------------------------
    public function ajax_rueckmeldung_speichern() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'umfrage_id' => [ 'label' => EIGENSCHAFTEN['rueckmeldungen']['umfrage_id']['beschriftung'], 'rules' => [ 'required', 'is_natural_no_zero' ] ],
            'mitglied_id' => [ 'label' => EIGENSCHAFTEN['rueckmeldungen']['mitglied_id']['beschriftung'], 'rules' => [ 'required', 'is_natural_no_zero' ] ],
            'status' => [ 'label' => EIGENSCHAFTEN['rueckmeldungen']['status']['beschriftung'], 'rules' => [ 'required', 'is_natural_no_zero' ] ],
            'bemerkung' => [ 'label' => EIGENSCHAFTEN['rueckmeldungen']['bemerkung']['beschriftung'], 'rules' => [ 'field_exists' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( $this->request->getPost()['mitglied_id'] != ICH['id'] AND !(array_key_exists( 'mitglieder.verwaltung', VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'mitglieder.verwaltung' ) ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else {
            $rueckmeldungen_Model = model(Rueckmeldung_Model::class);
            $rueckmeldung = array(
                'umfrage_id' => $this->request->getpost()['umfrage_id'],
                'mitglied_id' => $this->request->getpost()['mitglied_id'],
                'status' => $this->request->getpost()['status'],
            );
            if( array_key_exists( 'bemerkung', $this->request->getpost() ) ) $rueckmeldung['bemerkung'] = $this->request->getpost()['bemerkung']; else $rueckmeldung['bemerkung'] = '';

            if( array_key_exists( 'id', $this->request->getPost() ) AND !empty( $this->request->getPost()['id'] ) ) {
                $rueckmeldungen_Model->where( array( 'umfrage_id' => $rueckmeldung['umfrage_id'], 'mitglied_id' => $rueckmeldung['umfrage_id'], 'id !=' => $this->request->getpost()['id'] ) )->delete();
                $rueckmeldungen_Model->update( $this->request->getpost()['id'], $rueckmeldung );
            } else {
                $rueckmeldungen_Model->save( $rueckmeldung );
                $ajax_antwort['rueckmeldung_id'] = (int)$rueckmeldungen_Model->getInsertID();
            }
        }

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

}
