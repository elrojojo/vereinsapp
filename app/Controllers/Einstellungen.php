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

        $this->viewdata['liste']['meine_abwesenheiten']['werkzeugkasten_liste']['sortieren'] = array(
            'modal_id' => '#liste_sortieren_Modal',
            'titel' => 'Meine Abwesenheiten sortieren',
        );

        $this->viewdata['liste']['meine_abwesenheiten']['werkzeugkasten_liste']['filtern'] = array(
            'modal_id' => '#liste_filtern_Modal',
            'titel' => 'Meine Abwesenheiten filtern',
        );

        $this->viewdata['liste']['verfuegbare_rechte'] = array(
            'liste' => 'verfuegbare_rechte',
            'beschriftung' => array(
                'beschriftung' => '<span class="eigenschaft" data-eigenschaft="beschriftung"></span>',
            ),
        );
        
        $elemente_disabled = array();
        if( !auth()->user()->can( 'mitglieder.rechte' ) ) foreach( VERFUEGBARE_RECHTE as $verfuegbares_recht ) $elemente_disabled[] = $verfuegbares_recht['id'];
        else $elemente_disabled = array( VERFUEGBARE_RECHTE['mitglieder.rechte']['id'], VERFUEGBARE_RECHTE['global.einstellungen']['id'], );
        $this->viewdata['checkliste']['meine_rechte'] = array(
            'checkliste' => 'vergebene_rechte',
            'aktion' => 'aendern',
            'gegen_element' => 'mitglied',
            'gegen_element_id' => ICH['id'],
            'elemente_disabled' => $elemente_disabled,
        );


        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        if( array_key_exists( 'checkliste', $this->viewdata ) ) foreach( $this->viewdata['checkliste'] as $id => $checkliste ) $this->viewdata['checkliste'][ $id ]['id'] = $id;
        echo view( 'Einstellungen/einstellungen', $this->viewdata );
    }

}
