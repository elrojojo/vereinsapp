<?php
class Ajax extends Vereinsapp_Controller {

  public function __construct() {
    parent::__construct();
  }
  
  public function ajax_cookies_richtlinie() {
    echo $this->load->view('cookies/richtlinie', $this->data, TRUE );
  }

}
