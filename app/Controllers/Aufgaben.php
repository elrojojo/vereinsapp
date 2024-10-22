<?php

namespace App\Controllers;
use App\Models\Aufgaben\Aufgabe_Model;

use CodeIgniter\I18n\Time;

class Aufgaben extends BaseController {

    public function aufgaben() {

        $this->viewdata['liste']['alle_aufgaben'] = array(
            'liste' => 'aufgaben',
            'sortieren' => array(
                array( 'eigenschaft' => 'titel', 'richtung' => SORT_ASC, ),
            ),
            'beschriftung' => array(
                'beschriftung' => '<span class="eigenschaft" data-eigenschaft="titel"></span>',
                'h5' => TRUE,
            ),
            // 'link' => TRUE,
            'vorschau' => '<span class="eigenschaft" data-eigenschaft="erstellung"></span>',
            'views' => view( 'Aufgaben/aufgabe' ),
            'listenstatistik' => array(),
        );

        if( auth()->user()->can( 'aufgaben.verwaltung' ) ) {
            $this->viewdata['liste']['alle_aufgaben']['werkzeugkasten_handle'] = TRUE;

            $this->viewdata['liste']['mitglieder_auswahl'] = array(
                'liste' => 'mitglieder',
                'sortieren' => array(
                    array( 'eigenschaft' => 'nachname', 'richtung' => SORT_ASC, ),
                    array( 'eigenschaft' => 'vorname', 'richtung' => SORT_ASC, ),                
                    array( 'eigenschaft' => 'register', 'richtung' => SORT_ASC, ),                
                        ),
                'beschriftung' => array(
                    'beschriftung' => '<span class="eigenschaft" data-eigenschaft="vorname"></span> <span class="eigenschaft" data-eigenschaft="nachname"></span>',
                ),
                'klasse_id' => array('btn_aufgabe_mitglied_einplanen'),
                'title' => 'Aufgabe zuweisen',
                'listenstatistik' => array(),
            );

            $this->viewdata['liste']['mitglieder_auswahl']['werkzeugkasten']['filtern'] = array(
                'klasse_id' => 'btn_filtern_modal_oeffnen',
                'title' => 'Mitglieder filtern',
            );

            $this->viewdata['liste']['mitglieder_auswahl']['werkzeugkasten']['sortieren'] = array(
                'klasse_id' => 'btn_sortieren_modal_oeffnen',
                'title' => 'Mitglieder sortieren',
            );

            $this->viewdata['werkzeugkasten']['aendern'] = array(
                'klasse_id' => array('btn_aufgabe_aendern', 'formular_oeffnen'),
                'title' => 'Aufgabe ändern',
            );
            $this->viewdata['werkzeugkasten']['duplizieren'] = array(
                'klasse_id' => array('btn_aufgabe_duplizieren', 'formular_oeffnen'),
                'title' => 'Aufgabe duplizieren',
            );
            $this->viewdata['werkzeugkasten']['loeschen'] = array(
                'klasse_id' => array('btn_aufgabe_loeschen', 'bestaetigung_einfordern'),
                'title' => 'Aufgabe löschen',
                'farbe' => 'danger',
            );

            $this->viewdata['liste']['alle_aufgaben']['werkzeugkasten']['erstellen'] = array(
                'klasse_id' => array('btn_aufgabe_erstellen', 'formular_oeffnen'),
                'title' => 'Aufgabe erstellen',
            );
        }

        $this->viewdata['liste']['alle_aufgaben']['werkzeugkasten']['filtern'] = array(
            'klasse_id' => 'btn_filtern_modal_oeffnen',
            'title' => 'Aufgaben filtern',
        ); 

        $this->viewdata['liste']['alle_aufgaben']['werkzeugkasten']['sortieren'] = array(
            'klasse_id' => 'btn_sortieren_modal_oeffnen',
            'title' => 'Aufgaben sortieren',
        ); 

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        echo view( 'Aufgaben/aufgaben', $this->viewdata );
    }

