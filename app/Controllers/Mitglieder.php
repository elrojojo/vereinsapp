<?php

namespace App\Controllers;
use App\Models\Mitglieder\Mitglied_Model;
use App\Models\Mitglieder\Mitglieder_Abwesenheit_Model as Abwesenheit_Model;
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
                'h5' => true,
            ),
            // 'sortable' => true,
            'link' => site_url().AKTIVER_CONTROLLER, // ODER 'modal' => array( // ODER 
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
        foreach( config('Vereinsapp')->mitglieder_eigenschaften_vorschau as $vorschau ) $this->viewdata['liste']['alle_mitglieder']['vorschau']['beschriftung'] .= '<span class="eigenschaft" data-eigenschaft="'.$vorschau.'"></span><i class="bi bi-dot spacer"></i>';

        if( auth()->user()->can( 'mitglieder.verwaltung' ) ) {
            $this->viewdata['liste']['alle_mitglieder']['werkzeugkasten'] = TRUE;

            $this->viewdata['werkzeugkasten']['einmal_link_anzeigen'] = array(
                'modal_id' => '#mitglied_einmal_link_anzeigen_Modal',
                'liste' => 'mitglieder',
                'title' => 'Einmal-Link erstellen und anzeigen',
            );
            $this->viewdata['werkzeugkasten']['einmal_link_email'] = array(
                'modal_id' => '#mitglied_einmal_link_email_Modal',
                'liste' => 'mitglieder',
                'title' => 'Einmal-Link per Email zuschicken',
            );
                        
            $this->viewdata['werkzeugkasten']['aendern'] = array(
                'modal_id' => '#mitglied_erstellen_Modal',
                'liste' => 'mitglieder',
                'title' => 'Mitglied ändern',
            );
            $this->viewdata['werkzeugkasten']['duplizieren'] = array(
                'modal_id' => '#mitglied_erstellen_Modal',
                'liste' => 'mitglieder',
                'title' => 'Mitglied duplizieren',
            );
            $this->viewdata['werkzeugkasten']['loeschen'] = array(
                'modal_id' => '#element_loeschen_Modal',
                'liste' => 'mitglieder',
                'title' => 'Mitglied löschen',
                'farbe' => 'danger',
            );

            $this->viewdata['liste']['alle_mitglieder']['werkzeugkasten_liste']['erstellen'] = array(
                'modal_id' => '#mitglied_erstellen_Modal',
                'title' => 'Mitglied erstellen',
            ); 
        }

        $this->viewdata['liste']['alle_mitglieder']['werkzeugkasten_liste']['filtern'] = array(
            'modal_id' => '#liste_filtern_Modal',
            'title' => 'Mitglieder filtern',
        );

        $this->viewdata['liste']['alle_mitglieder']['werkzeugkasten_liste']['sortieren'] = array(
            'modal_id' => '#liste_sortieren_Modal',
            'title' => 'Mitglieder sortieren',
        );

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        echo view( 'Mitglieder/mitglieder', $this->viewdata );
    }

    //------------------------------------------------------------------------------------------------------------------
    public function details( $element_id ) {
      if( empty( model(Mitglied_Model::class)->find( $element_id ) ) ) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $this->viewdata['element_id'] = $element_id;

        $elemente_disabled = array();
        if( !auth()->user()->can( 'termine.anwesenheiten' ) ) foreach( model(Termin_Model::class)->findAll() as $termin ) $elemente_disabled[] = (int)$termin['id'];
        $this->viewdata['liste']['anwesenheiten_dokumentieren'] = array(
            'liste' => 'termine',
            // 'filtern' => array( array( 'operator' => '==', 'eigenschaft' => 'aktiv', 'wert' => '1' ), ),
            'sortieren' => array(
                array( 'eigenschaft' => 'start', 'richtung' => SORT_ASC, ),             
            ),
            'beschriftung' => array(
                'beschriftung' => '<span class="eigenschaft" data-eigenschaft="start"></span> <span class="eigenschaft" data-eigenschaft="titel"></span>',
            ),
            // 'sortable' => true,
            'zusatzsymbole' => '<span class="zusatzsymbol" data-zusatzsymbol="kategorie"></span>',
            'checkliste' => array(
                'checkliste' => 'anwesenheiten',
                'aktion' => 'aendern',
                'gegen_liste' => 'mitglieder',
                'bedingte_formatierung' => array(
                    'liste' => 'rueckmeldungen',
                    'klasse' => array(
                        'text-success' => array( 'operator' => '==', 'eigenschaft' => 'status', 'wert' => '1' ),
                        'text-danger' => array( 'operator' => '==', 'eigenschaft' => 'status', 'wert' => '0' ),
                    ),
                ),
                'elemente_disabled' => $elemente_disabled,
            ),
        );

        $this->viewdata['liste']['anwesenheiten_dokumentieren']['werkzeugkasten_liste']['filtern'] = array(
            'modal_id' => '#liste_filtern_Modal',
            'title' => 'Mitglieder filtern',
        );

        $this->viewdata['liste']['anwesenheiten_dokumentieren']['werkzeugkasten_liste']['sortieren'] = array(
            'modal_id' => '#liste_sortieren_Modal',
            'title' => 'Mitglieder sortieren',
        );

        $this->viewdata['werkzeugkasten']['anwesenheiten_dokumentieren'] = array(
            'modal_id' => '#termin_anwesenheiten_Modal',
            'liste' => 'termine',
            'title' => 'Anwesenheiten dokumentieren',
        );
        
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

            if( auth()->user()->can( 'mitglieder.rechte' ) ) {
                $elemente_disabled = array();
                $elemente_disabled[] = VERFUEGBARE_RECHTE['global.einstellungen']['id'];
                if( !auth()->user()->can( 'global.einstellungen' ) ) $elemente_disabled[] = VERFUEGBARE_RECHTE['mitglieder.rechte']['id'];
                if( !auth()->user()->can( 'mitglieder.rechte' ) ) foreach( VERFUEGBARE_RECHTE as $verfuegbares_recht ) if( $verfuegbares_recht['permission'] != 'global.einstellungen' AND $verfuegbares_recht['permission'] != 'mitglieder.rechte' ) $elemente_disabled[] = $verfuegbares_recht['id'];
                $this->viewdata['liste']['rechte_vergeben'] = array(
                    'liste' => 'verfuegbare_rechte',
                    'beschriftung' => array(
                        'beschriftung' => '<span class="eigenschaft" data-eigenschaft="beschriftung">',
                    ),
                    'checkliste' => array(
                        'checkliste' => 'vergebene_rechte',
                        'aktion' => 'aendern',
                        'gegen_liste' => 'mitglieder',
                        'gegen_element_id' => $element_id,
                        'elemente_disabled' => $elemente_disabled,
                    ),
                );
            }

            $this->viewdata['liste']['bevorstehende_termine'] = array(
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
                'link' => site_url().'termine',
                'symbol' => array(
                    'symbol' => SYMBOLE['info']['bootstrap'],
                ),
                'vorschau' => array(
                    'beschriftung' => '<div class="row g-0 my-1">
                        <div class="col nowrap"><i class="bi bi-calendar-event"></i> <span class="eigenschaft" data-eigenschaft="start"></span></div>
                        </div>'.view( 'Termine/rueckmeldung_erstellen', array( 'mitglied_id' => $element_id ) ),
                    'klein' => true,
                ),
                'zusatzsymbole' => '<span class="zusatzsymbol" data-zusatzsymbol="kategorie"></span>',
            );

            $this->viewdata['werkzeugkasten']['einmal_link_anzeigen'] = array(
                'modal_id' => '#mitglied_einmal_link_anzeigen_Modal',
                'liste' => 'mitglieder',
                'title' => 'Einmal-Link erstellen und anzeigen',
            );
            $this->viewdata['werkzeugkasten']['einmal_link_email'] = array(
                'modal_id' => '#mitglied_einmal_link_email_Modal',
                'liste' => 'mitglieder',
                'title' => 'Einmal-Link per Email zuschicken',
            );
                        
            $this->viewdata['werkzeugkasten']['aendern'] = array(
                'modal_id' => '#mitglied_erstellen_Modal',
                'liste' => 'mitglieder',
                'title' => 'Mitglied ändern',
            );
            $this->viewdata['werkzeugkasten']['duplizieren'] = array(
                'modal_id' => '#mitglied_erstellen_Modal',
                'liste' => 'mitglieder',
                'title' => 'Mitglied duplizieren',
            );
            $this->viewdata['werkzeugkasten']['loeschen'] = array(
                'modal_id' => '#element_loeschen_Modal',
                'liste' => 'mitglieder',
                'title' => 'Mitglied löschen',
                'farbe' => 'danger',
                'weiterleiten' => 'mitglieder',
            );
        }

        $this->viewdata['element_navigation'] = array(
            'instanz' => 'alle_mitglieder',
            // 'filtern' => array( array( 'operator' => '==', 'eigenschaft' => 'aktiv', 'wert' => '1' ), ),
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
                    'geschlecht' => $mitglied_->geschlecht,
                    'postleitzahl' => $mitglied_->postleitzahl,
                    'wohnort' => $mitglied_->wohnort,
                    'register' => $mitglied_->register,
                    'funktion' => $mitglied_->funktion,
                    'vorstandschaft' => $mitglied_->vorstandschaft,
                    'aktiv' => $mitglied_->aktiv,
                );
                if( auth()->user()->can( 'mitglieder.verwaltung' ) ) {
                    // $mitglied = json_decode( json_encode( $mitglied ), TRUE );
                    $mitglied['email'] = $mitglied_->email;
                    $mitglied['erstellung'] = $mitglied_->created_at;
                    if( $mitglied['erstellung'] != NULL ) $mitglied['erstellung'] = $mitglied['erstellung']->setTimezone('Europe/Berlin')->toDateTimeString();
                    $mitglied['letzte_aktivitaet'] = $mitglied_->last_active;
                    if( $mitglied['letzte_aktivitaet'] != NULL ) $mitglied['letzte_aktivitaet'] = $mitglied['letzte_aktivitaet']->setTimezone('Europe/Berlin')->toDateTimeString();
                }

                foreach( $mitglied as $eigenschaft => $wert ) if( is_numeric( $wert ) ) $mitglied[ $eigenschaft ] = (int)$wert;
                $ajax_antwort['tabelle'][] = $mitglied;
            }
            // if( hash( 'sha256', json_encode( $ajax_antwort['tabelle'], JSON_UNESCAPED_UNICODE ) ) == $this->request->getPost()['hash'] ) TRUE; //$ajax_antwort['tabelle'] = array();

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_mitglied_erstellen() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'id' => [ 'label' => 'ID', 'rules' => [ 'if_exist', 'is_natural_no_zero' ] ],
            'email' => [ 'label' => EIGENSCHAFTEN['mitglieder']['email']['beschriftung'], 'rules' => [ 'required', 'valid_email' ] ],
            'vorname' => [ 'label' => EIGENSCHAFTEN['mitglieder']['vorname']['beschriftung'], 'rules' => [ 'required' ] ],
            'nachname' => [ 'label' => EIGENSCHAFTEN['mitglieder']['nachname']['beschriftung'], 'rules' => [ 'required' ] ],
            'geburt' => [ 'label' => EIGENSCHAFTEN['mitglieder']['geburt']['beschriftung'], 'rules' => [ 'required', 'valid_date' ] ],
            'geschlecht' => [ 'label' => EIGENSCHAFTEN['mitglieder']['geschlecht']['beschriftung'], 'rules' => [ 'in_list['.implode( ', ', array_keys( VORGEGEBENE_WERTE['mitglieder']['geschlecht'] ) ).']', ] ],
            'postleitzahl' => [ 'label' => EIGENSCHAFTEN['mitglieder']['postleitzahl']['beschriftung'], 'rules' => [ 'required', 'is_natural_no_zero', 'greater_than_equal_to[10000]', 'less_than_equal_to[99999]', ] ],
            'wohnort' => [ 'label' => EIGENSCHAFTEN['mitglieder']['wohnort']['beschriftung'], 'rules' => [ 'required' ] ],
            'register' => [ 'label' => EIGENSCHAFTEN['mitglieder']['register']['beschriftung'], 'rules' => [ 'in_list['.implode( ', ', array_keys( VORGEGEBENE_WERTE['mitglieder']['register'] ) ).']', ] ],
            'funktion' => [ 'label' => EIGENSCHAFTEN['mitglieder']['funktion']['beschriftung'], 'rules' => [ 'in_list['.implode( ', ', array_keys( VORGEGEBENE_WERTE['mitglieder']['funktion'] ) ).']', ] ],
            'vorstandschaft' => [ 'label' => EIGENSCHAFTEN['mitglieder']['vorstandschaft']['beschriftung'], 'rules' => [ 'in_list['.implode( ', ', array_keys( VORGEGEBENE_WERTE['mitglieder']['vorstandschaft'] ) ).']', ] ],
            'aktiv' => [ 'label' => EIGENSCHAFTEN['mitglieder']['aktiv']['beschriftung'], 'rules' => [ 'in_list['.implode( ', ', array_keys( VORGEGEBENE_WERTE['mitglieder']['aktiv'] ) ).']', ] ],
        ); if( !empty( $this->request->getPost()['id'] ) ) $validation_rules['email']['rules'][] = 'is_unique[mitglieder_zugaenge.secret,user_id,{id}]';
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
                helper('text'); $mitglied['password'] = random_string('crypto', 20);
                $mitglieder_Model->save( new Mitglied( $mitglied ) );
                $ajax_antwort['element_id'] = (int)$mitglieder_Model->getInsertID();
                $mitglieder_Model->addToDefaultGroup( $mitglieder_Model->findById( $ajax_antwort['element_id'] ) );
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
        else {
            $mitglieder_Model = model(Mitglied_Model::class);
            $mitglied = array(
                'password' => $this->request->getpost()['passwort_neu'],
            );
            if( empty( $this->request->getPost()['id'] ) ) $mitglied_id = ICH['id']; else $mitglied_id = $this->request->getPost()['id']; 
            $mitglied = $mitglieder_Model->findById( $mitglied_id )->fill($mitglied);
            $mitglieder_Model->save( $mitglied );

            $mitglied->undoForcePasswordReset();
        }

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_mitglied_passwort_festlegen_modal() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else $ajax_antwort['html'] = view( 'Mitglieder/passwort_festlegen_modal', $this->viewdata );
        
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
        $email = emailer()->setFrom(setting('Email.fromEmail'), config('vereinsapp')->verein_name ?? '');
        $email->setTo($user->email);
        $email->setSubject(config('vereinsapp')->vereinsapp_name.' - Einmal-Link');
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
            'email' => [ 'label' => 'Per Email verschicken', 'rules' => [ 'if_exist', 'permit_empty', 'in_list[ true, false ]' ] ],
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
                if( !empty( $this->request->getPost()['email'] ) && filter_var( $this->request->getpost()['email'], FILTER_VALIDATE_BOOLEAN) )
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
        else model(Mitglied_Model::class)->delete( $this->request->getPost()['id'], true );

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    //------------------------------------------------------------------------------------------------------------------
    public function ajax_abwesenheiten() { $ajax_antwort = array( CSRF_NAME => csrf_hash(), 'tabelle' => array() );
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else foreach( model(Abwesenheit_Model::class)->findAll() as $abwesenheit ) {
                $abwesenheit = json_decode( json_encode( $abwesenheit ), TRUE );
                foreach( $abwesenheit as $eigenschaft => $wert ) if( is_numeric( $wert ) ) $abwesenheit[ $eigenschaft ] = (int)$wert;
                $ajax_antwort['tabelle'][] = $abwesenheit;
            }
        
        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_abwesenheit_erstellen() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            // 'id' => [ 'label' => 'ID', 'rules' => [ 'if_exist', 'is_natural_no_zero' ] ],
            'mitglied_id' => [ 'label' => EIGENSCHAFTEN['abwesenheiten']['mitglied_id']['beschriftung'], 'rules' => [ 'if_exist', 'is_natural_no_zero' ] ],
            'start' => [ 'label' => EIGENSCHAFTEN['abwesenheiten']['start']['beschriftung'], 'rules' => [ 'required', 'valid_date' ] ],
            'ende' => [ 'label' => EIGENSCHAFTEN['abwesenheiten']['ende']['beschriftung'], 'rules' => [ 'required', 'valid_date' ] ],
            'bemerkung' => [ 'label' => EIGENSCHAFTEN['abwesenheiten']['bemerkung']['beschriftung'], 'rules' => [ 'if_exist', 'permit_empty' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( !empty( $this->request->getPost()['mitglied_id'] ) AND $this->request->getPost()['mitglied_id'] != ICH['id'] AND !auth()->user()->can( 'mitglieder.verwaltung' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else if( $this->request->getpost()['start'] > $this->request->getpost()['ende'] ) $ajax_antwort['validation'] = array(
            'start' => EIGENSCHAFTEN['abwesenheiten']['start']['beschriftung'].' muss zeitlich vor '.EIGENSCHAFTEN['abwesenheiten']['ende']['beschriftung'].' liegen.',
            'ende' => EIGENSCHAFTEN['abwesenheiten']['ende']['beschriftung'].' muss zeitlich vor '.EIGENSCHAFTEN['abwesenheiten']['start']['beschriftung'].' liegen.',
        );
        else {
            $abwesenheit_Model = model(Abwesenheit_Model::class);
            $abwesenheit = array(
                'start' => $this->request->getpost()['start'],
                'ende' => $this->request->getpost()['ende'],
                'bemerkung' => $this->request->getpost()['bemerkung'],
            );
            if( !empty( $this->request->getPost()['mitglied_id'] ) ) $abwesenheit['mitglied_id'] = $this->request->getPost()['mitglied_id']; else $abwesenheit['mitglied_id'] = ICH['id'];

            // if( !empty( $this->request->getPost()['id'] ) ) $abwesenheit_Model->update( $this->request->getpost()['id'], $abwesenheit );
            // else {
                $abwesenheit_Model->save( $abwesenheit );
                $ajax_antwort['element_id'] = (int)$abwesenheit_Model->getInsertID();
            // }
        }

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_abwesenheit_loeschen() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'id' => [ 'label' => 'ID', 'rules' => [ 'required', 'is_natural_no_zero' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if( model(Abwesenheit_Model::class)->find( $this->request->getPost()['id'] )['mitglied_id'] != ICH['id'] AND !auth()->user()->can( 'mitglieder.verwaltung' ) ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else model(Abwesenheit_Model::class)->delete( $this->request->getPost()['id'], true );
        
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
                foreach( $verfuegbares_recht as $eigenschaft => $wert ) if( is_numeric( $wert ) ) $verfuegbares_recht[ $eigenschaft ] = (int)$wert;
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
                foreach( $mitglied->getPermissions() as $permission ) {
                    $vergebenes_recht['id'] = $id;
                    $vergebenes_recht['mitglied_id'] = $mitglied->id;
                    $vergebenes_recht['verfuegbares_recht_id'] = VERFUEGBARE_RECHTE[ $permission ]['id'];
                    $vergebenes_recht = json_decode( json_encode( $vergebenes_recht ), TRUE );
                    foreach( $vergebenes_recht as $eigenschaft => $wert ) if( is_numeric( $wert ) ) $vergebenes_recht[ $eigenschaft ] = (int)$wert;
                    $ajax_antwort['tabelle'][] = $vergebenes_recht;
                    $id++;
                }
            }
            // $ajax_antwort['tabelle'][] = array( 'getPermissions' => model(Mitglied_Model::class)->find( ICH['id'] )->getPermissions(), 'VERFUEGBARE_RECHTE' => VERFUEGBARE_RECHTE );

        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

    public function ajax_vergebenes_recht_aendern() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
            'mitglied_id' => [ 'label' => EIGENSCHAFTEN['vergebene_rechte']['mitglied_id']['beschriftung'], 'rules' => [ 'required', 'is_natural_no_zero' ] ],
            'verfuegbares_recht_id' => [ 'label' => EIGENSCHAFTEN['vergebene_rechte']['verfuegbares_recht_id']['beschriftung'], 'rules' => [ 'required', 'is_natural_no_zero' ] ],
            'checked' => [ 'label' => 'Checked', 'rules' => [ 'required', 'in_list[ true, false ]' ] ],
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else if(
                !auth()->user()->can( 'mitglieder.rechte' ) AND
                !( auth()->user()->can( 'global.einstellungen' ) AND VERFUEGBARE_RECHTE['mitglieder.rechte']['id'] == $this->request->getPost()['verfuegbares_recht_id'] )
            ) $ajax_antwort['validation'] = 'Keine Berechtigung!';
        else {
            // if( empty( $this->request->getPost()['mitglied_id'] ) ) $mitglied_id = ICH['id']; else $mitglied_id = $this->request->getPost()['mitglied_id'];
            $permission = NULL; foreach( VERFUEGBARE_RECHTE as $verfuegbares_recht ) if( $verfuegbares_recht['id'] == $this->request->getPost()['verfuegbares_recht_id'] ) $permission = $verfuegbares_recht['permission'];
            model(Mitglied_Model::class)->findById( $this->request->getPost()['mitglied_id'] )->removePermission( $permission );
            if( filter_var( $this->request->getpost()['checked'], FILTER_VALIDATE_BOOLEAN) ) model(Mitglied_Model::class)->findById( $this->request->getPost()['mitglied_id'] )->addPermission( $permission );
        }
        
        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

}
