<?php

namespace App\Controllers;
use App\Models\Termine\Termin_Model;
use App\Models\Termine\Termine_Rueckmeldung_Model as Rueckmeldung_Model;
use App\Models\Termine\Termine_Anwesenheit_Model as Anwesenheit_Model;

class Termine extends BaseController {

    public function termine() {

        $this->viewdata['liste']['bevorstehende_termine'] = array(
            'liste' => 'termine',
            'filtern' => array( array(
                'verknuepfung' => '&&',
                'filtern' => array(
                    array( 'operator' => '>=', 'eigenschaft' => 'start', 'wert' => date( 'Y-m-d', time() ).' 00:00:00' ),
                ),
            ), ),
            'sortieren' => array(
                array( 'eigenschaft'=> 'start', 'richtung'=> SORT_ASC, ),
            ),
            'beschriftung' => array(
                'beschriftung' => '<span class="eigenschaft" data-eigenschaft="titel"></span>',
                'h5' => true,
            ),
            // 'sortable' => true,
            'link' => site_url().CONTROLLER, // ODER 'modal' => array( // ODER 
            //     'target' => '#element_loeschen_Modal',
            //     'aktion' => 'loeschen',
            // ),
            'symbol' => array(
                'symbol' => SYMBOLE['info']['bootstrap'],
                // 'farbe' => 'danger',
            ),
            'vorschau' => array(
                'beschriftung' => '<div class="row g-0 my-1">
                    <div class="col nowrap"><i class="bi bi-calendar-event"></i> <span class="eigenschaft" data-eigenschaft="start"></span></div>
                    <div class="col nowrap"><i class="bi bi-geo-alt-fill"></i> <span class="eigenschaft" data-eigenschaft="ort"></span></div>
                    </div>'.view( 'Termine/rueckmeldung_erstellen', array( 'mitglied_id' => ICH['id'] ) ),
                'klein' => true,
                'zentriert' => true,
                // 'abschneiden' => true,
            ),
            'zusatzsymbole' => '<span class="zusatzsymbol" data-zusatzsymbol="kategorie"></span>',
        );
        if( !auth()->user()->can( 'termine.verwaltung' ) ) $this->viewdata['liste']['bevorstehende_termine']['filtern'][0]['filtern'][] = array( 'operator' => '==', 'eigenschaft' => 'ich_eingeladen', 'wert' => true );

        if( auth()->user()->can( 'termine.verwaltung' ) ) {

            $this->viewdata['liste']['bevorstehende_termine']['werkzeugkasten_element']['loeschen'] = array(
                'modal_id' => '#element_loeschen_Modal',
                'farbe' => 'danger',
            );
            $this->viewdata['liste']['bevorstehende_termine']['werkzeugkasten_element']['duplizieren'] = array(
                'modal_id' => '#termin_erstellen_Modal',
            );
            $this->viewdata['liste']['bevorstehende_termine']['werkzeugkasten_element']['aendern'] = array(
                'modal_id' => '#termin_erstellen_Modal',
            );

            $this->viewdata['liste']['bevorstehende_termine']['werkzeugkasten_liste']['erstellen'] = array(
                'modal_id' => '#termin_erstellen_Modal',
                'beschriftung' => 'Termin erstellen',
            );
        }

        $this->viewdata['liste']['bevorstehende_termine']['werkzeugkasten_liste']['filtern'] = array(
            'modal_id' => '#liste_filtern_Modal',
            'beschriftung' => 'Termine filtern',
        ); 

        $this->viewdata['liste']['bevorstehende_termine']['werkzeugkasten_liste']['sortieren'] = array(
            'modal_id' => '#liste_sortieren_Modal',
            'beschriftung' => 'Termine sortieren',
        ); 

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        echo view( 'Termine/termine', $this->viewdata );
    }

