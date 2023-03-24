<?php

namespace App\Controllers;

class Status extends BaseController {

    public function status() {
        echo view( 'Status/status', $this->viewdata );
    }
      
    public function ajax_datenschutz_richtlinie() {
        echo view( 'Status/datenschutz_richtlinie', $this->viewdata );
    }

}
