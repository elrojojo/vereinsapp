<?php

namespace App\Controllers;

class Status extends BaseController {

    public function status() {
        echo view( 'Status/status', $this->viewdata );
    }
      
    public function ajax_datenschutz_richtlinie() { $ajax_antwort[CSRF_NAME] = csrf_hash();
        $ajax_antwort['html'] = view( 'Status/datenschutz_richtlinie', $this->viewdata );
        echo json_encode( $ajax_antwort, JSON_UNESCAPED_UNICODE );
    }

}
