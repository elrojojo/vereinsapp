<?php

namespace App\Controllers;
use App\Models\Mitglieder\Mitglied_Model;
use App\Models\Mitglieder\Mitglieder_Abwesenheit_Model as Abwesenheit_Model;
use CodeIgniter\Shield\Entities\User as Mitglied;

class Mitglieder extends BaseController {

    public function mitglieder() {

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
                'beschriftung' => '',
                // 'klein' => true,
                // 'zentriert' => true,
                'abschneiden' => true,
            ),
            'zusatzsymbole' => '<span class="zusatzsymbol" data-zusatzsymbol="geburtstag"></span><span class="zusatzsymbol" data-zusatzsymbol="abwesend"></span>',
        );
        foreach( MITGLIEDER_EIGENSCHAFTEN_VORSCHAU as $vorschau ) $this->viewdata['liste']['alle_aktiven']['vorschau']['beschriftung'] .= '<span class="eigenschaft" data-eigenschaft="'.$vorschau.'"></span><i class="bi bi-dot spacer"></i>';

        if( auth()->user()->can( 'mitglieder.verwaltung' ) ) {
            $this->viewdata['liste']['alle_aktiven']['werkzeugkasten']['loeschen'] = array(
                'modal_id' => '#element_loeschen_Modal',
                'farbe' => 'danger',
            );
            $this->viewdata['liste']['alle_aktiven']['werkzeugkasten']['duplizieren'] = array(
                'modal_id' => '#mitglied_erstellen_Modal',
            );
            $this->viewdata['liste']['alle_aktiven']['werkzeugkasten']['aendern'] = array(
                'modal_id' => '#mitglied_erstellen_Modal',
            );

            $this->viewdata['werkzeugkasten']['erstellen'] = array(
                'modal_id' => '#mitglied_erstellen_Modal',
                'element' => 'mitglied',
                'beschriftung' => 'Mitglied erstellen',
            ); 
        }

        $this->viewdata['werkzeugkasten']['sortieren'] = array(
            'modal_id' => '#liste_sortieren_Modal',
            'liste' => 'mitglieder',
            'beschriftung' => 'Mitglieder sortieren',
        );

        $this->viewdata['werkzeugkasten']['filtern'] = array(
            'modal_id' => '#liste_filtern_Modal',
            'liste' => 'mitglieder',
            'beschriftung' => 'Mitglieder filtern',
        );

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        echo view( 'Mitglieder/mitglieder', $this->viewdata );
    }

    //------------------------------------------------------------------------------------------------------------------
    public function details( $element_id ) {
      if( empty( model(Mitglied_Model::class)->find( $element_id ) ) ) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $this->viewdata['element_id'] = $element_id;
        
        if( auth()->user()->can( 'mitglieder.verwaltung' ) ) {
          $this->viewdata['liste']['abwesenheiten_des_mitglieds'] = array(
              'liste' => 'abwesenheiten',
              'sortieren' => array(
                  array( 'eigenschaft' => 'start', 'richtung' => SORT_ASC, ),
                  array( 'eigenschaft' => 'ende', 'richtung' => SORT_ASC, ),                
              ),
              'filtern' => array( array( 'operator' => '==', 'eigenschaft' => 'mitglied_id', 'wert' => $element_id ), ),
              'beschriftung' => array(
                  'beschriftung' => '<span class="eigenschaft" data-eigenschaft="start"></span> - <span class="eigenschaft" data-eigenschaft="ende"></span>',
              ),
              'modal' => array(
                  'target' => '#element_loeschen_Modal',
                  'aktion' => 'loeschen',
              ),
              'symbol' => array(
                  'symbol' => SYMBOLE['loeschen']['bootstrap'],
                  'farbe' => 'danger',
              ),
              'vorschau' => array(
                  'beschriftung' => '<span class="eigenschaft" data-eigenschaft="bemerkung"></span>',
                  'klein' => true,
                  'abschneiden' => true,
              ),
          );
        }
        
        if( auth()->user()->can( 'mitglieder.verwaltung' ) ) {

            if( auth()->user()->can( 'mitglieder.rechte' ) ) $this->viewdata['check_liste']['rechte'] = array(
                'check_liste' => 'permissions',
                'aktion' => 'aendern',
                'gegen_element' => 'mitglied',
                'gegen_element_id' => $element_id,
            );

            $this->viewdata['werkzeugkasten']['aendern'] = array(
                'modal_id' => '#mitglied_erstellen_Modal',
                'element' => 'mitglied',
                'element_id' => $element_id,
                'beschriftung' => 'Mitglied ändern',
            );
            $this->viewdata['werkzeugkasten']['duplizieren'] = array(
                'modal_id' => '#mitglied_erstellen_Modal',
                'element' => 'mitglied',
                'element_id' => $element_id,
                'beschriftung' => 'Mitglied duplizieren',
            );
            // $this->viewdata['werkzeugkasten']['loeschen'] = array(
            //     'modal_id' => '#element_loeschen_Modal',
            //     'farbe' => 'danger',
            //     'element' => 'mitglied',
            //     'element_id' => $element_id,
            //     'beschriftung' => 'Mitglied löschen',
            // ); 
        }

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        if( array_key_exists( 'check_liste', $this->viewdata ) ) foreach( $this->viewdata['check_liste'] as $id => $check_liste ) $this->viewdata['check_liste'][ $id ]['id'] = $id;
        echo view( 'Mitglieder/mitglied_details', $this->viewdata );
    }
    //------------------------------------------------------------------------------------------------------------------
    public function ajax_mitglieder() { $ajax_antwort = array( 'csrf_hash' => csrf_hash(), 'tabelle' => array() );
        // if( !$this->validate( [
        //     'hash' => 'required|alpha_numeric',
        // ] ) ) $ajax_antwort['validation'] = $this->validation->listErrors();
        // else {
            foreach( model(Mitglied_Model::class)->findAll() as $mitglied ) {
                $mitglied->permissions = array();
                if( auth()->user()->can( 'mitglieder.rechte' ) ) $mitglied->permissions = $mitglied->getPermissions();
                elseif( $mitglied->id == ICH['id'] ) $mitglied->permissions = $mitglied->getPermissions();
                $email = $mitglied->email;
                $mitglied = json_decode( json_encode( $mitglied ), TRUE );
                $mitglied['email'] = $email;
                foreach( $mitglied as $eigenschaft => $wert ) if( is_numeric( $wert ) ) $mitglied[ $eigenschaft ] = (int)$wert;
                $ajax_antwort['tabelle'][] = $mitglied;
            }
        //     if( hash( 'sha256', json_encode( $ajax_antwort['tabelle'], JSON_UNESCAPED_UNICODE ) ) == $this->request->getPost()['hash'] ) TRUE; //$ajax_antwort['tabelle'] = array();
        // }
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_mitglied_erstellen() { $ajax_antwort['csrf_hash'] = csrf_hash();
        $validation_rules = array(
            'id' => [ 'label' => 'ID', 'rules' => [ 'if_exist', 'is_natural_no_zero' ] ],
            'email' => [ 'label' => EIGENSCHAFTEN['mitglieder']['mitglieder']['email']['beschriftung'], 'rules' => [ 'required', 'valid_email' ] ],
            'vorname' => [ 'label' => EIGENSCHAFTEN['mitglieder']['mitglieder']['vorname']['beschriftung'], 'rules' => [ 'required' ] ],
            'nachname' => [ 'label' => EIGENSCHAFTEN['mitglieder']['mitglieder']['nachname']['beschriftung'], 'rules' => [ 'required' ] ],
            'geburt' => [ 'label' => EIGENSCHAFTEN['mitglieder']['mitglieder']['geburt']['beschriftung'], 'rules' => [ 'required', 'valid_date' ] ],
            'geschlecht' => [ 'label' => EIGENSCHAFTEN['mitglieder']['mitglieder']['geschlecht']['beschriftung'], 'rules' => [ 'in_list['.implode( ', ', array_keys( VORGEGEBENE_WERTE['mitglieder']['geschlecht'] ) ).']', ] ],
            'postleitzahl' => [ 'label' => EIGENSCHAFTEN['mitglieder']['mitglieder']['postleitzahl']['beschriftung'], 'rules' => [ 'required', 'is_natural_no_zero', 'greater_than_equal_to[10000]', 'less_than_equal_to[99999]', ] ],
            'wohnort' => [ 'label' => EIGENSCHAFTEN['mitglieder']['mitglieder']['wohnort']['beschriftung'], 'rules' => [ 'required' ] ],
            'register' => [ 'label' => EIGENSCHAFTEN['mitglieder']['mitglieder']['register']['beschriftung'], 'rules' => [ 'in_list['.implode( ', ', array_keys( VORGEGEBENE_WERTE['mitglieder']['register'] ) ).']', ] ],
            'funktion' => [ 'label' => EIGENSCHAFTEN['mitglieder']['mitglieder']['funktion']['beschriftung'], 'rules' => [ 'in_list['.implode( ', ', array_keys( VORGEGEBENE_WERTE['mitglieder']['funktion'] ) ).']', ] ],
            'vorstandschaft' => [ 'label' => EIGENSCHAFTEN['mitglieder']['mitglieder']['vorstandschaft']['beschriftung'], 'rules' => [ 'in_list['.implode( ', ', array_keys( VORGEGEBENE_WERTE['mitglieder']['vorstandschaft'] ) ).']', ] ],
            'aktiv' => [ 'label' => EIGENSCHAFTEN['mitglieder']['mitglieder']['aktiv']['beschriftung'], 'rules' => [ 'in_list['.implode( ', ', array_keys( VORGEGEBENE_WERTE['mitglieder']['aktiv'] ) ).']', ] ],
        );
        if( !empty( $this->request->getPost()['id'] ) ) $validation_rules['email']['rules'][] = 'is_unique[mitglieder_zugaenge.secret, user_id, '.$this->request->getPost()['id'].']';
        else $validation_rules['email']['rules'][] = 'is_unique[mitglieder_zugaenge.secret]';

        if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->user()->can( 'mitglieder.verwaltung' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else {
            $mitglieder_Model = model(Mitglied_Model::class);
            $mitglied = array(
                'username' => NULL,
                'email' => $this->request->getPost()['email'],
                'vorname' => $this->request->getpost()['vorname'],
                'nachname' => $this->request->getpost()['nachname'],
                'geburt' => $this->request->getPost()['geburt'],
                'geschlecht' => $this->request->getpost()['geschlecht'],
                'postleitzahl' => $this->request->getpost()['postleitzahl'],
                'wohnort' => $this->request->getpost()['wohnort'],
                'register' => $this->request->getpost()['register'],
                'funktion' => $this->request->getpost()['funktion'],
                'vorstandschaft' => $this->request->getPost()['vorstandschaft'],
                'aktiv' => $this->request->getPost()['aktiv'],
            );
            if( !empty( $this->request->getPost()['id'] ) ) {
                $mitglied = $mitglieder_Model->findById( $this->request->getPost()['id'] )->fill($mitglied);
                $mitglieder_Model->save( $mitglied );
            } else {
                $mitglied['password'] = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10/strlen($x)) )),1,10);//'secret plain text password',
                // $mitglied['password'] = 'test';
                $mitglieder_Model->save( new Mitglied( $mitglied ) );
                $mitglieder_Model->addToDefaultGroup( $mitglieder_Model->findById( $mitglieder_Model->getInsertID() ) );
            }
        }
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_mitglied_passwort_aendern() { $ajax_antwort['csrf_hash'] = csrf_hash();
        $validation_rules = array(
            'id' => [ 'label' => 'ID', 'rules' => [ 'required', 'is_natural_no_zero' ] ],
            'passwort_alt' => [ 'label' => 'Altes Passwort', 'rules' => [ 'required' ] ],
            'passwort_neu' => [ 'label' => 'Neues Passwort', 'rules' => [ 'required', 'strong_password' ] ],
            'passwort_neu2' => [ 'label' => 'Neues Passwort (Wiederholung)', 'rules' => [ 'required', 'matches[passwort_neu]' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->check( array( 'email' => model(Mitglied_Model::class)->findById( ICH['id'] )->email, 'password' => $this->request->getpost()['passwort_alt'] ) )->isOK() ) $ajax_antwort['validation'] = array( 'passwort_alt' => 'Das alte Passwort ist nicht korrekt.' );
        else {
            $mitglieder_Model = model(Mitglied_Model::class);
            $mitglied = array(
                'password' => $this->request->getpost()['passwort_neu'],
            );
            if( empty( $this->request->getPost()['id'] ) ) $mitglied_id = ICH['id']; else $mitglied_id = $this->request->getPost()['id']; 
            $mitglied = $mitglieder_Model->findById( $mitglied_id )->fill($mitglied);
            $mitglieder_Model->save( $mitglied );
        }
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_mitglied_permission_aendern() { $ajax_antwort['csrf_hash'] = csrf_hash();
        $validation_rules = array(
            'permission_id' => [ 'label' => 'Recht', 'rules' => [ 'required', 'alpha_numeric_punct' ] ],
            'mitglied_id' => [ 'label' => 'ID', 'rules' => [ 'if_exist', 'is_natural_no_zero' ] ],
            'checked' => [ 'label' => 'Checked', 'rules' => [ 'required', 'in_list[ true, false ]' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->user()->can( 'mitglieder.rechte' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else {
            if( empty( $this->request->getPost()['mitglied_id'] ) ) $mitglied_id = ICH['id']; else $mitglied_id = $this->request->getPost()['mitglied_id'];
            model(Mitglied_Model::class)->findById( $mitglied_id )->removePermission( $this->request->getPost()['permission_id'] );
            if( filter_var( $this->request->getpost()['checked'], FILTER_VALIDATE_BOOLEAN) ) model(Mitglied_Model::class)->findById( $mitglied_id )->addPermission( $this->request->getPost()['permission_id'] );
        }
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_mitglied_loeschen() { $ajax_antwort['csrf_hash'] = csrf_hash();
        $validation_rules = array(
            'id' => [ 'label' => 'ID', 'rules' => [ 'required', 'is_natural_no_zero' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !auth()->user()->can( 'mitglieder.verwaltung' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else if( $this->request->getPost()['id'] == $this->session->user['id'] ) $ajax_antwort['validation'] = 'Du kannst dich nicht selbst löschen!';
        else model(Mitglied_Model::class)->delete( $this->request->getPost()['id'], true );
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    //------------------------------------------------------------------------------------------------------------------
    public function ajax_abwesenheiten() { $ajax_antwort = array( 'csrf_hash' => csrf_hash(), 'tabelle' => array() );
        foreach( model(Abwesenheit_Model::class)->findAll() as $abwesenheit ) {
            $abwesenheit = json_decode( json_encode( $abwesenheit ), TRUE );
            foreach( $abwesenheit as $eigenschaft => $wert ) if( is_numeric( $wert ) ) $abwesenheit[ $eigenschaft ] = (int)$wert;
            $ajax_antwort['tabelle'][] = $abwesenheit;
        }
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_abwesenheit_erstellen() { $ajax_antwort['csrf_hash'] = csrf_hash();
        $validation_rules = array(
            // 'id' => [ 'label' => 'ID', 'rules' => [ 'if_exist', 'is_natural_no_zero' ] ],
            'mitglied_id' => [ 'label' => EIGENSCHAFTEN['mitglieder']['abwesenheiten']['mitglied_id']['beschriftung'], 'rules' => [ 'if_exist', 'is_natural_no_zero' ] ],
            'start' => [ 'label' => EIGENSCHAFTEN['mitglieder']['abwesenheiten']['start']['beschriftung'], 'rules' => [ 'required', 'valid_date' ] ],
            'ende' => [ 'label' => EIGENSCHAFTEN['mitglieder']['abwesenheiten']['ende']['beschriftung'], 'rules' => [ 'required', 'valid_date' ] ],
            'bemerkung' => [ 'label' => EIGENSCHAFTEN['mitglieder']['abwesenheiten']['bemerkung']['beschriftung'], 'rules' => [ 'if_exist', 'permit_empty' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !empty( $this->request->getPost()['mitglied_id'] ) AND $this->request->getPost()['mitglied_id'] != $this->session->user['id'] AND !auth()->user()->can( 'mitglieder.verwaltung' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else if( $this->request->getpost()['start'] > $this->request->getpost()['ende'] ) $ajax_antwort['validation'] = array(
            'start' => EIGENSCHAFTEN['mitglieder']['abwesenheiten']['start']['beschriftung'].' muss zeitlich vor '.EIGENSCHAFTEN['mitglieder']['abwesenheiten']['ende']['beschriftung'].' liegen.',
            'ende' => EIGENSCHAFTEN['mitglieder']['abwesenheiten']['ende']['beschriftung'].' muss zeitlich vor '.EIGENSCHAFTEN['mitglieder']['abwesenheiten']['start']['beschriftung'].' liegen.',
        );
        else {
            $abwesenheit_Model = model(Abwesenheit_Model::class);
            $abwesenheit = array(
                'start' => $this->request->getpost()['start'],
                'ende' => $this->request->getpost()['ende'],
                'bemerkung' => $this->request->getpost()['bemerkung'],
            );
            if( !empty( $this->request->getPost()['mitglied_id'] ) ) $abwesenheit['mitglied_id'] = $this->request->getPost()['mitglied_id']; else $abwesenheit['mitglied_id'] = $this->session->user['id'];

            // if( !empty( $this->request->getPost()['id'] ) ) $abwesenheit_Model->update( $this->request->getpost()['id'], $abwesenheit );
            // else
                $abwesenheit_Model->save( $abwesenheit );
        }
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_abwesenheit_loeschen() { $ajax_antwort['csrf_hash'] = csrf_hash();
        $validation_rules = array(
            'id' => [ 'label' => 'ID', 'rules' => [ 'required', 'is_natural_no_zero' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( model(Abwesenheit_Model::class)->find( $this->request->getPost()['id'] )['mitglied_id'] != $this->session->user['id'] AND !auth()->user()->can( 'mitglieder.verwaltung' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else model(Abwesenheit_Model::class)->delete( $this->request->getPost()['id'], true );
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

}
