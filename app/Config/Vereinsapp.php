<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Vereinsapp extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Wartungsarbeiten
     * --------------------------------------------------------------------------
     *
     * Wenn ein Hinweis auf Wartungsarbeiten eingeblendet werden soll, dann
     * kann ich auf TRUE gesetzt werden
     */
    public $wartungsarbeiten = FALSE;

    /**
     * --------------------------------------------------------------------------
     * Angaben zum Verein, der die Vereinsapp nutzt
     * --------------------------------------------------------------------------
     *
     * Der offizielle Name des Vereins
     */
    public $verein_name = 'Eingetragener Verein e.V.';

    /**
     * Die Homepage des Vereins
     */
    public $verein_domain = 'https://eingetragener-verein.de';

    /**
     * Der Name der Vereinsapp innerhalb des Vereins
     * (sollte grammatikalisch weiblich sein)
     */
    public $vereinsapp_name = 'Eingetragener Verein e.V. Vereinsapp';

    /**
     * Das Logo der Vereinsapp 
     */
    public $vereinsapp_logo = '';

    /**
     * --------------------------------------------------------------------------
     * Module (Controller)
     * --------------------------------------------------------------------------
     *
     * Aktive Module (Controller) inkl. Beschriftung und Symbol
     */
    public $controllers = array(
        'startseite' => array ( 'beschriftung' => 'Willkommen', 'symbol' => SYMBOLE['startseite']['bootstrap'] ),
        'termine' => array ( 'beschriftung' => 'Termine', 'symbol' => SYMBOLE['termine']['bootstrap'] ),
        'strafkatalog' => array ( 'beschriftung' => 'Strafkatalog', 'symbol' => SYMBOLE['strafkatalog']['bootstrap'] ),
        'notenbank' => array ( 'beschriftung' => 'Notenbank', 'symbol' => SYMBOLE['notenbank']['bootstrap'] ),
        // 'umfragen' => array ( 'beschriftung' => 'Umfragen', 'symbol' => SYMBOLE['umfragen']['bootstrap'] ),
        'mitglieder' => array ( 'beschriftung' => 'Mitglieder', 'symbol' => SYMBOLE['mitglieder']['bootstrap'] ),
        'einstellungen' => array ( 'beschriftung' => 'Einstellungen', 'symbol' => SYMBOLE['einstellungen']['bootstrap'] ),

        'status' => array ( 'beschriftung' => 'Status', 'symbol' => SYMBOLE['einstellungen']['bootstrap'] ),
    );

    /**
     * Einträge im Menü
     */
    public $menue = array(
        'termine',
        'strafkatalog',
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
            'id' => array(  'beschriftung' => 'ID', 'typ' => 'zahl' ),
            'email' => array( 'beschriftung' => 'Email', 'typ' => 'text' ),  // PHP
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
            'auto' => array( 'beschriftung' => 'Auto', 'typ' => 'vorgegebene_werte' ),
            'funktion' => array( 'beschriftung' => 'Funktion', 'typ' => 'vorgegebene_werte' ),
            'vorstandschaft' => array( 'beschriftung' => 'Vorstandschaft', 'typ' => 'vorgegebene_werte' ),
            'aktiv' => array( 'beschriftung' => 'Aktiv', 'typ' => 'vorgegebene_werte' ),
            'abwesend' => array( 'beschriftung' => 'Abwesend', 'typ' => 'vorgegebene_werte' ),  // JAVA
            'erstellung' => array( 'beschriftung' => 'Erstellt am', 'typ' => 'zeitpunkt' ),  // PHP
            'letzte_aktivitaet' => array( 'beschriftung' => 'Zuletzt aktiv am', 'typ' => 'zeitpunkt' ),  // PHP
        ),

        'vergebene_rechte' => array(
            'id' => array(  'beschriftung' => 'ID', 'typ' => 'zahl' ),                                      // PHP
            'mitglied_id' => array( 'beschriftung' => 'Mitglied-ID', 'typ' => 'zahl' ),                     // PHP
            'verfuegbares_recht_id' => array( 'beschriftung' => 'Verfuegbares-Recht-ID', 'typ' => 'zahl' ), // PHP
        ),

        'termine' => array(
            'id' => array(  'beschriftung' => 'ID', 'typ' => 'zahl' ),
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
            'id' => array(  'beschriftung' => 'ID', 'typ' => 'zahl' ),
            'termin_id' => array( 'beschriftung' => 'Termin-ID', 'typ' => 'zahl' ),
            'mitglied_id' => array( 'beschriftung' => 'Mitglied-ID', 'typ' => 'zahl' ),
            'status' => array( 'beschriftung' => 'Status', 'typ' => 'zahl' ),
            'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'typ' => 'text' ),
        ),

        'anwesenheiten' => array(
            'id' => array(  'beschriftung' => 'ID', 'typ' => 'zahl' ),
            'termin_id' => array( 'beschriftung' => 'Termin-ID', 'typ' => 'zahl' ),
            'mitglied_id' => array( 'beschriftung' => 'Mitglied-ID', 'typ' => 'zahl' ),
            'status' => array( 'beschriftung' => 'Status', 'typ' => 'zahl' ),
            'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'typ' => 'text' ),
        ),

        'strafkatalog' => array(
            'id' => array(  'beschriftung' => 'ID', 'typ' => 'zahl' ),
            'titel' => array( 'beschriftung' => 'Titel', 'typ' => 'text' ),
            'wert' => array( 'beschriftung' => 'Wert', 'typ' => 'zahl' ),
            'kategorie' => array( 'beschriftung' => 'Kapitel', 'typ' => 'vorgegebene_werte' ),
            'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'typ' => 'text' ),
        ),

        'kassenbuch' => array(
            'id' => array(  'beschriftung' => 'ID', 'typ' => 'zahl' ),
            'titel' => array( 'beschriftung' => 'Titel', 'typ' => 'text' ),
            'wert' => array( 'beschriftung' => 'Wert', 'typ' => 'zahl' ),
            'zeitpunkt' => array( 'beschriftung' => 'Zeitpunkt', 'typ' => 'zeitpunkt' ),
            'aktiv' => array( 'beschriftung' => 'Aktiv', 'typ' => 'vorgegebene_werte' ),
            'mitglied_id' => array( 'beschriftung' => 'Mitglied-ID', 'typ' => 'zahl' ),
            'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'typ' => 'text' ),
            'letzte_aktivitaet' => array( 'beschriftung' => 'Zuletzt aktiv am', 'typ' => 'zeitpunkt' ), // PHP
        ),

        'notenbank' => array(
            'id' => array(  'beschriftung' => 'ID', 'typ' => 'zahl' ),
            'titel' => array( 'beschriftung' => 'Titel', 'typ' => 'text' ),
            'titel_nr' => array( 'beschriftung' => 'Titel-Nr.', 'typ' => 'zahl' ),
            'kategorie' => array( 'beschriftung' => 'Genre', 'typ' => 'vorgegebene_werte' ),
            'verzeichnis_basis' => array( 'beschriftung' => 'Basis-Verzeichnis', 'typ' => 'text' ),     //PHP
            'verzeichnis' => array( 'beschriftung' => 'Verzeichnis', 'typ' => 'text' ),                 //PHP
            'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'typ' => 'text' ),
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
                'saxophon' => array( 'beschriftung' => 'Saxophon', ),
                'schlagzeug' => array( 'beschriftung' => 'Schlagzeug', ),
                'tenorhorn' => array( 'beschriftung' => 'Tenorhorn', ),
                'trompete' => array( 'beschriftung' => 'Trompete', ),
                'tuba' => array( 'beschriftung' => 'Tuba', ),
                'waldhorn' => array( 'beschriftung' => 'Waldhorn', ),
            ),

            'auto' => array (
                'ohne' => array( 'beschriftung' => 'ohne Auto', ),
                'bus' => array( 'beschriftung' => 'Bus', ),
                'auto_1' => array( 'beschriftung' => 'Auto 1', ),
                'auto_2' => array( 'beschriftung' => 'Auto 2', ),
                'auto_3' => array( 'beschriftung' => 'Auto 3', ),
                'auto_4' => array( 'beschriftung' => 'Auto 4', ),
                'auto_5' => array( 'beschriftung' => 'Auto 5', ),
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

        'vergebene_rechte' => array(
        ),

        'termine' => array(

            'kategorie' => array (
                'allgemein' => array( 'beschriftung' => 'Allgemein', 'symbol' => '' ),
                'auftritt' => array( 'beschriftung' => 'Auftritt', 'symbol' => '&#127930' ),
                'probe' => array( 'beschriftung' => 'Musikprobe', 'symbol' => '&#128218' ),
                'vorstandschaftssitzung' => array( 'beschriftung' => 'Vorstandschaftssitzung', 'symbol' => '&#128186' ),
            ),

            'ich_rueckgemeldet' => JANEIN,
        ),

        'rueckmeldungen' => array(
        ),

        'anwesenheiten' => array(
        ),

        'strafkatalog' => array(

            'kategorie' => array (
                'ohne' => array( 'beschriftung' => 'Sonstiges', ),
                'proben' => array( 'beschriftung' => 'Proben', ),
                'veranstaltungen' => array( 'beschriftung' => 'Veranstaltungen', ),
                'haessordnung' => array( 'beschriftung' => 'Häßordnung', ),
            ),

        ),

        'kassenbuch' => array(

            'aktiv' => JANEIN,

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
            'auto',
            'funktion',
            'vorstandschaft',
            'aktiv',
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

        'strafkatalog' => array(
            'wert',
            'kategorie',
        ),

        'kassenbuch' => array(
            'wert',
            'zeitpunkt',
            'aktiv',
            'mitglied_id',
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
            'auto',
            'funktion',
            'vorstandschaft',
            'aktiv',
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

        'strafkatalog' => array(
            'titel',
            'wert',
            'kategorie',
        ),

        'kassenbuch' => array(
            'titel',
            'wert',
            'zeitpunkt',
            'aktiv',
            'mitglied_id',
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
     * Gruppierbare Eigenschaften
     * --------------------------------------------------------------------------
     *
     * Eigenschaften, die gruppierbar sein sollen
     */
    public $gruppierbare_eigenschaften = array(

        'mitglieder' => array(
            'wohnort',
            'geschlecht',
            'register',
            'auto',
            'funktion',
            'vorstandschaft',
            'aktiv',
        ),

        'vergebene_rechte' => array(
        ),

        'termine' => array(
            'kategorie',
        ),

        'rueckmeldungen' => array(
        ),

        'anwesenheiten' => array(
        ),

        'strafkatalog' => array(
            'kategorie',
        ),

        'kassenbuch' => array(
            'aktiv',
        ),
        
        'notenbank' => array(
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
        'auto',
        'funktion',
    );

    /**
     * --------------------------------------------------------------------------
     * Termin-Kategorie filtern_mitglieder
     * --------------------------------------------------------------------------
     *
     * Voreinstellungen für Termin-Kategorien
     * entsprechend dem Standard-Schema für Filtern
     */
    public $termine_kategorie_filtern_mitglieder = array(
        'probe' => array( array( 'operator' => '==', 'eigenschaft' => 'aktiv', 'wert' => '1' ), ),
        'auftritt' => array( array( 'operator' => '==', 'eigenschaft' => 'aktiv', 'wert' => '1' ), ),
        'vorstandschaftssitzung' => array( array( 'operator' => '==', 'eigenschaft' => 'vorstandschaft', 'wert' => '1' ), ),
    );

    /**
     * --------------------------------------------------------------------------
     * Rückmelde-Frist für Termine
     * --------------------------------------------------------------------------
     *
     * Frist in Sekunden, die man mindestens
     * vor dem Start des Termins einhalten muss
     */
    public $termine_rueckmeldung_frist = 0;

    /**
     * --------------------------------------------------------------------------
     * Notenbank Verzeichnis Anzahl Ziffern
     * --------------------------------------------------------------------------
     *
     * Anzahl der Ziffern zu Beginn des Verzeichnis-Namens im storage
     * (Ziffern entsprechen der Titel-Nr. und damit orientiert sich die Anzahl
     * der Ziffern an der Größe der Notenbank)
     */
    public $notenbank_anzahl_ziffern = 3;

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
     * Erlaubte Dateitypen für Audios
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
    
    /**
     * --------------------------------------------------------------------------
     * Kasten "Weiter zur Website von ..."
     * --------------------------------------------------------------------------
     *
     * Kasten "Weiter zur Website von ..." auf der Login-Seite aktivieren
     */
    public $kasten_weiter_zur_website_von_login = FALSE;
    
    /**
     * Kasten "Weiter zur Website von ..." auf der Startseite aktivieren
     */
    public $kasten_weiter_zur_website_von_startseite = FALSE;

    /**
     * --------------------------------------------------------------------------
     * LocalStorage Reset erzwingen
     * --------------------------------------------------------------------------
     *
     * Wenn der LocalStorage auf allen verwendeten Geräten einmal geleert werden
     * soll, dann muss der jetzige Zeitpunkt definiert werden
     */
    public $force_localstorage_reset_zeitpunkt = '2024-01-31T00:00:00.000+01:00';

}
