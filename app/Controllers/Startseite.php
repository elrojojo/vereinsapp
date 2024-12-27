<?php

namespace App\Controllers;
use App\Models\MitgliedModel;

use CodeIgniter\I18n\Time;

class Startseite extends BaseController {

    public function startseite() {

        $this->viewdata['liste']['anstehende_geburtstage'] = HAUPTINSTANZEN['mitglieder'];
        unset($this->viewdata['liste']['anstehende_geburtstage']['werkzeugkasten']);
        unset($this->viewdata['liste']['anstehende_geburtstage']['listenstatistik']);
        $this->viewdata['liste']['anstehende_geburtstage']['filtern'] = array( array( 'operator' => '<=', 'eigenschaft' => 'geburtstag', 'wert' => Time::today( 'Europe/Berlin' )->addDays(14)->toDateTimeString() ), );
        $this->viewdata['liste']['anstehende_geburtstage']['sortieren'] > array( array( 'eigenschaft' => 'geburtstag', 'richtung' => SORT_ASC, ), );
        $this->viewdata['liste']['anstehende_geburtstage']['link'] = TRUE;
        $this->viewdata['liste']['anstehende_geburtstage']['beschriftung'] = '<i class="bi bi-'.SYMBOLE['geburtstag']['bootstrap'].'"></i> '.HAUPTINSTANZEN['mitglieder']['beschriftung'];
        $this->viewdata['liste']['anstehende_geburtstage']['vorschau'] = array( 'geburtstag', 'alter_geburtstag' );

        $this->viewdata['liste']['bevorstehende_termine_startseite'] = HAUPTINSTANZEN['termine'];
        unset($this->viewdata['liste']['bevorstehende_termine_startseite']['werkzeugkasten']);
        unset($this->viewdata['liste']['bevorstehende_termine_startseite']['listenstatistik']);
        $this->viewdata['liste']['bevorstehende_termine_startseite']['filtern'] = array( array( 'verknuepfung' => '&&', 'filtern' => array(
            array( 'operator' => '>=', 'eigenschaft' => 'start', 'wert' => Time::today( 'Europe/Berlin' )->toDateTimeString() ),
            array( 'operator' => '<=', 'eigenschaft' => 'start', 'wert' => Time::today( 'Europe/Berlin' )->addDays(14)->toDateTimeString() ),
            array( 'operator' => '==', 'eigenschaft' => 'ich_eingeladen', 'wert' => TRUE ),
        ), ), );
        $this->viewdata['liste']['bevorstehende_termine_startseite']['link'] = TRUE;
        $this->viewdata['liste']['bevorstehende_termine_startseite']['beschriftung'] = '<i class="bi bi-'.SYMBOLE['termine']['bootstrap'].'"></i> '.HAUPTINSTANZEN['termine']['beschriftung'];
        $this->viewdata['liste']['bevorstehende_termine_startseite']['vorschau'] = array( 'start', 'ort' );

        $this->viewdata['liste']['aufgaben_offen_startseite'] = HAUPTINSTANZEN['aufgaben'];
        unset($this->viewdata['liste']['aufgaben_offen_startseite']['werkzeugkasten']);
        unset($this->viewdata['liste']['aufgaben_offen_startseite']['listenstatistik']);
        $this->viewdata['liste']['aufgaben_offen_startseite']['filtern'] = array( array( 'verknuepfung' => '&&', 'filtern' => array(
            array( 'eigenschaft' => 'mitglied_id', 'operator' => '==', 'wert' => ICH['id'], ),
            array( 'eigenschaft' => 'erledigt_janein', 'operator' => '==', 'wert' => false ),
        ), ), );
        $this->viewdata['liste']['aufgaben_offen_startseite']['beschriftung'] = '<i class="bi bi-'.SYMBOLE['aufgaben']['bootstrap'].'"></i> '.HAUPTINSTANZEN['aufgaben']['beschriftung'];
        $this->viewdata['liste']['aufgaben_offen_startseite']['vorschau'] = array( 'zugeordnetes_element' );

        $this->viewdata['liste']['termine_ausstehende_rueckmeldung'] = HAUPTINSTANZEN['termine'];
        unset($this->viewdata['liste']['termine_ausstehende_rueckmeldung']['werkzeugkasten']);
        unset($this->viewdata['liste']['termine_ausstehende_rueckmeldung']['listenstatistik']);
        $this->viewdata['liste']['termine_ausstehende_rueckmeldung']['filtern'] = array( array( 'verknuepfung' => '&&', 'filtern' => array(
            array( 'operator' => '>=', 'eigenschaft' => 'start', 'wert' => Time::now('Europe/Berlin')->toDateTimeString() ),
            array( 'operator' => '==', 'eigenschaft' => 'ich_rueckgemeldet', 'wert' => 0 ),
            array( 'operator' => '==', 'eigenschaft' => 'ich_eingeladen', 'wert' => TRUE ),
        ), ), );
        $this->viewdata['liste']['termine_ausstehende_rueckmeldung']['link'] = TRUE;
        $this->viewdata['liste']['termine_ausstehende_rueckmeldung']['beschriftung'] = '<i class="bi bi-'.SYMBOLE['termine']['bootstrap'].'"></i> '.HAUPTINSTANZEN['termine']['beschriftung'];
        $this->viewdata['liste']['termine_ausstehende_rueckmeldung']['vorschau'] = array( 'start', 'ort' );
        $this->viewdata['liste']['termine_ausstehende_rueckmeldung']['views'] = array( array( 'view' => 'Termine/rueckmeldung_basiseigenschaften', 'data' => array( 'mitglied_id' => ICH['id'] ) ) );

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        echo view( 'Startseite/startseite', $this->viewdata );
    }

}
