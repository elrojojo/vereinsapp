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
        
        $this->viewdata['check_liste']['meine_rechte'] = array(
            'check_liste' => 'permissions',
            'aktion' => 'aendern',
            'gegen_element' => 'mitglied',
            'gegen_element_id' => ICH['id'],
        );

        $this->viewdata['werkzeugkasten']['sortieren'] = array(
            'modal_id' => '#liste_sortieren_Modal',
            'liste' => 'abwesenheiten',
            'beschriftung' => 'Meine Abwesenheiten sortieren',
        );

        $this->viewdata['werkzeugkasten']['filtern'] = array(
            'modal_id' => '#liste_filtern_Modal',
            'liste' => 'abwesenheiten',
            'beschriftung' => 'Meine Abwesenheiten filtern',
        );

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        if( array_key_exists( 'check_liste', $this->viewdata ) ) foreach( $this->viewdata['check_liste'] as $id => $check_liste ) $this->viewdata['check_liste'][ $id ]['id'] = $id;
        echo view( 'Einstellungen/einstellungen', $this->viewdata );
    }

}
