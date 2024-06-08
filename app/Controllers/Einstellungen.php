<?php

namespace App\Controllers;

class Einstellungen extends BaseController {

    public function einstellungen() {

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
                'elemente_disabled' => $elemente_disabled,
            ),
            'gegen_liste' => 'mitglieder',
            'gegen_element_id' => ICH['id'],
        );

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        echo view( 'Einstellungen/einstellungen', $this->viewdata );
    }

}