    //------------------------------------------------------------------------------------------------------------------
    public function details( $element_id ) {
      if( empty( model(Termin_Model::class)->find( $element_id ) ) ) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $this->viewdata['element_id'] = $element_id;

        $this->viewdata['auswertungen'][ 'auswertungen_termin_'.$element_id ] = array(
            'liste' => 'rueckmeldungen',
            'filtern' => array( array( 'operator' => '==', 'eigenschaft' => 'termin_id', 'wert' => $element_id ), ),
            'cluster' => array(
                'liste' => 'mitglieder',
                'eigenschaft' => 'register',
                'filtern' => model(Termin_Model::class)->find( $element_id )['filtern_mitglieder'],
            ),
            // 'sortable' => true,
            'collapse' => true,
        );

        if( auth()->user()->can( 'termine.verwaltung' ) ) {
            $this->viewdata['werkzeugkasten']['aendern'] = array(
                'modal_id' => '#termin_erstellen_Modal',
                'liste' => 'termine',
                'element_id' => $element_id,
                'beschriftung' => 'Termin ändern',
            );
            $this->viewdata['werkzeugkasten']['duplizieren'] = array(
                'modal_id' => '#termin_erstellen_Modal',
                'liste' => 'termine',
                'element_id' => $element_id,
                'beschriftung' => 'Termin duplizieren',
            );
            // $this->viewdata['werkzeugkasten']['loeschen'] = array(
            //     'modal_id' => '#element_loeschen_Modal',
            //     'farbe' => 'danger',
            //     'element' => 'termin',
            //     'element_id' => $element_id,
            //     'beschriftung' => 'Termin löschen',
            // );
        }

        if( auth()->user()->can( 'termine.anwesenheiten' ) ) {
            $this->viewdata['liste']['alle_aktiven'] = array(
                'liste' => 'mitglieder',
                'sortieren' => array(
                    array( 'eigenschaft' => 'nachname', 'richtung' => SORT_ASC, ),
                    array( 'eigenschaft' => 'vorname', 'richtung' => SORT_ASC, ),                
                    array( 'eigenschaft' => 'register', 'richtung' => SORT_ASC, ),                
                    ),
                'filtern' => array( array( 'operator' => '==', 'eigenschaft' => 'aktiv', 'wert' => '1' ), ),
                'beschriftung' => array(
                    'beschriftung' => '<span class="eigenschaft" data-eigenschaft="vorname"></span> <span class="eigenschaft" data-eigenschaft="nachname"></span>',
                ),
                // 'sortable' => true,
                'zusatzsymbole' => '</span><span class="zusatzsymbol" data-zusatzsymbol="abwesend"></span>',
            );
            $this->viewdata['checkliste']['dokumentierte_anwesenheiten'] = array(
                'checkliste' => 'anwesenheiten',
                'aktion' => 'aendern',
                'gegen_element' => 'termin',
                'gegen_element_id' => $element_id,
            );
            $this->viewdata['werkzeugkasten']['anwesenheiten_dokumentieren'] = array(
                'modal_id' => '#termin_anwesenheiten_Modal',
                'liste' => 'mitglieder',
                'beschriftung' => 'Anwesenheiten dokumentieren',
            );
            
            $this->viewdata['liste']['alle_aktiven']['werkzeugkasten_liste']['filtern'] = array(
                'modal_id' => '#liste_filtern_Modal',
                'beschriftung' => 'Mitglieder filtern',
            ); 

            $this->viewdata['liste']['alle_aktiven']['werkzeugkasten_liste']['sortieren'] = array(
                'modal_id' => '#liste_sortieren_Modal',
                'beschriftung' => 'Mitglieder sortieren',
            ); 

        }

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        if( array_key_exists( 'auswertungen', $this->viewdata ) ) foreach( $this->viewdata['auswertungen'] as $id => $auswertungen ) $this->viewdata['auswertungen'][ $id ]['id'] = $id;
        if( array_key_exists( 'checkliste', $this->viewdata ) ) foreach( $this->viewdata['checkliste'] as $id => $checkliste ) $this->viewdata['checkliste'][ $id ]['id'] = $id;
        echo view( 'Termine/termin_details', $this->viewdata );
    }