    //------------------------------------------------------------------------------------------------------------------
    public function ajax_aufgaben() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else {
            $ajax_antwort['tabelle'] = model(Aufgabe_Model::class)->findAll();
            foreach( $ajax_antwort['tabelle'] as $id => $aufgabe ) {
                $aufgabe['erstellung'] = $aufgabe['created_at'];
                if( $aufgabe['erstellung'] != NULL ) $aufgabe['erstellung'] = ( new Time( $aufgabe['erstellung'] ) )->setTimezone('Europe/Berlin')->toDateTimeString();
                $ajax_antwort['tabelle'][ $id ] = json_decode( json_encode( $aufgabe ), TRUE );
                foreach( $ajax_antwort['tabelle'][ $id ] as $eigenschaft => $wert )
                if( !array_key_exists( $eigenschaft, EIGENSCHAFTEN['aufgaben'] ) ) unset( $ajax_antwort['tabelle'][ $id ][$eigenschaft] );
                elseif( is_numeric( $wert ) ) {
                    if( (int) $wert == $wert ) $ajax_antwort['tabelle'][ $id ][ $eigenschaft ] = (int)$wert;
                    elseif( (float) $wert == $wert ) $ajax_antwort['tabelle'][ $id ][ $eigenschaft ] = (float)$wert;
                }
            }
        }

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_aufgabe_speichern() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'id' => [ 'label' => 'ID', 'rules' => [ 'if_exist', 'is_natural_no_zero' ] ],
            'liste' => [ 'label' => EIGENSCHAFTEN['aufgaben']['liste']['beschriftung'], 'rules' => [ 'if_exist', 'permit_empty' ] ],
            'element_id' => [ 'label' => EIGENSCHAFTEN['aufgaben']['element_id']['beschriftung'], 'rules' => [ 'if_exist', 'is_natural_no_zero' ] ],
            'titel' => [ 'label' => EIGENSCHAFTEN['aufgaben']['titel']['beschriftung'], 'rules' => [ 'required' ] ],
            'mitglied_id_eingeplant' => [ 'label' => EIGENSCHAFTEN['aufgaben']['mitglied_id_eingeplant']['beschriftung'], 'rules' => [ 'if_exist', 'is_natural_no_zero' ] ],
            'mitglied_id_erledigt' => [ 'label' => EIGENSCHAFTEN['aufgaben']['mitglied_id_erledigt']['beschriftung'], 'rules' => [ 'if_exist', 'is_natural_no_zero' ] ],
            'zeitpunkt_erledigt' => [ 'label' => EIGENSCHAFTEN['aufgaben']['zeitpunkt_erledigt']['beschriftung'], 'rules' => [ 'if_exist', 'valid_date' ] ],
            'bemerkung' => [ 'label' => EIGENSCHAFTEN['aufgaben']['bemerkung']['beschriftung'], 'rules' => [ 'if_exist', 'permit_empty' ] ],
        );
        if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->user()->can( 'aufgaben.verwaltung' )
             AND !( array_key_exists( 'mitglied_id_eingeplant', $this->request->getpost() ) AND $this->request->getpost()['mitglied_id_eingeplant'] == ICH['id']
                AND array_key_exists( 'id', $this->request->getpost() ) AND model(Aufgabe_Model::class)->find( $this->request->getpost()['id'] )['mitglied_id_eingeplant'] == NULL ) )
                $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else {
            $aufgaben_Model = model(Aufgabe_Model::class);
            $aufgabe = array(
                'titel' => $this->request->getpost()['titel'],
            );
            if( array_key_exists( 'liste', $this->request->getpost() ) ) $aufgabe['liste'] = $this->request->getpost()['liste'];
            if( array_key_exists( 'element_id', $this->request->getpost() ) ) $aufgabe['element_id'] = $this->request->getpost()['element_id'];
            if( array_key_exists( 'mitglied_id_eingeplant', $this->request->getpost() ) ) $aufgabe['mitglied_id_eingeplant'] = $this->request->getpost()['mitglied_id_eingeplant'];
            if( array_key_exists( 'mitglied_id_erledigt', $this->request->getpost() ) ) $aufgabe['mitglied_id_erledigt'] = $this->request->getpost()['mitglied_id_erledigt'];
            if( array_key_exists( 'zeitpunkt_erledigt', $this->request->getpost() ) ) $aufgabe['zeitpunkt_erledigt'] = $this->request->getpost()['zeitpunkt_erledigt'];
            if( array_key_exists( 'bemerkung', $this->request->getpost() ) ) $aufgabe['bemerkung'] = $this->request->getpost()['bemerkung']; else $aufgabe['bemerkung'] = '';

            if( array_key_exists( 'id', $this->request->getPost() ) AND !empty( $this->request->getPost()['id'] ) ) $aufgaben_Model->update( $this->request->getpost()['id'], $aufgabe );
            else {
                $aufgaben_Model->save( $aufgabe );
                $ajax_antwort['aufgabe_id'] = (int)$aufgaben_Model->getInsertID();
            }
        }

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_aufgabe_loeschen() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'id' => [ 'label' => 'ID', 'rules' => [ 'required', 'is_natural_no_zero' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->user()->can( 'aufgaben.verwaltung' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else model(Aufgabe_Model::class)->delete( $this->request->getPost()['id'] );
        
        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

}
