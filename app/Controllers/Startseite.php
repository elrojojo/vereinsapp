<?php

namespace App\Controllers;
use App\Models\MitgliedModel;

class Startseite extends BaseController {

    public function startseite() {

        $this->viewdata['liste']['anstehende_geburtstage'] = array(
            'liste' => 'mitglieder',
            'filtern' => array( array( 'operator' => '<=', 'eigenschaft' => 'geburtstag', 'wert' => date( 'Y-m-d', time()+2*WEEK, ).' 00:00:00' ), ),
            'sortieren' => array(
                array( 'eigenschaft' => 'geburtstag', 'richtung' => SORT_ASC, ),
            ),
            'beschriftung' => array(
                'beschriftung' => '<span class="eigenschaft" data-eigenschaft="vorname"></span> <span class="eigenschaft" data-eigenschaft="nachname"></span>',
            ),
            'symbol' => array(
                'symbol' => SYMBOLE['geburtstag']['bootstrap'],
            ),
            'vorschau' => array(
                'beschriftung' => '<div class="nowrap"><i class="bi bi-calendar-event"></i> <span class="eigenschaft" data-eigenschaft="geburtstag"></span> (<span class="eigenschaft" data-eigenschaft="alter_geburtstag"></span>)</div>',
                'klein' => true,
            ),
        );

        $this->viewdata['liste']['anstehende_termine'] = array(
            'liste' => 'termine',
            'filtern' => array( array(
                'verknuepfung' => '&&',
                'filtern' => array(
                    array( 'operator' => '>=', 'eigenschaft' => 'start', 'wert' => date( 'Y-m-d', time() ).' 00:00:00' ),
                    array( 'operator' => '<=', 'eigenschaft' => 'start', 'wert' => date( 'Y-m-d', time()+2*WEEK, ).' 00:00:00' ),
                    array( 'operator' => '==', 'eigenschaft' => 'ich_eingeladen', 'wert' => true ),
                ),
            ), ),
            'sortieren' => array(
                array( 'eigenschaft' => 'start', 'richtung' => SORT_ASC, ),
            ),
            'beschriftung' => array(
                'beschriftung' => '<span class="eigenschaft" data-eigenschaft="titel"></span>',
            ),
            'link' => site_url().'termine',
            'symbol' => array(
                'symbol' => SYMBOLE['info']['bootstrap'],
            ),
            'vorschau' => array(
                'beschriftung' => '<div class="nowrap"><i class="bi bi-calendar-event"></i> <span class="eigenschaft" data-eigenschaft="start"></span></div>',
                'klein' => true,
            ),
            'zusatzsymbole' => '<span class="zusatzsymbol" data-zusatzsymbol="kategorie"></span>',
        );

        $this->viewdata['liste']['termine_ausstehende_rueckmeldung'] = array(
            'liste' => 'termine',
            'filtern' => array( array( 
                'verknuepfung' => '&&',
                'filtern' => array(
                    array( 'operator' => '>=', 'eigenschaft' => 'start', 'wert' => date( 'Y-m-d', time() ).' 00:00:00' ),
                    array( 'operator' => '==', 'eigenschaft' => 'ich_rueckgemeldet', 'wert' => 0 ),
                    array( 'operator' => '==', 'eigenschaft' => 'ich_eingeladen', 'wert' => true ),
                ),
            ), ),
            'sortieren' => array(
                array( 'eigenschaft' => 'start', 'richtung' => SORT_ASC, ),
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
                    </div>'.view( 'Termine/rueckmeldung_erstellen', array( 'mitglied_id' => ICH['id'] ) ),
                'klein' => true,
            ),
            'zusatzsymbole' => '<span class="zusatzsymbol" data-zusatzsymbol="kategorie"></span>',
        );

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        echo view( 'Startseite/startseite', $this->viewdata );
    }

}
