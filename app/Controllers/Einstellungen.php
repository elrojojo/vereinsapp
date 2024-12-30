<?php

namespace App\Controllers;

use App\Models\Mitglieder\Mitglied_Model;
use App\Models\Aufgaben\Aufgabe_Model;
use App\Models\Termine\Termin_Model;
use App\Models\Termine\Terminrueckmeldung_Model;
use App\Models\Termine\Anwesenheit_Model;
use App\Models\Strafkatalog\Strafe_Model;
use App\Models\Strafkatalog\Kassenbucheintrag_Model;
use App\Models\Notenbank\Titel_Model;
use App\Models\Umfragen\Umfrage_Model;
use App\Models\Umfragen\Rueckmeldung_Model;

class Einstellungen extends BaseController {

    public function einstellungen() {

        $disabled_filtern = array();
        $disabled_filtern[] = array( 'operator' => '==', 'eigenschaft' => 'id', 'wert' => VERFUEGBARE_RECHTE['global.einstellungen']['id'] );
        if( !auth()->user()->can( 'global.einstellungen' ) ) $disabled_filtern[] = array( 'operator' => '==', 'eigenschaft' => 'id', 'wert' => VERFUEGBARE_RECHTE['mitglieder.rechte']['id'] );
        if( !auth()->user()->can( 'mitglieder.rechte' ) ) foreach( VERFUEGBARE_RECHTE as $verfuegbares_recht ) if( $verfuegbares_recht['permission'] != 'global.einstellungen' AND $verfuegbares_recht['permission'] != 'mitglieder.rechte' ) $disabled_filtern[] = array( 'operator' => '==', 'eigenschaft' => 'id', 'wert' => $verfuegbares_recht['id'] );
        $this->viewdata['liste']['rechte_vergeben'] = HAUPTINSTANZEN['verfuegbare_rechte'];
        $this->viewdata['liste']['rechte_vergeben']['checkliste'] = 'vergebene_rechte';
        $this->viewdata['liste']['rechte_vergeben']['gegen_liste'] = 'mitglieder';
        $this->viewdata['liste']['rechte_vergeben']['gegen_element_id'] = ICH['id'];
        $this->viewdata['liste']['rechte_vergeben']['disabled'] = array( 'liste' => 'verfuegbare_rechte', 'filtern' => array( array( 'verknuepfung' => '||', 'filtern' => $disabled_filtern, ), ), );

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        echo view( 'Einstellungen/einstellungen', $this->viewdata );
    }

    public function ajax_tabellen() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $validation_rules = array(
            'ajax_id' => 'required|is_natural',
        ); if( !$this->validate( $validation_rules ) ) $ajax_antwort['validation'] = $this->validation->getErrors();
        else {
            $ajax_antwort['tabellen'] = array(
                'mitglieder' => model(Mitglied_Model::class)->mitglieder_tabelle(),
                'verfuegbare_rechte' => model(Mitglied_Model::class)->verfuegbare_rechte_tabelle(),
                'vergebene_rechte' => model(Mitglied_Model::class)->vergebene_rechte_tabelle(),
                'aufgaben' => model(Aufgabe_Model::class)->aufgaben_tabelle(),
                'termine' => model(Termin_Model::class)->termine_tabelle(),
                'terminrueckmeldungen' => model(Terminrueckmeldung_Model::class)->terminrueckmeldungen_tabelle(),
                'anwesenheiten' => model(Anwesenheit_Model::class)->anwesenheiten_tabelle(),
                'strafkatalog' => model(Strafe_Model::class)->strafkatalog_tabelle(),
                'kassenbuch' => model(Kassenbucheintrag_Model::class)->kassenbuch_tabelle(),
                'notenbank' => model(Titel_Model::class)->notenbank_tabelle(),
                'umfragen' => model(Umfrage_Model::class)->umfragen_tabelle(),
                'rueckmeldungen' => model(Rueckmeldung_Model::class)->rueckmeldungen_tabelle(),
            );

        }
        
        $ajax_antwort['ajax_id'] = (int) $this->request->getPost()['ajax_id'];
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

}
