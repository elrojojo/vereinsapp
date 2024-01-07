<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Vereinsapp extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Angaben zum Verein, der die Vereinsapp nutzt
     * --------------------------------------------------------------------------
     *
     * Der offizielle Name des Vereins
     */
    public $verein_name = 'Eingetragener Verein e.V.';

    /**
     * Der Name der Vereinsapp innerhalb des Vereins
     * (sollte grammatikalisch weiblich sein)
     */
    public $vereinsapp_name = 'Eingetragener Verein e.V. Vereinsapp';

    /**
     * Das Logo der Vereinsapp 
     */
    public $vereinsapp_logo = 'images/title.png';

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
        // 'strafkatalog' => array ( 'beschriftung' => 'Strafkatalog', 'symbol' => 'piggy-bank' ),
        'notenbank' => array ( 'beschriftung' => 'Notenbank', 'symbol' => 'file-earmark-music' ),
        // 'umfragen' => array ( 'beschriftung' => 'Umfragen', 'symbol' => 'signpost-split' ),
        'mitglieder' => array ( 'beschriftung' => 'Mitglieder', 'symbol' => 'people' ),
        'einstellungen' => array ( 'beschriftung' => 'Einstellungen', 'symbol' => SYMBOLE['einstellungen']['bootstrap'] ),

        'status' => array ( 'beschriftung' => 'Status', 'symbol' => SYMBOLE['einstellungen']['bootstrap'] ),
    );

    /**
     * Einträge im Menü
     */
    public $menue = array(
        'termine',
        'notenbank',
        'mitglieder',
        'einstellungen',
    );

    /**
     * --------------------------------------------------------------------------
     * Eigenschaften
     * --------------------------------------------------------------------------
     *
     * Die Indices dürfen nicht verändert werden!
     * Es sollte lediglich die Beschriftung verändert werden.
     */
    public $eigenschaften = array(

        'mitglieder' => array(
            'email' => array( 'beschriftung' => 'Email', 'typ' => 'text' ),
            'vorname' => array(  'beschriftung' => 'Vorname', 'typ' => 'text' ),
            'nachname' => array(  'beschriftung' => 'Nachname', 'typ' => 'text' ),
            'geburt' => array( 'beschriftung' => 'Geboren am', 'typ' => 'zeitpunkt' ),
            'geburtstag' => array( 'beschriftung' => 'Geburtstag', 'typ' => 'zeitpunkt' ),      // JAVA
            'alter' => array( 'beschriftung' => 'Alter', 'typ' => 'zahl' ),                     // JAVA
            'alter_geburtstag' => array( 'beschriftung' => 'Nächstes Alter', 'typ' => 'zahl' ), // JAVA
            'postleitzahl' => array( 'beschriftung' => 'PLZ', 'typ' => 'text' ),
            'wohnort' => array( 'beschriftung' => 'Wohnort', 'typ' => 'text' ),
            'geschlecht' => array( 'beschriftung' => 'Geschlecht', 'typ' => 'vorgegebene_werte' ),
            'register' => array( 'beschriftung' => 'Instrument', 'typ' => 'vorgegebene_werte' ),
            'funktion' => array( 'beschriftung' => 'Funktion', 'typ' => 'vorgegebene_werte' ),
            'vorstandschaft' => array( 'beschriftung' => 'Vorstandschaft', 'typ' => 'vorgegebene_werte' ),
            'aktiv' => array( 'beschriftung' => 'Aktiv', 'typ' => 'vorgegebene_werte' ),
            'abwesend' => array( 'beschriftung' => 'Abwesend', 'typ' => 'vorgegebene_werte' ),  // JAVA
        ),

        'abwesenheiten' => array(
            'start' => array( 'beschriftung' => 'Beginn', 'typ' => 'zeitpunkt' ),
            'ende' => array( 'beschriftung' => 'Ende', 'typ' => 'zeitpunkt' ),
            'mitglied_id' => array( 'beschriftung' => 'Mitglied-ID', 'typ' => 'zahl' ),
            'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'typ' => 'text' ),
        ),

        'vergebene_rechte' => array(
            'mitglied_id' => array( 'beschriftung' => 'Mitglied-ID', 'typ' => 'zahl' ),
            'verfuegbares_recht_id' => array( 'beschriftung' => 'Verfuegbares-Recht-ID', 'typ' => 'zahl' ),
            'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'typ' => 'text' ),
        ),

        'termine' => array(
            'titel' => array( 'beschriftung' => 'Titel', 'typ' => 'text' ),
            'start' => array( 'beschriftung' => 'Beginn', 'typ' => 'zeitpunkt' ),
            'ort' => array( 'beschriftung' => 'Ort', 'typ' => 'text' ),
            'kategorie' => array( 'beschriftung' => 'Typ', 'typ' => 'vorgegebene_werte' ),
            'filtern_mitglieder' => array( 'beschriftung' => 'Personenkreis beschränken', 'typ' => 'text' ),
            'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'typ' => 'text' ),
            'ich_rueckgemeldet' => array( 'beschriftung' => 'Ich habe Rückmeldung gegeben', 'typ' => 'vorgegebene_werte' ), // JAVA
            'ich_eingeladen' => array( 'beschriftung' => 'Ich bin eingeladen.', 'typ' => 'vorgegebene_werte' ),             // JAVA
        ),

        'rueckmeldungen' => array(
            'termin_id' => array( 'beschriftung' => 'Termin-ID', 'typ' => 'zahl' ),
            'mitglied_id' => array( 'beschriftung' => 'Mitglied-ID', 'typ' => 'zahl' ),
            'status' => array( 'beschriftung' => 'Status', 'typ' => 'zahl' ),
            'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'typ' => 'text' ),
        ),

        'anwesenheiten' => array(
            'termin_id' => array( 'beschriftung' => 'Termin-ID', 'typ' => 'zahl' ),
            'mitglied_id' => array( 'beschriftung' => 'Mitglied-ID', 'typ' => 'zahl' ),
            'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'typ' => 'text' ),
        ),

        'notenbank' => array(
            'titel' => array( 'beschriftung' => 'Titel', 'typ' => 'text' ),
            'titel_nr' => array( 'beschriftung' => 'Titel-Nr.', 'typ' => 'zahl' ),
            'kategorie' => array( 'beschriftung' => 'Genre', 'typ' => 'vorgegebene_werte' ),
            'verzeichnis' => array( 'beschriftung' => 'Verzeichnis', 'typ' => 'text' ),
            'anzahl_noten' => array( 'beschriftung' => 'Anzahl Noten', 'typ' => 'zahl' ),               // JAVA
            'anzahl_audio' => array( 'beschriftung' => 'Anzahl Audio', 'typ' => 'zahl' ),               // JAVA
            'anzahl_verzeichnis' => array( 'beschriftung' => 'Anzahl Verzeichnisse', 'typ' => 'zahl' ), // JAVA
        ),

    );

    /**
     * --------------------------------------------------------------------------
     * Vorgegebene Werte zu Eigenschaften
     * --------------------------------------------------------------------------
     *
     * Werte, die zu den Eigenschaften vorgegeben sind
     * und bspw. ausgewählt werden können
     */
    public $vorgegebene_werte = array(

        'mitglieder' => array(

            'geschlecht' => array (
                'm' => array( 'beschriftung' => 'Männl.', ),
                'w' => array( 'beschriftung' => 'Weibl.', ),
                'd' => array( 'beschriftung' => 'Keine Angabe', ),
            ),

            'register' => array (
                'ohne' => array( 'beschriftung' => 'ohne Instrument', ),
                'dirigent' => array( 'beschriftung' => 'Dirigent', ),
                'ebass' => array( 'beschriftung' => 'E-Bass', ),
                'querfloete' => array( 'beschriftung' => 'Querflöte', ),
                'fluegelhorn' => array( 'beschriftung' => 'Flügelhorn', ),
                'klarinette' => array( 'beschriftung' => 'Klarinette', ),
                'posaune' => array( 'beschriftung' => 'Posaune', ),
                'saxofon' => array( 'beschriftung' => 'Saxofon', ),
                'schlagzeug' => array( 'beschriftung' => 'Schlagzeug', ),
                'tenorhorn' => array( 'beschriftung' => 'Tenorhorn', ),
                'trompete' => array( 'beschriftung' => 'Trompete', ),
                'tuba' => array( 'beschriftung' => 'Tuba', ),
                'waldhorn' => array( 'beschriftung' => 'Waldhorn', ),
            ),

            'funktion' => array (
                'ohne' => array( 'beschriftung' => 'keine Funktion', ),
                'vorsitz' => array( 'beschriftung' => 'Vorstand', ),
                'schriftfuehrer' => array( 'beschriftung' => 'Schriftführung', ),
                'kasse' => array( 'beschriftung' => 'Kasse', ),
                'jugend' => array( 'beschriftung' => 'Jugendleitung', ),
                'presse' => array( 'beschriftung' => 'Presse', ),
                'beisitz' => array( 'beschriftung' => 'Beisitz', ),
                'instrumente' => array( 'beschriftung' => 'Instrumentenwart', ),
                'noten' => array( 'beschriftung' => 'Notenwart', ),
            ),

            'vorstandschaft' => JANEIN,

            'aktiv' => JANEIN,

            'abwesend' => JANEIN,

        ),

        'abwesenheiten' => array(
        ),

        'vergebene_rechte' => array(
        ),

        'termine' => array(

            'kategorie' => array (
                'allgemein' => array( 'beschriftung' => 'Allgemein', 'symbol' => '' ),
                'auftritt' => array( 'beschriftung' => 'Auftritt', 'symbol' => '&#127930' ),
                'musikprobe' => array( 'beschriftung' => 'Musikprobe', 'symbol' => '&#128218' ),
                //'vorstandschaftssitzung' => array( 'beschriftung' => 'Vorstandschaftssitzung', 'symbol' => '<img class="title" src="images/vorstandschaftssitzung.png" width="30" />', 'filtern_mitglieder' => array( 'vorstandschaft' => array( 0, ), ), ),
            ),

            'ich_rueckgemeldet' => JANEIN,
        ),

        'rueckmeldungen' => array(
        ),

        'anwesenheiten' => array(
        ),

        'notenbank' => array(

            'kategorie' => array (
                'ohne' => array( 'beschriftung' => 'Ohne Zuordnung', ),
                'modern' => array( 'beschriftung' => 'Modern', ),
                'klassik' => array( 'beschriftung' => 'Klassik', ),
                'kirche' => array( 'beschriftung' => 'Kirche', ),
                'volkstuemlich' => array( 'beschriftung' => 'Volkstümlich', ),
            ),

        ),

    );

    /**
     * --------------------------------------------------------------------------
     * Filterbare Eigenschaften
     * --------------------------------------------------------------------------
     *
     * Eigenschaften, die filterbar sein sollen
     */
    public $filterbare_eigenschaften = array(

        'mitglieder' => array(
            'geburt',
            'geburtstag',
            'alter',
            'geschlecht',
            'register',
            'funktion',
            'vorstandschaft',
            'aktiv',
            'abwesend',
        ),

        'abwesenheiten' => array(
            'start',
            'ende',
        ),

        'vergebene_rechte' => array(
        ),

        'termine' => array(
            'start',
            'kategorie',
            'ich_rueckgemeldet',
        ),

        'rueckmeldungen' => array(
        ),

        'anwesenheiten' => array(
        ),

        'notenbank' => array(
            'titel_nr',
            'kategorie',
            'anzahl_noten',
            'anzahl_audio',
            'anzahl_verzeichnis',
        ),

    );

    /**
     * --------------------------------------------------------------------------
     * Sortierbare Eigenschaften
     * --------------------------------------------------------------------------
     *
     * Eigenschaften, die sortierbar sein sollen
     */
    public $sortierbare_eigenschaften = array(

        'mitglieder' => array(
            'vorname',
            'nachname',
            'geburtstag',
            'alter',
            'postleitzahl',
            'wohnort',
            'geschlecht',
            'register',
            'funktion',
            'vorstandschaft',
            'aktiv',
            'abwesend',
        ),

        'abwesenheiten' => array(
            'start',
            'ende',
        ),

        'vergebene_rechte' => array(
        ),

        'termine' => array(
            'titel',
            'start',
            'ort',
            'kategorie',
        ),

        'rueckmeldungen' => array(
        ),

        'anwesenheiten' => array(
        ),

        'notenbank' => array(
            'titel',
            'titel_nr',
            'kategorie',
            'anzahl_noten',
            'anzahl_audio',
            'anzahl_verzeichnis',
        ),

    );

    /**
     * --------------------------------------------------------------------------
     * Mitglieder-Eigenschaften Vorschau
     * --------------------------------------------------------------------------
     *
     * Angezeigte Mitglieder-Eigenschaften als Vorschau
     * in jedem Eintrag der Liste
     */
    public $mitglieder_eigenschaften_vorschau = array(
        'register',
        'geburtstag',
        'alter',
        'wohnort',
        'funktion',
    );

    /**
     * --------------------------------------------------------------------------
     * Notenbank Verzeichnis Anzahl Ziffern
     * --------------------------------------------------------------------------
     *
     * Anzahl der Ziffern zu Beginn des Verzeichnis-Namens im storage
     * (Ziffern entsprechen der Titel-Nr. und damit orientiert sich die Anzahl
     * der Ziffern an der Größe der Notenbank)
     */
    public $notenbank_anzahl_ziffern = 2;

    /**
     * --------------------------------------------------------------------------
     * Notenbank Verzeichnis erlaubte Dateitypen
     * --------------------------------------------------------------------------
     *
     * Erlaubte Dateitypen für Noten
     */
    public $notenbank_erlaubte_dateitypen_noten = array(
        'pdf',
    );

    /**
     * Einträge im Menü
     */
    public $notenbank_erlaubte_dateitypen_audio = array(
        'mp3',
        'm4a',
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