    //------------------------------------------------------------------------------------------------------------------
    public function ajax_termine() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else {
            $ajax_antwort['tabelle'] = model(Termin_Model::class)->findAll();
            foreach( $ajax_antwort['tabelle'] as $id => $termin ) {
                $ajax_antwort['tabelle'][ $id ] = json_decode( json_encode( $termin ), TRUE );
                foreach( $ajax_antwort['tabelle'][ $id ] as $eigenschaft => $wert ) if( is_numeric( $wert ) ) $ajax_antwort['tabelle'][ $id ][ $eigenschaft ] = (int)$wert;
            }
        }

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_termin_erstellen() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'id' => [ 'label' => 'ID', 'rules' => [ 'if_exist', 'is_natural_no_zero' ] ],
            'titel' => [ 'label' => EIGENSCHAFTEN['termine']['termine']['titel']['beschriftung'], 'rules' => [ 'required' ] ],
            'start' => [ 'label' => EIGENSCHAFTEN['termine']['termine']['start']['beschriftung'], 'rules' => [ 'required', 'valid_date' ] ],
            'ort' => [ 'label' => EIGENSCHAFTEN['termine']['termine']['ort']['beschriftung'], 'rules' => [ 'required' ] ],
            'kategorie' => [ 'label' => EIGENSCHAFTEN['termine']['termine']['kategorie']['beschriftung'], 'rules' => [ 'in_list['.implode( ', ', array_keys( VORGEGEBENE_WERTE['termine']['kategorie'] ) ).']', ] ],
            'filtern_mitglieder' => [ 'label' => EIGENSCHAFTEN['termine']['termine']['filtern_mitglieder']['beschriftung'], 'rules' => [ 'if_exist', 'permit_empty' ] ],
            'bemerkung' => [ 'label' => EIGENSCHAFTEN['termine']['termine']['bemerkung']['beschriftung'], 'rules' => [ 'if_exist', 'permit_empty' ] ],
        );
        if( array_key_exists( 'organisator', EIGENSCHAFTEN['termine']['termine'] ) ) $validation_rules['organisator'] = [ 'label' => EIGENSCHAFTEN['termine']['termine']['organisator']['beschriftung'], 'rules' => [ 'if_exist', 'permit_empty' ] ];
        if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( $this->request->getpost()['start'] < date('Y-m-d H:i:s') ) $ajax_antwort['validation'] = array(
            'start' => 'Der Termin darf nicht in der Vergangenheit liegen.',
        );
        else if( !auth()->user()->can( 'termine.verwaltung' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else {
            $termine_Model = model(Termin_Model::class);
            $termin = array(
                'titel' => $this->request->getpost()['titel'],
                'start' => $this->request->getPost()['start'],
                'ort' => $this->request->getpost()['ort'],
                'kategorie' => $this->request->getpost()['kategorie'],
            );
            if( array_key_exists( 'organisator', EIGENSCHAFTEN['termine']['termine'] ) ) $termin['organisator'] = $this->request->getpost()['organisator'];
            if( array_key_exists( 'filtern_mitglieder', $this->request->getpost() ) ) $termin['filtern_mitglieder'] = json_encode($this->request->getpost()['filtern_mitglieder']);
            else $termin['filtern_mitglieder'] = json_encode( array(), JSON_UNESCAPED_UNICODE );
            if( array_key_exists( 'bemerkung', $this->request->getpost() ) ) $termin['bemerkung'] = $this->request->getpost()['bemerkung'];

            if( !empty( $this->request->getPost()['id'] ) ) $termine_Model->update( $this->request->getpost()['id'], $termin );
            else $termine_Model->save( $termin );
        }

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_termin_loeschen() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'id' => [ 'label' => 'ID', 'rules' => [ 'required', 'is_natural_no_zero' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->user()->can( 'termine.verwaltung' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else {
            model(Termin_Model::class)->delete( $this->request->getPost()['id'] );
            $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        }

        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    //------------------------------------------------------------------------------------------------------------------
    public function ajax_rueckmeldungen() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else {
            $ajax_antwort['tabelle'] = model(Rueckmeldung_Model::class)->findAll();
            foreach( $ajax_antwort['tabelle'] as $id => $rueckmeldung ) {
                $ajax_antwort['tabelle'][ $id ] = json_decode( json_encode( $rueckmeldung ), TRUE );
                foreach( $ajax_antwort['tabelle'][ $id ] as $eigenschaft => $wert ) if( is_numeric( $wert ) ) $ajax_antwort['tabelle'][ $id ][ $eigenschaft ] = (int)$wert;
            }
        }

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_rueckmeldung_erstellen() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'id' => [ 'label' => 'ID', 'rules' => [ 'if_exist', 'is_natural_no_zero' ] ],
            'termin_id' => [ 'label' => EIGENSCHAFTEN['termine']['rueckmeldungen']['termin_id']['beschriftung'], 'rules' => [ 'required', 'is_natural_no_zero' ] ],
            'mitglied_id' => [ 'label' => EIGENSCHAFTEN['termine']['rueckmeldungen']['mitglied_id']['beschriftung'], 'rules' => [ 'required', 'is_natural_no_zero' ] ],
            'status' => [ 'label' => EIGENSCHAFTEN['termine']['rueckmeldungen']['status']['beschriftung'], 'rules' => [ 'required', 'is_natural' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( $this->request->getPost()['mitglied_id'] != ICH['id'] AND !auth()->user()->can( 'mitglieder.verwaltung' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else {
            $rueckmeldungen_Model = model(Rueckmeldung_Model::class);
            $rueckmeldung = array(
                'termin_id' => $this->request->getpost()['termin_id'],
                'mitglied_id' => $this->request->getpost()['mitglied_id'],
                'status' => $this->request->getpost()['status'],
            );
            $rueckmeldungen_Model->save( $rueckmeldung );
        }

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_rueckmeldung_aendern() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'id' => [ 'label' => 'ID', 'rules' => [ 'required', 'is_natural_no_zero' ] ],
            'status' => [ 'label' => EIGENSCHAFTEN['termine']['rueckmeldungen']['status']['beschriftung'], 'rules' => [ 'if_exist', 'is_natural' ] ],
            'bemerkung' => [ 'label' => EIGENSCHAFTEN['termine']['rueckmeldungen']['bemerkung']['beschriftung'], 'rules' => [ 'if_exist', 'permit_empty' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( model(Rueckmeldung_Model::class)->find( $this->request->getpost()['id'] )['mitglied_id'] != ICH['id'] AND !auth()->user()->can( 'mitglieder.verwaltung' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else {
            $rueckmeldungen_Model = model(Rueckmeldung_Model::class);
            $rueckmeldung = array();
            if( array_key_exists( 'bemerkung', $this->request->getPost() ) ) $rueckmeldung['bemerkung'] = $this->request->getpost()['bemerkung'];
            if( array_key_exists( 'status', $this->request->getPost() ) ) $rueckmeldung['status'] = $this->request->getpost()['status'];
            $rueckmeldungen_Model->update( $this->request->getpost()['id'], $rueckmeldung );
        }

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }
    
    //------------------------------------------------------------------------------------------------------------------
    public function ajax_anwesenheiten() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else {
            $ajax_antwort['tabelle'] = model(Anwesenheit_Model::class)->findAll();
            foreach( $ajax_antwort['tabelle'] as $id => $anwesenheit ) {
                $ajax_antwort['tabelle'][ $id ] = json_decode( json_encode( $anwesenheit ), TRUE );
                foreach( $ajax_antwort['tabelle'][ $id ] as $eigenschaft => $wert ) if( is_numeric( $wert ) ) $ajax_antwort['tabelle'][ $id ][ $eigenschaft ] = (int)$wert;
            }
        }

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_anwesenheit_aendern() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'termin_id' => [ 'label' => EIGENSCHAFTEN['termine']['anwesenheiten']['termin_id']['beschriftung'], 'rules' => [ 'required', 'is_natural_no_zero' ] ],
            'mitglied_id' => [ 'label' => EIGENSCHAFTEN['termine']['anwesenheiten']['mitglied_id']['beschriftung'], 'rules' => [ 'required', 'is_natural_no_zero' ] ],
            'checked' => [ 'label' => 'Checked', 'rules' => [ 'required', 'in_list[ true, false ]' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->user()->can( 'termine.anwesenheiten' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else {
            $anwesenheiten_Model = model(Anwesenheit_Model::class);
            $anwesenheit = array(
                'termin_id' => $this->request->getpost()['termin_id'],
                'mitglied_id' => $this->request->getpost()['mitglied_id'],
            );
            $anwesenheiten_Model->where( $anwesenheit )->delete();
            if( filter_var( $this->request->getpost()['checked'], FILTER_VALIDATE_BOOLEAN) ) $anwesenheiten_Model->save( $anwesenheit );
        }
        
        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

}
