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
                'aktion' => 'aendern',
                'gegen_liste' => 'mitglieder',
                'gegen_element_id' => ICH['id'],
                'elemente_disabled' => $elemente_disabled,
            ),
        );

        if( auth()->user()->can('global.einstellungen') ) {
            $this->viewdata['liste']['temp_check_doppelte_rueckmeldungen'] = array(
                'liste' => 'temp_check_doppelte_rueckmeldungen',
                'sortieren' => array(
                    array( 'eigenschaft'=> 'termin_id', 'richtung'=> SORT_ASC, ),
                    array( 'eigenschaft'=> 'created_at', 'richtung'=> SORT_ASC, ),
                ),
                'beschriftung' => array(
                    'beschriftung' =>
                    EIGENSCHAFTEN['temp_check_doppelte_rueckmeldungen']['termin_id']['beschriftung'].': <span class="eigenschaft" data-eigenschaft="termin_id"></span>, '.
                    EIGENSCHAFTEN['temp_check_doppelte_rueckmeldungen']['mitglied_id']['beschriftung'].': <span class="eigenschaft" data-eigenschaft="mitglied_id"></span>, '.
                    EIGENSCHAFTEN['temp_check_doppelte_rueckmeldungen']['status']['beschriftung'].': <span class="eigenschaft" data-eigenschaft="status"></span>',
                ),
                'zusatzsymbole' => '<i class="zusatzsymbol bi bi-'.SYMBOLE['loeschen']['bootstrap'].' btn_rueckmeldung_loeschen bestaetigung_einfordern text-danger" data-element_id data-liste="rueckmeldungen" data-title="Doppelte Rückmeldung löschen" role="button"></i>',
                'vorschau' => array(
                    'beschriftung' => ''.EIGENSCHAFTEN['temp_check_doppelte_rueckmeldungen']['created_at']['beschriftung'].': <span class="eigenschaft" data-eigenschaft="created_at"></span>, '.EIGENSCHAFTEN['temp_check_doppelte_rueckmeldungen']['updated_at']['beschriftung'].': <span class="eigenschaft" data-eigenschaft="updated_at"></span>',
                    'klein' => TRUE,
                ),
                'listenstatistik' => TRUE,
            );

            $this->viewdata['liste']['temp_check_doppelte_rueckmeldungen']['werkzeugkasten']['filtern'] = array(
                'klasse_id' => 'btn_filtern_formular_oeffnen',
                'title' => 'Doppelte Rückmeldungen filtern',
            );

            $this->viewdata['liste']['temp_check_doppelte_rueckmeldungen']['werkzeugkasten']['sortieren'] = array(
                'klasse_id' => 'btn_sortieren_formular_oeffnen',
                'title' => 'Doppelte Rückmeldungen sortieren',
            );

        }

        if( array_key_exists( 'liste', $this->viewdata ) ) foreach( $this->viewdata['liste'] as $id => $liste ) $this->viewdata['liste'][ $id ]['id'] = $id;
        echo view( 'Einstellungen/einstellungen', $this->viewdata );
    }

}
