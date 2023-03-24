<?php

namespace App\Controllers;
use App\Models\Notenbank\Titel_Model;

class Notenbank extends BaseController {

    public function notenbank() {

        $this->viewdata['liste']['aktuelles_verzeichnis'] = array(
            'liste' => 'notenbank',
            'sortieren' => array(
                array( 'eigenschaft' => 'titel', 'richtung' => SORT_ASC, ),
                array( 'eigenschaft' => 'titel_nr', 'richtung' => SORT_ASC, ),                
                array( 'eigenschaft' => 'kategorie', 'richtung' => SORT_ASC, ),                
            ),
            'beschriftung' => array(
                'beschriftung' => '<span class="eigenschaft" data-eigenschaft="titel"></span>',
                'h5' => true,
            ),
            // 'sortable' => true,
            // 'link' => site_url().CONTROLLER, // ODER 'modal' => array( // ODER 
            //     'target' => '#element_loeschen_Modal',
            //     'aktion' => 'loeschen',
            // ),
            // 'symbol' => array(
            //     'symbol' => SYMBOLE['info']['bootstrap'],
            //     // 'farbe' => 'danger',
            // ),
            'vorschau' => array(
                'beschriftung' => '<span class="eigenschaft" data-eigenschaft="titel_nr"></span><i class="bi bi-dot spacer"></i><span class="eigenschaft" data-eigenschaft="kategorie">',
                // 'klein' => true,
                // 'zentriert' => true,
                'abschneiden' => true,
            ),
            // 'zusatzsymbole' => '<span class="zusatzsymbol" data-zusatzsymbol="kategorie"></span>',
        );

        if( auth()->user()->can( 'notenbank.verwaltung' ) ) {
            $this->viewdata['liste']['aktuelles_verzeichnis']['werkzeugkasten']['loeschen'] = array(
                'modal_id' => '#element_loeschen_Modal',
                'farbe' => 'danger',
            );
            $this->viewdata['liste']['aktuelles_verzeichnis']['werkzeugkasten']['duplizieren'] = array(
                'modal_id' => '#titel_erstellen_Modal',
            );
            $this->viewdata['liste']['aktuelles_verzeichnis']['werkzeugkasten']['aendern'] = array(
                'modal_id' => '#titel_erstellen_Modal',
            );

            $this->viewdata['werkzeugkasten']['erstellen'] = array(
                'modal_id' => '#titel_erstellen_Modal',
                'element' => 'titel',
                'beschriftung' => 'Titel erstellen',
            );
        }

        $this->viewdata['werkzeugkasten']['filtern'] = array(
            'modal_id' => '#liste_filtern_Modal',
            'liste' => 'notenbank',
            'beschriftung' => 'Notenbank filtern',
        ); 

        $this->viewdata['werkzeugkasten']['sortieren'] = array(
            'modal_id' => '#liste_sortieren_Modal',
            'liste' => 'notenbank',
            'beschriftung' => 'Notenbank sortieren',
        ); 

        $this->viewdata['werkzeugkasten']['filtern'] = array(
            'modal_id' => '#liste_filtern_Modal',
            'liste' => 'notenbank',
            'beschriftung' => 'Notenbank filtern',
        ); 

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        echo view( 'Notenbank/notenbank', $this->viewdata );
    }

    //------------------------------------------------------------------------------------------------------------------
    public function ajax_notenbank() { $ajax_antwort['csrf_hash'] = csrf_hash();
        $ajax_antwort['tabelle'] = model(Titel_Model::class)->findAll();
        foreach( $ajax_antwort['tabelle'] as $id => $titel ) {
            $ajax_antwort['tabelle'][ $id ] = json_decode( json_encode( $titel ), TRUE );
            foreach( $ajax_antwort['tabelle'][ $id ] as $eigenschaft => $wert ) if( is_numeric( $wert ) ) $ajax_antwort['tabelle'][ $id ][ $eigenschaft ] = (int)$wert;
        }
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_titel_erstellen() { $ajax_antwort['csrf_hash'] = csrf_hash();
        $validation_rules = array(
            'id' => [ 'label' => 'ID', 'rules' => [ 'if_exist', 'is_natural_no_zero' ] ],
            'titel' => [ 'label' => EIGENSCHAFTEN['notenbank']['notenbank']['titel']['beschriftung'], 'rules' => [ 'required' ] ],
            'titel_nr' => [ 'label' => EIGENSCHAFTEN['notenbank']['notenbank']['titel_nr']['beschriftung'], 'rules' => [ 'required', 'is_natural_no_zero' ] ],
        );
        if( array_key_exists( 'kategorie', EIGENSCHAFTEN['notenbank']['notenbank'] ) ) $validation_rules['kategorie'] = [ 'label' => EIGENSCHAFTEN['notenbank']['notenbank']['kategorie']['beschriftung'], 'rules' => [ 'in_list['.implode( ', ', array_keys( VORGEGEBENE_WERTE['notenbank']['kategorie'] ) ).']', ] ];

        if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->user()->can( 'notenbank.verwaltung' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else {
            $notenbank_Model = model(Titel_Model::class);
            $titel = array(
                'titel' => $this->request->getpost()['titel'],
                'titel_nr' => $this->request->getPost()['titel_nr'],
            );
            if( array_key_exists( 'kategorie', EIGENSCHAFTEN['notenbank']['notenbank'] ) ) $titel['kategorie'] = $this->request->getpost()['kategorie'];

            if( !empty( $this->request->getPost()['id'] ) ) $notenbank_Model->update( $this->request->getpost()['id'], $titel );
            else $notenbank_Model->save( $titel );
        }
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_titel_loeschen() { $ajax_antwort['csrf_hash'] = csrf_hash();
        $validation_rules = array(
            'id' => [ 'label' => 'ID', 'rules' => [ 'required', 'is_natural_no_zero' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->user()->can( 'notenbank.verwaltung' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else model(Titel_Model::class)->delete( $this->request->getPost()['id'] );
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

}
