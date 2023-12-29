<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Vereinsapp extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Module (Controller)
     * --------------------------------------------------------------------------
     *
     * Aktive Module (Controller) inkl. Beschriftung und Symbol
     */
    public $controllers = array(
        'startseite' => array ( 'beschriftung' => 'Willkommen', 'symbol' => '' ),
        'termine' => array ( 'beschriftung' => 'Termine', 'symbol' => 'calendar-month' ),
        'strafkatalog' => array ( 'beschriftung' => 'Strafkatalog', 'symbol' => 'piggy-bank' ),
        'notenbank' => array ( 'beschriftung' => 'Notenbank', 'symbol' => 'file-earmark-music' ),
        'umfragen' => array ( 'beschriftung' => 'Umfragen', 'symbol' => 'signpost-split' ),
        'mitglieder' => array ( 'beschriftung' => 'Mitglieder', 'symbol' => 'people' ),
        'einstellungen' => array ( 'beschriftung' => 'Einstellungen', 'symbol' => SYMBOLE['einstellungen']['bootstrap'] ),
        'status' => array ( 'beschriftung' => 'Status', 'symbol' => SYMBOLE['einstellungen']['bootstrap'] ),
    );

    /**
     * --------------------------------------------------------------------------
     * Datenschutz-Richtlinie
     * --------------------------------------------------------------------------
     *
     * Zeitstempel, zu dem die Datenschutz-Richtlinie veröfentlicht wurde
     */
    public $datenschutz_richtlinie_datum = 20210629;
    
    /**
     * --------------------------------------------------------------------------
     * AJAX-Zykluszeit
     * --------------------------------------------------------------------------
     *
     * Zeit in Sekunden bis zum nächsten Schleifendurchgang 
     */
    public $ajax_zykluszeit = 30;

}
