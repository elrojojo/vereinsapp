<?php

namespace App\Controllers;
use App\Models\Mitglieder\Abwesenheit_Model;

class Einstellungen extends BaseController {

    public function einstellungen() {

        $this->viewdata['liste']['meine_abwesenheiten'] = array(
            'liste' => 'abwesenheiten',
            'sortieren' => array(
                array( 'eigenschaft' => 'start', 'richtung' => SORT_ASC, ),
                array( 'eigenschaft' => 'ende', 'richtung' => SORT_ASC, ),                
            ),
            'filtern' => array( array( 'operator' => '==', 'eigenschaft' => 'mitglied_id', 'wert' => ICH['id'] ), ),
            'beschriftung' => array(
                'beschriftung' => '<span class="eigenschaft" data-eigenschaft="start"></span> - <span class="eigenschaft" data-eigenschaft="ende"></span>',
            ),
            'modal' => array(
                'target' => '#element_loeschen_modal',
                'aktion' => 'loeschen',
            ),
            'symbol' => array(
                'symbol' => SYMBOLE['loeschen']['bootstrap'],
                'farbe' => 'danger',
            ),
            'vorschau' => array(
                'beschriftung' => '<span class="eigenschaft" data-eigenschaft="bemerkung"></span>',
                'klein' => TRUE,
                'abschneiden' => TRUE,
            ),
            'listenstatistik' => TRUE,
        );

        $this->viewdata['liste']['meine_abwesenheiten']['werkzeugkasten']['sortieren'] = array(
            'modal_id' => '#liste_sortieren_modal',
            'title' => 'Meine Abwesenheiten sortieren',
        );

        $this->viewdata['liste']['meine_abwesenheiten']['werkzeugkasten']['filtern'] = array(
            'modal_id' => '#liste_filtern_modal',
            'title' => 'Meine Abwesenheiten filtern',
        );

        $elemente_disabled = array();
        $elemente_disabled[] = VERFUEGBARE_RECHTE['global.einstellungen']['id'];
        if( !auth()->user()->can( 'global.einstellungen' ) ) $elemente_disabled[] = VERFUEGBARE_RECHTE['mitglieder.rechte']['id'];
        if( !auth()->user()->can( 'mitglieder.rechte' ) ) foreach( VERFUEGBARE_RECHTE as $verfuegbares_recht ) if( $verfuegbares_recht['permission'] != 'global.einstellungen' AND $verfuegbares_recht['permission'] != 'mitglieder.rechte' ) $elemente_disabled[] = $verfuegbares_recht['id'];
        $this->viewdata['liste']['rechte_vergeben'] = array(
            'liste' => 'verfuegbare_rechte',
            'beschriftung' => array(
                'beschriftung' => '<span class="eigenschaft" data-eigenschaft="beschriftung"></span>',
            ),
            'checkliste' => array(
                'checkliste' => 'vergebene_rechte',
                'aktion' => 'aendern',
                'gegen_liste' => 'mitglieder',
                'gegen_element_id' => ICH['id'],
                'elemente_disabled' => $elemente_disabled,
            ),
        );

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        echo view( 'Einstellungen/einstellungen', $this->viewdata );
    }

}
