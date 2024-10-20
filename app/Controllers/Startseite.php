<?php

namespace App\Controllers;
use App\Models\MitgliedModel;

use CodeIgniter\I18n\Time;

class Startseite extends BaseController {

    public function startseite() {

        $this->viewdata['liste']['anstehende_geburtstage'] = array(
            'liste' => 'mitglieder',
            'filtern' => array( array( 'operator' => '<=', 'eigenschaft' => 'geburtstag', 'wert' => Time::today( 'Europe/Berlin' )->addDays(14)->toDateTimeString() ), ),
            'sortieren' => array(
                array( 'eigenschaft' => 'geburtstag', 'richtung' => SORT_ASC, ),
            ),
            'beschriftung' => array(
                'beschriftung' => '<span class="eigenschaft" data-eigenschaft="vorname"></span> <span class="eigenschaft" data-eigenschaft="nachname"></span>',
            ),
            'vorschau' => '<div class="nowrap small"><i class="bi bi-'.SYMBOLE['geburtstag']['bootstrap'].'"></i> <span class="eigenschaft" data-eigenschaft="geburtstag"></span> (<span class="eigenschaft" data-eigenschaft="alter_geburtstag"></span>)</div>',
        );

        $this->viewdata['liste']['bevorstehende_termine_startseite'] = array(
            'liste' => 'termine',
            'filtern' => array( array(
                'verknuepfung' => '&&',
                'filtern' => array(
                    array( 'operator' => '>=', 'eigenschaft' => 'start', 'wert' => Time::today( 'Europe/Berlin' )->toDateTimeString() ),
                    array( 'operator' => '<=', 'eigenschaft' => 'start', 'wert' => Time::today( 'Europe/Berlin' )->addDays(14)->toDateTimeString() ),
                    array( 'operator' => '==', 'eigenschaft' => 'ich_eingeladen', 'wert' => TRUE ),
                ),
            ), ),
            'sortieren' => array(
                array( 'eigenschaft' => 'start', 'richtung' => SORT_ASC, ),
            ),
            'beschriftung' => array(
                'beschriftung' => '<span class="eigenschaft" data-eigenschaft="titel"></span>',
            ),
            'link' => TRUE,
            'vorschau' => '<div class="nowrap small"><i class="bi bi-'.SYMBOLE['datum']['bootstrap'].'"></i> <span class="eigenschaft" data-eigenschaft="start"></span></div>',
            'zusatzsymbole' => '<span class="zusatzsymbol" data-zusatzsymbol="kategorie"></span>',
        );

        $this->viewdata['liste']['termine_ausstehende_rueckmeldung'] = array(
            'liste' => 'termine',
            'filtern' => array( array( 
                'verknuepfung' => '&&',
                'filtern' => array(
                    array( 'operator' => '>=', 'eigenschaft' => 'start', 'wert' => JETZT->toDateTimeString() ),
                    array( 'operator' => '==', 'eigenschaft' => 'ich_rueckgemeldet', 'wert' => 0 ),
                    array( 'operator' => '==', 'eigenschaft' => 'ich_eingeladen', 'wert' => TRUE ),
                ),
            ), ),
            'sortieren' => array(
                array( 'eigenschaft' => 'start', 'richtung' => SORT_ASC, ),
            ),
            'beschriftung' => array(
                'beschriftung' => '<span class="eigenschaft" data-eigenschaft="titel"></span>',
            ),
            'link' => TRUE,
            'vorschau' => '<div class="row g-0 my-1 small"><div class="col nowrap"><i class="bi bi-'.SYMBOLE['datum']['bootstrap'].'"></i> <span class="eigenschaft" data-eigenschaft="start"></span></div></div>',
            'views' => view( 'Termine/rueckmeldung_basiseigenschaften', array( 'mitglied_id' => ICH['id'] ) ),
            'zusatzsymbole' => '<span class="zusatzsymbol" data-zusatzsymbol="kategorie"></span>',
        );

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        echo view( 'Startseite/startseite', $this->viewdata );
    }

}
