<?php

namespace App\Controllers;
use App\Models\Notenbank\Titel_Model;



class Notenbank extends BaseController {

    public function notenbank() {

        $this->viewdata['liste']['aktuelles_verzeichnis'] = array(
            'liste' => 'notenbank',
            'sortieren' => array(
                array( 'eigenschaft' => 'titel_nr', 'richtung' => SORT_ASC, ),
                array( 'eigenschaft' => 'titel', 'richtung' => SORT_ASC, ),
                array( 'eigenschaft' => 'kategorie', 'richtung' => SORT_ASC, ),
            ),
            'beschriftung' => array(
                'beschriftung' => '[<span class="eigenschaft" data-eigenschaft="titel_nr"></span>] <span class="eigenschaft" data-eigenschaft="titel"></span>',
                'h5' => TRUE,
            ),
            'link' => TRUE,
            'vorschau' =>   '<span class="eigenschaft" data-eigenschaft="kategorie"></span><i class="bi bi-'.SYMBOLE['spacer']['bootstrap'].' spacer"></i>'.
                            '<span class="eigenschaft" data-eigenschaft="anzahl_noten"></span><i class="bi bi-'.SYMBOLE['spacer']['bootstrap'].' spacer"></i>'.
                            '<span class="eigenschaft" data-eigenschaft="anzahl_audio"></span><i class="bi bi-'.SYMBOLE['spacer']['bootstrap'].' spacer"></i>'.
                            '<span class="eigenschaft" data-eigenschaft="anzahl_verzeichnis"></span><i class="bi bi-'.SYMBOLE['spacer']['bootstrap'].' spacer"></i>',
            'listenstatistik' => array(),
        );

        if( auth()->user()->can( 'notenbank.verwaltung' ) ) {
            $this->viewdata['liste']['aktuelles_verzeichnis']['werkzeugkasten_handle'] = TRUE;

            $this->viewdata['werkzeugkasten']['aendern'] = array(
                'klasse_id' => array('btn_titel_aendern', 'formular_oeffnen'),
                'title' => 'Titel ändern',
            );
            $this->viewdata['werkzeugkasten']['duplizieren'] = array(
                'klasse_id' => array('btn_titel_duplizieren', 'formular_oeffnen'),
                'title' => 'Titel duplizieren',
            );
            $this->viewdata['werkzeugkasten']['loeschen'] = array(
                'klasse_id' => array('btn_titel_loeschen', 'bestaetigung_einfordern'),
                'title' => 'Titel löschen',
                'farbe' => 'danger',
            );

            $this->viewdata['liste']['aktuelles_verzeichnis']['werkzeugkasten']['erstellen'] = array(
                'klasse_id' => array('btn_titel_erstellen', 'formular_oeffnen'),
                'title' => 'Titel erstellen',
            );
        }

        $this->viewdata['liste']['aktuelles_verzeichnis']['werkzeugkasten']['filtern'] = array(
            'klasse_id' => 'btn_filtern_modal_oeffnen',
            'title' => 'Notenbank filtern',
        ); 

        $this->viewdata['liste']['aktuelles_verzeichnis']['werkzeugkasten']['sortieren'] = array(
            'klasse_id' => 'btn_sortieren_modal_oeffnen',
            'title' => 'Notenbank sortieren',
        ); 

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        echo view( 'Notenbank/notenbank', $this->viewdata );
    }

    //------------------------------------------------------------------------------------------------------------------
    public function details( $titel_id ) {
        if( empty( model(Titel_Model::class)->find( $titel_id ) ) ) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    
        $this->viewdata['element_id'] = $titel_id;

        $this->viewdata['verzeichnis']['aktuelles_verzeichnis'] = array(
            'liste' => 'notenbank',
            'link' => TRUE,
            'element_id' => $titel_id,
        );

        if( auth()->user()->can( 'notenbank.verwaltung' ) ) {
            $this->viewdata['werkzeugkasten']['aendern'] = array(
                'klasse_id' => array('btn_titel_aendern', 'formular_oeffnen'),
                'title' => 'Titel ändern',
            );
            $this->viewdata['werkzeugkasten']['duplizieren'] = array(
                'klasse_id' => array('btn_titel_duplizieren', 'formular_oeffnen'),
                'title' => 'Titel duplizieren',
            );
            $this->viewdata['werkzeugkasten']['loeschen'] = array(
                'klasse_id' => array('btn_titel_loeschen', 'bestaetigung_einfordern'),
                'title' => 'Titel löschen',
                'farbe' => 'danger',
                'weiterleiten' => 'notenbank',
            );
        }

        $this->viewdata['element_navigation'] = array(
            'instanz' => 'aktuelles_verzeichnis',
            'sortieren' => array(
                array( 'eigenschaft' => 'titel_nr', 'richtung' => SORT_ASC, ),
                array( 'eigenschaft' => 'titel', 'richtung' => SORT_ASC, ),
                array( 'eigenschaft' => 'kategorie', 'richtung' => SORT_ASC, ),
            ),
        );

        if( array_key_exists( 'verzeichnis', $this->viewdata ) ) foreach( $this->viewdata['verzeichnis'] as $id => $verzeichnis ) $this->viewdata['verzeichnis'][ $id ]['id'] = $id;
        echo view( 'Notenbank/titel_details', $this->viewdata );
    }

