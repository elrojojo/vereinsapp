<?php

namespace App\Controllers;

class Einstellungen extends BaseController {

    public function einstellungen() {

        $disabled_filtern = array();
        $disabled_filtern[] = array( 'operator' => '==', 'eigenschaft' => 'id', 'wert' => VERFUEGBARE_RECHTE['global.einstellungen']['id'] );
        if( !auth()->user()->can( 'global.einstellungen' ) ) $disabled_filtern[] = array( 'operator' => '==', 'eigenschaft' => 'id', 'wert' => VERFUEGBARE_RECHTE['mitglieder.rechte']['id'] );
        if( !auth()->user()->can( 'mitglieder.rechte' ) ) foreach( VERFUEGBARE_RECHTE as $verfuegbares_recht ) if( $verfuegbares_recht['permission'] != 'global.einstellungen' AND $verfuegbares_recht['permission'] != 'mitglieder.rechte' ) $disabled_filtern[] = array( 'operator' => '==', 'eigenschaft' => 'id', 'wert' => $verfuegbares_recht['id'] );
        $this->viewdata['liste']['rechte_vergeben'] = array(
            'liste' => 'verfuegbare_rechte',
            'beschriftung' => '<span class="eigenschaft" data-eigenschaft="beschriftung"></span>',
            'checkliste' => 'vergebene_rechte',
            'gegen_liste' => 'mitglieder',
            'gegen_element_id' => ICH['id'],
            'disabled' => array(
                'liste' => 'verfuegbare_rechte',
                'filtern' => array( array(
                    'verknuepfung' => '||',
                    'filtern' => $disabled_filtern,
                ), ),
            ),
        );

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        echo view( 'Einstellungen/einstellungen', $this->viewdata );
    }

}
