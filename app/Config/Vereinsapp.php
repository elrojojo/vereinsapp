<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\I18n\Time;
defined('HEUTE') OR define( 'HEUTE', Time::today( 'Europe/Berlin' )->toDateTimeString() );

class Vereinsapp extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Lies Mich!
     * --------------------------------------------------------------------------
     *
     * Diese Datei kann nach Wünschen angepasst werden.
     * Alternativ kann eine neue Config-Datei 'Vereinsapp_env.php'
     * als Kopie erstellt werden, welche dann ausschließlich die
     * Eigenschaften enthält, die verändert werden sollen.
     */

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
    public $vereinsapp_logo = 'images/title.png';

    /**
     * --------------------------------------------------------------------------
     * Module (Controller)
     * --------------------------------------------------------------------------
     *
     * Aktive Module (Controller) inkl. Beschriftung und Symbol
     */
    public $controllers = array(
        'einstellungen' => array ( 'beschriftung' => 'Einstellungen', 'symbol' => SYMBOLE['einstellungen']['bootstrap'] ),
        'mitglieder' => array ( 'beschriftung' => 'Mitglieder', 'symbol' => SYMBOLE['mitglieder']['bootstrap'] ),
        'aufgaben' => array ( 'beschriftung' => 'Aufgaben', 'symbol' => SYMBOLE['aufgaben']['bootstrap'] ),
        'termine' => array ( 'beschriftung' => 'Termine', 'symbol' => SYMBOLE['termine']['bootstrap'] ),
        'strafkatalog' => array ( 'beschriftung' => 'Strafkatalog', 'symbol' => SYMBOLE['strafkatalog']['bootstrap'] ),
        'notenbank' => array ( 'beschriftung' => 'Notenbank', 'symbol' => SYMBOLE['notenbank']['bootstrap'] ),
        'startseite' => array ( 'beschriftung' => 'Willkommen', 'symbol' => SYMBOLE['startseite']['bootstrap'] ),
        'status' => array ( 'beschriftung' => 'Status', 'symbol' => SYMBOLE['einstellungen']['bootstrap'] ),
    );

    /**
     * Einträge im Menü
     */
    public $menue = array(
        array( 'typ' => 'controller', 'data' => 'termine' ),
        array( 'typ' => 'controller', 'data' => 'strafkatalog' ),
        array( 'typ' => 'controller', 'data' => 'notenbank' ),
        array( 'typ' => 'controller', 'data' => 'aufgaben' ),
        array( 'typ' => 'controller', 'data' => 'mitglieder' ),
        array( 'typ' => 'controller', 'data' => 'einstellungen' ),
        array( 'typ' => 'intern', 'data' => array( 'url' => 'logout', 'beschriftung' => 'Abmelden', 'symbol' => SYMBOLE['logout']['bootstrap'] ) ),
    );

    /**
     * --------------------------------------------------------------------------
     * Hauptinstanzen
     * --------------------------------------------------------------------------
     */
    public $hauptinstanzen = array(

        'mitglieder' => array(
            'liste' => 'mitglieder',
            // 'filtern' => array( array( 'operator' => '==', 'eigenschaft' => 'aktiv', 'wert' => '1' ), ),
            'sortieren' => array(
                array( 'eigenschaft' => 'nachname', 'richtung' => SORT_ASC, ),
                array( 'eigenschaft' => 'vorname', 'richtung' => SORT_ASC, ),
                array( 'eigenschaft' => 'register', 'richtung' => SORT_ASC, ),
            ),
            // 'group-flush' => TRUE,
            // 'sortable' => TRUE,
            // 'link' => TRUE,
            // 'klasse_id' => array('btn_', 'bestaetigung_einfordern'),
            // 'title' => 'Titel für bspw. ein Modal',
            'beschriftung' => '<span class="eigenschaft" data-eigenschaft="vorname"></span> <span class="eigenschaft" data-eigenschaft="nachname"></span>',
            // 'vorschau' => array( 'register', 'geburtstag', 'alter', 'wohnort', 'auto', 'funktion' ),
            // 'views' => view( 'Termine/terminrueckmeldung_basiseigenschaften', array( 'mitglied_id' => ICH['id'] ) ),
            'zusatzsymbole' => array('geburtstag'),
            // 'checkliste' => 'vergebene_rechte',
            // 'gegen_liste' => 'termine',
            // 'gegen_element_id' => 42,
            // 'disabled' => array( 'liste' => 'liste','filtern' => array( array( 'verknuepfung' => '||', 'filtern' => $disabled_filtern, ), ), ),
            // 'bedingte_formatierung' => array( 'liste' => 'liste', 'klasse' => array(
            //     'text-success' => array( 'operator' => '==', 'eigenschaft' => 'status', 'wert' => '1' ),
            //     'text-danger' => array( 'operator' => '==', 'eigenschaft' => 'status', 'wert' => '2' ),
            // ), ),
            'werkzeugkasten' => array(
                'filtern' => array( 'klasse_id' => 'btn_filtern_modal_oeffnen', 'title' => 'Mitglieder filtern', ),
                'sortieren' => array( 'klasse_id' => 'btn_sortieren_modal_oeffnen', 'title' => 'Mitglieder sortieren', ),
            ),
            'listenstatistik' => array(),
        ),

        'verfuegbare_rechte' => array(
            'liste' => 'verfuegbare_rechte',
            'beschriftung' => '<span class="eigenschaft" data-eigenschaft="titel"></span>',
            // 'werkzeugkasten' => array(
            //     'filtern' => array( 'klasse_id' => 'btn_filtern_modal_oeffnen', 'title' => 'Verfügbare Rechte filtern', ),
            //     'sortieren' => array( 'klasse_id' => 'btn_sortieren_modal_oeffnen', 'title' => 'Verfügbare Rechte sortieren', ),
            // ),
            // 'listenstatistik' => array(),
        ),

        'vergebene_rechte' => array(
            'liste' => 'vergebene_rechte',
        ),

        'aufgaben' => array(
            'liste' => 'aufgaben',
            'sortieren' => array( array( 'eigenschaft' => 'titel', 'richtung' => SORT_ASC, ), ),
            'beschriftung' => '<span class="eigenschaft" data-eigenschaft="titel"></span>',
            'werkzeugkasten' => array(
                'filtern' => array( 'klasse_id' => 'btn_filtern_modal_oeffnen', 'title' => 'Aufgaben filtern', ),
                'sortieren' => array( 'klasse_id' => 'btn_sortieren_modal_oeffnen', 'title' => 'Aufgaben sortieren', ),
            ),
            'listenstatistik' => array(),
        ),

        'termine' => array(
            'liste' => 'termine',
            'filtern' => array(
                array( 'operator' => '>=', 'eigenschaft' => 'start', 'wert' => HEUTE ),
            ),
            'sortieren' => array(
                array( 'eigenschaft'=> 'start', 'richtung'=> SORT_ASC, ),
            ),
            'beschriftung' => '<span class="eigenschaft" data-eigenschaft="titel"></span>',
            'zusatzsymbole' => array('kategorie'),
            'werkzeugkasten' => array(
                'filtern' => array( 'klasse_id' => 'btn_filtern_modal_oeffnen', 'title' => 'Termine filtern', ),
                'sortieren' => array( 'klasse_id' => 'btn_sortieren_modal_oeffnen', 'title' => 'Termine sortieren', ),
            ),
            'listenstatistik' => array(),
        ),

        'terminrueckmeldungen' => array(
            'liste' => 'terminrueckmeldungen',
        ),

        'anwesenheiten' => array(
            'liste' => 'anwesenheiten',
        ),

        'strafkatalog' => array(
            'liste' => 'strafkatalog',
            'sortieren' => array(
                array( 'eigenschaft' => 'kategorie', 'richtung' => SORT_ASC, ),
                array( 'eigenschaft' => 'titel', 'richtung' => SORT_ASC, ),
                array( 'eigenschaft' => 'wert', 'richtung' => SORT_ASC, ),
            ),
            'beschriftung' => '<span class="eigenschaft" data-eigenschaft="titel"></span>',
            'werkzeugkasten' => array(
                'filtern' => array( 'klasse_id' => 'btn_filtern_modal_oeffnen', 'title' => 'Strafkatalog filtern', ),
                'sortieren' => array( 'klasse_id' => 'btn_sortieren_modal_oeffnen', 'title' => 'Strafkatalog sortieren', ),
            ),
            'listenstatistik' => array(),
        ),

        'kassenbuch' => array(
            'liste' => 'kassenbuch',
            'sortieren' => array(
                array( 'eigenschaft' => 'erstellung', 'richtung' => SORT_DESC, ),
                array( 'eigenschaft' => 'titel', 'richtung' => SORT_ASC, ),
                array( 'eigenschaft' => 'wert', 'richtung' => SORT_ASC, ),
            ),
            'beschriftung' => '<span class="eigenschaft" data-eigenschaft="titel"></span>',
            'zusatzsymbole' => array('offen_erledigt'),
            'bedingte_formatierung' => array( 'klasse' => array( 'text-danger' => array( 'operator' => '<=', 'eigenschaft' => 'wert', 'wert' => 0 ), ), 'eigenschaft' => 'wert', ),
            'werkzeugkasten' => array(
                'filtern' => array( 'klasse_id' => 'btn_filtern_modal_oeffnen', 'title' => 'Kassenbuch filtern', ),
                'sortieren' => array( 'klasse_id' => 'btn_sortieren_modal_oeffnen', 'title' => 'Kassenbuch sortieren', ),
            ),
            'listenstatistik' => array( 'summe' => 'wert', ),
        ),

        'notenbank' => array(
            'liste' => 'notenbank',
            'sortieren' => array(
                array( 'eigenschaft' => 'titel_nr', 'richtung' => SORT_ASC, ),
                array( 'eigenschaft' => 'titel', 'richtung' => SORT_ASC, ),
                array( 'eigenschaft' => 'kategorie', 'richtung' => SORT_ASC, ),
            ),
            'beschriftung' => '[<span class="eigenschaft" data-eigenschaft="titel_nr"></span>] <span class="eigenschaft" data-eigenschaft="titel"></span>',
            'werkzeugkasten' => array(
                'filtern' => array( 'klasse_id' => 'btn_filtern_modal_oeffnen', 'title' => 'Notenbank filtern', ),
                'sortieren' => array( 'klasse_id' => 'btn_sortieren_modal_oeffnen', 'title' => 'Notenbank sortieren', ),
            ),
            'listenstatistik' => array(),
        ),

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
            'id' => array( 'beschriftung' => 'ID', 'typ' => 'zahl' ),
            'email' => array( 'beschriftung' => 'Email', 'typ' => 'text' ), // PHP
            'vorname' => array( 'beschriftung' => 'Vorname', 'typ' => 'text' ),
            'nachname' => array( 'beschriftung' => 'Nachname', 'typ' => 'text' ),
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
            'erstellung' => array( 'beschriftung' => 'Erstellung', 'typ' => 'zeitpunkt' ),                  // PHP
            'letzte_aktivitaet' => array( 'beschriftung' => 'Letzte Aktivität', 'typ' => 'zeitpunkt' ),     // PHP
            'passwort_alt' => array( 'beschriftung' => 'Altes Passwort', 'typ' => 'text' ),                 // PHP
            'passwort_neu' => array( 'beschriftung' => 'Neues Passwort', 'typ' => 'text' ),                 // PHP
            'passwort_neu2' => array( 'beschriftung' => 'Neues Passwort (Wiederholung)', 'typ' => 'text' ), // PHP
        ),

        'verfuegbare_rechte' => array(
            'id' => array( 'beschriftung' => 'ID', 'typ' => 'zahl' ),               // PHP
            'permission' => array( 'beschriftung' => 'Recht', 'typ' => 'text' ),    // PHP
            'titel' => array( 'beschriftung' => 'Titel', 'typ' => 'text' ),  // PHP
        ),

        'vergebene_rechte' => array(
            'id' => array( 'beschriftung' => 'ID', 'typ' => 'zahl' ),                                      // PHP
            'mitglied_id' => array( 'beschriftung' => 'Mitglied-ID', 'typ' => 'zahl' ),                     // PHP
            'verfuegbares_recht_id' => array( 'beschriftung' => 'Verfuegbares-Recht-ID', 'typ' => 'zahl' ), // PHP
        ),

        'aufgaben' => array(
            'id' => array( 'beschriftung' => 'ID', 'typ' => 'zahl' ),
            'zugeordnete_liste' => array( 'beschriftung' => 'Zugeordnete Liste', 'typ' => 'vorgegebene_werte' ),
            'zugeordnete_element_id' => array( 'beschriftung' => 'Zugeordnete Element-ID', 'typ' => 'zahl' ),
            'zugeordnetes_element' => array( 'beschriftung' => 'Zugeordnetes Element', 'typ' => 'text' ), // JAVA
            'titel' => array( 'beschriftung' => 'Titel', 'typ' => 'text' ),
            'mitglied_id' => array( 'beschriftung' => 'Mitglied-ID', 'typ' => 'zahl' ),
            'erledigt' => array( 'beschriftung' => 'Erledigung', 'typ' => 'zeitpunkt' ),
            'erledigt_janein' => array( 'beschriftung' => 'Erledigt', 'typ' => 'vorgegebene_werte' ),       // JAVA
            'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'typ' => 'text' ),
            'erstellung' => array( 'beschriftung' => 'Erstellung', 'typ' => 'zeitpunkt' ),                  // PHP
        ),

        'termine' => array(
            'id' => array( 'beschriftung' => 'ID', 'typ' => 'zahl' ),
            'titel' => array( 'beschriftung' => 'Titel', 'typ' => 'text' ),
            'start' => array( 'beschriftung' => 'Beginn', 'typ' => 'zeitpunkt' ),
            'ort' => array( 'beschriftung' => 'Ort', 'typ' => 'text' ),
            'kategorie' => array( 'beschriftung' => 'Typ', 'typ' => 'vorgegebene_werte' ),
            'filtern_mitglieder' => array( 'beschriftung' => 'Personenkreis beschränken', 'typ' => 'text' ),
            'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'typ' => 'text' ),
            'ich_rueckgemeldet' => array( 'beschriftung' => 'Ich habe Rückmeldung gegeben', 'typ' => 'vorgegebene_werte' ), // JAVA
            'ich_terminrueckmeldung_id' => array( 'beschriftung' => 'Meine RÜckmeldung-ID', 'typ' => 'zahl' ),                    // JAVA
            'ich_eingeladen' => array( 'beschriftung' => 'Ich bin eingeladen', 'typ' => 'vorgegebene_werte' ),              // JAVA
        ),

        'terminrueckmeldungen' => array(
            'id' => array( 'beschriftung' => 'ID', 'typ' => 'zahl' ),
            'termin_id' => array( 'beschriftung' => 'Termin-ID', 'typ' => 'zahl' ),
            'mitglied_id' => array( 'beschriftung' => 'Mitglied-ID', 'typ' => 'zahl' ),
            'status' => array( 'beschriftung' => 'Status', 'typ' => 'zahl' ),
            'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'typ' => 'text' ),
        ),

        'anwesenheiten' => array(
            'id' => array( 'beschriftung' => 'ID', 'typ' => 'zahl' ),
            'termin_id' => array( 'beschriftung' => 'Termin-ID', 'typ' => 'zahl' ),
            'mitglied_id' => array( 'beschriftung' => 'Mitglied-ID', 'typ' => 'zahl' ),
            'status' => array( 'beschriftung' => 'Status', 'typ' => 'zahl' ),
            'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'typ' => 'text' ),
        ),

        'strafkatalog' => array(
            'id' => array( 'beschriftung' => 'ID', 'typ' => 'zahl' ),
            'titel' => array( 'beschriftung' => 'Titel', 'typ' => 'text' ),
            'wert' => array( 'beschriftung' => 'Wert (in Euro)', 'typ' => 'zahl' ),
            'kategorie' => array( 'beschriftung' => 'Kapitel', 'typ' => 'vorgegebene_werte' ),
            'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'typ' => 'text' ),
        ),

        'kassenbuch' => array(
            'id' => array( 'beschriftung' => 'ID', 'typ' => 'zahl' ),
            'titel' => array( 'beschriftung' => 'Titel', 'typ' => 'text' ),
            'wert' => array( 'beschriftung' => 'Wert (in Euro)', 'typ' => 'zahl' ),
            'mitglied_id' => array( 'beschriftung' => 'Mitglied-ID', 'typ' => 'zahl' ),
            'erledigt' => array( 'beschriftung' => 'Erledigung', 'typ' => 'zeitpunkt' ),
            'erledigt_janein' => array( 'beschriftung' => 'Erledigt', 'typ' => 'vorgegebene_werte' ),   // JAVA
            'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'typ' => 'text' ),
            'erstellung' => array( 'beschriftung' => 'Erstellung', 'typ' => 'zeitpunkt' ),              // PHP
        ),

        'notenbank' => array(
            'id' => array( 'beschriftung' => 'ID', 'typ' => 'zahl' ),
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

        ),

        'vergebene_rechte' => array(
        ),

        'aufgaben' => array(

            'zugeordnete_liste' => array(
                null => array( 'beschriftung' => 'Keine Liste zugeordnet' ),
                'mitglieder' => array( 'beschriftung' => LISTEN['mitglieder']['beschriftung'] ),
                'termine' => array( 'beschriftung' => LISTEN['termine']['beschriftung'] ),
                'notenbank' => array( 'beschriftung' => LISTEN['notenbank']['beschriftung'] ),
            ),

            'erledigt_janein' => JANEIN,

        ),

        'termine' => array(

            'kategorie' => array (
                'allgemein' => array( 'beschriftung' => 'Allgemein', 'symbol' => '' ),
                'auftritt' => array( 'beschriftung' => 'Auftritt', 'symbol' => '&#127930' ),
                'probe' => array( 'beschriftung' => 'Musikprobe', 'symbol' => '&#128218' ),
                'vorstandschaftssitzung' => array( 'beschriftung' => 'Vorstandschaftssitzung', 'symbol' => '&#128186' ),
            ),

            'ich_rueckgemeldet' => JANEIN,

            'ich_eingeladen' => JANEIN,
        ),

        'terminrueckmeldungen' => array(
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

            'erledigt_janein' => JANEIN,

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

        'aufgaben' => array(
            'zugeordnete_liste',
            // 'element_id',
            // 'mitglied_id',
            // 'erledigt',
            'erledigt_janein',
            // 'erstellung',
        ),

        'termine' => array(
            'start',
            'kategorie',
            'ich_rueckgemeldet',
            'ich_eingeladen',
        ),

        'terminrueckmeldungen' => array(
        ),

        'anwesenheiten' => array(
        ),

        'strafkatalog' => array(
            'wert',
            'kategorie',
        ),

        'kassenbuch' => array(
            'wert',
            'mitglied_id',
            'erledigt',
            'erledigt_janein',
            'erstellung',
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

        'aufgaben' => array(
            'zugeordnete_liste',
            'titel',
            'mitglied_id',
            'erledigt',
            'erledigt_janein',
            'erstellung',
        ),

        'termine' => array(
            'titel',
            'start',
            'ort',
            'kategorie',
        ),

        'terminrueckmeldungen' => array(
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
            'mitglied_id',
            'erledigt',
            'erledigt_janein',
            'erstellung',
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

        'aufgaben' => array(
            'zugeordnete_liste',
            'mitglied_id',
            'erledigt_janein',
        ),

        'termine' => array(
            'kategorie',
        ),

        'terminrueckmeldungen' => array(
        ),

        'anwesenheiten' => array(
        ),

        'strafkatalog' => array(
            'kategorie',
        ),

        'kassenbuch' => array(
            'erledigt_janein',
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
    public $termine_terminrueckmeldung_frist = 0;

    /**
     * --------------------------------------------------------------------------
     * Notenbank Verzeichnis Anzahl Ziffern
     * --------------------------------------------------------------------------
     *
     * Anzahl der Ziffern zu Beginn des Verzeichnis-Namens im storage
     * (Ziffern entsprechen der Titel-Nr. und damit orientiert sich die Anzahl
     * der Ziffern an der Größe der Notenbank)
     * Bsp.: storage/notenbank/verzeichnis.pdf
     */
    public $notenbank_verzeichnis = '';

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
    public $ajax_zykluszeit = 15;
    
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
     * Winterzeit: +01:00 / Sommerzeit: +02:00
     */
    public $force_localstorage_reset_zeitpunkt = '2024-01-31T00:00:00.000+01:00';

}