    //------------------------------------------------------------------------------------------------------------------
    public function ajax_notenbank() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else {
            $ajax_antwort['tabelle'] = model(Titel_Model::class)->findAll();
            foreach( $ajax_antwort['tabelle'] as $id => $titel ) {
                $verzeichnis = null; foreach( directory_map( './storage/notenbank/', 1 ) as $verzeichnis_ )
                    if( is_dir( './storage/notenbank/'.$verzeichnis_ ) AND
                        substr( $verzeichnis_, 0, NOTENBANK_ANZAHL_ZIFFERN ) == str_pad( $titel['titel_nr'], NOTENBANK_ANZAHL_ZIFFERN ,'0', STR_PAD_LEFT ) )
                        $verzeichnis = $verzeichnis_;

                $titel['verzeichnis_basis'] = $verzeichnis; 
                if( $verzeichnis !== null ) $titel['verzeichnis'] = $this->verzeichnis_indizieren( directory_map( './storage/notenbank/'.$verzeichnis ) ); 
                else $titel['verzeichnis'] = $this->verzeichnis_indizieren( array() );
                $ajax_antwort['tabelle'][ $id ] = json_decode( json_encode( $titel ), TRUE );
                foreach( $ajax_antwort['tabelle'][ $id ] as $eigenschaft => $wert )
                if( !array_key_exists( $eigenschaft, EIGENSCHAFTEN['notenbank'] ) ) unset( $ajax_antwort['tabelle'][ $id ][$eigenschaft] );
                elseif( is_numeric( $wert ) ) {
                    if( (int) $wert == $wert ) $ajax_antwort['tabelle'][ $id ][ $eigenschaft ] = (int)$wert;
                    elseif( (float) $wert == $wert ) $ajax_antwort['tabelle'][ $id ][ $eigenschaft ] = (float)$wert;
                }
            }
        }

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_titel_speichern() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'id' => [ 'label' => 'ID', 'rules' => [ 'if_exist', 'is_natural_no_zero' ] ],
            'titel' => [ 'label' => EIGENSCHAFTEN['notenbank']['titel']['beschriftung'], 'rules' => [ 'required' ] ],
            'titel_nr' => [ 'label' => EIGENSCHAFTEN['notenbank']['titel_nr']['beschriftung'], 'rules' => [ 'required', 'is_natural_no_zero' ] ],
            'kategorie' => [ 'label' => EIGENSCHAFTEN['notenbank']['kategorie']['beschriftung'], 'rules' => [ 'required', 'in_list['.implode( ', ', array_keys( VORGEGEBENE_WERTE['notenbank']['kategorie'] ) ).']' ] ],
        );
        $validation_titel_nr = model(Titel_Model::class)->where( [ 'titel_nr' => $this->request->getPost()['titel_nr'] ] )->findAll();
        $validation_titel_nr_id = model(Titel_Model::class)->where( [ 'titel_nr' => $this->request->getPost()['titel_nr'] ] )->findColumn('id');
        if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->user()->can( 'notenbank.verwaltung' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else if( ( !array_key_exists( 'id', $this->request->getPost() ) AND !is_null( $validation_titel_nr ) AND count( $validation_titel_nr ) > 0 )
             OR ( array_key_exists( 'id', $this->request->getPost() ) AND !empty( $this->request->getPost()['id'] ) AND !is_null( $validation_titel_nr_id ) AND !in_array( $this->request->getPost()['id'], $validation_titel_nr_id ) ) )
                $ajax_antwort['validation']['titel_nr'] = EIGENSCHAFTEN['notenbank']['titel_nr']['beschriftung'].' wird bereits verwendet.';
        else {
            $notenbank_Model = model(Titel_Model::class);
            $titel = array(
                'titel' => $this->request->getpost()['titel'],
                'titel_nr' => $this->request->getPost()['titel_nr'],
                'kategorie' => $this->request->getPost()['kategorie'],
            );

            if( array_key_exists( 'id', $this->request->getPost() ) AND !empty( $this->request->getPost()['id'] ) ) $notenbank_Model->update( $this->request->getpost()['id'], $titel );
            else {
                $notenbank_Model->save( $titel );
                $ajax_antwort['titel_id'] = (int)$notenbank_Model->getInsertID();
            }
        }

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_titel_loeschen() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'id' => [ 'label' => 'ID', 'rules' => [ 'required', 'is_natural_no_zero' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->user()->can( 'notenbank.verwaltung' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else model(Titel_Model::class)->delete( $this->request->getPost()['id'] );
        
        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    private function verzeichnis_indizieren( $verzeichnis ) {
        $verzeichnis_indiziert = array(
            'unterverzeichnisse' => array(),
            'dateien' => array(),
        );
        foreach( $verzeichnis as $beschriftung => $unterverzeichnis ) {
            if( substr( $beschriftung, -1 ) == '\\' ) $beschriftung = substr_replace($beschriftung, '/', -1);

            if( is_array($unterverzeichnis) ) $verzeichnis_indiziert['unterverzeichnisse'][$beschriftung] = $this->verzeichnis_indizieren( $unterverzeichnis );
            else if( in_array( pathinfo( $unterverzeichnis,  PATHINFO_EXTENSION ), array_merge( NOTENBANK_ERLAUBTE_DATEITYPEN_NOTEN, NOTENBANK_ERLAUBTE_DATEITYPEN_AUDIO ) ) )
                $verzeichnis_indiziert['dateien'][] = $unterverzeichnis;
            else { /* alle anderen Dateitypen werden nicht berücksichtigt */ }
        }
        return $verzeichnis_indiziert;
    }
    
}
