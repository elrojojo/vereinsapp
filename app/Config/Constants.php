<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);        // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);          // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);         // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);   // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);  // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);     // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);       // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);      // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);    // highest automatically-assigned error code

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_LOW instead.
 */
define('EVENT_PRIORITY_LOW', 200);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_NORMAL instead.
 */
define('EVENT_PRIORITY_NORMAL', 100);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_HIGH instead.
 */
define('EVENT_PRIORITY_HIGH', 10);

/*
|--------------------------------------------------------------------------
| VEREINSAPP Projekt-übergreifende Konstanten
|--------------------------------------------------------------------------*/

defined('DATENACHUTZ_RICHTLINIE_DATUM') OR define( 'DATENACHUTZ_RICHTLINIE_DATUM', 20210629 );

// defined('STATUSMELDUNGEN') OR define( 'STATUSMELDUNGEN', array(
// 	'email_fehlgeschlagen' => array( 'meldung' => 'Es ist ein Fehler beim Email-Versand aufgetreten. Nimm bitte Kontakt mit den dir bekannten Ansprechpersonen auf!' ),
// 	'speichern_erfolgreich' => array( 'meldung' => ' erfolgreich gespeichert.' ),
// 	'speichern_fehlgeschlagen' => array( 'meldung' => 'Es ist ein Fehler aufgetreten. Es wurde nicht gespeichert!' ),
// 	'loeschen_erfolgreich' => array( 'meldung' => ' wurde gelöscht!' ),
// ) );

defined('JANEIN') OR define( 'JANEIN', array(
	0 => array( 'beschriftung' => 'Nein' ),
	1 => array( 'beschriftung' => 'Ja' ),
) );


// defined('MONATE') OR define( 'MONATE', array( // mit 1 beignnen
// 	1 => array( 'Jan.', 'Januar' ),
// 	2 => array( 'Feb.', 'Februar' ),
// 	3 => array( 'März', 'März' ),
// 	4 => array( 'Apr.', 'April' ),
// 	5 => array( 'Mai', 'Mai' ),
// 	6 => array( 'Juni', 'Juni' ),
// 	7 => array( 'Juli', 'Juli' ),
// 	8 => array( 'Aug.', 'August' ),
// 	9 => array( 'Sept.', 'September' ),
//  10 => array( 'Okt.', 'Oktober' ),
//  11 => array( 'Nov.', 'November' ),
//  12 => array( 'Dez.', 'Dezember' ),
// ) );

defined('WOCHENTAGE') OR define( 'WOCHENTAGE', array(
	1 => array( 'kurz' => 'Mo.', 'lang' => 'Montag' ),
	2 => array( 'kurz' => 'Di.', 'lang' => 'Dienstag' ),
	3 => array( 'kurz' => 'Mi.', 'lang' => 'Mittwoch' ),
	4 => array( 'kurz' => 'Do.', 'lang' => 'Donnnerstag' ),
	5 => array( 'kurz' => 'Fr.', 'lang' => 'Freitag' ),
	6 => array( 'kurz' => 'Sa.', 'lang' => 'Samstag' ),
	7 => array( 'kurz' => 'So.', 'lang' => 'Sonntag' ),
) );

defined('SYMBOLE') OR define( 'SYMBOLE', array(
  'werkzeuge' => array( 'bootstrap' => 'tools' ),
  'aendern' => array( 'bootstrap' => 'pencil' ),
  'erstellen' => array( 'bootstrap' => 'plus-lg' ),
  'duplizieren' => array( 'bootstrap' => 'files' ),
  'loeschen' => array( 'bootstrap' => 'trash' ),

  'sortable' => array( 'bootstrap' => 'arrow-down-up' ),
  'collapse' => array( 'bootstrap' => 'caret-down' ),
  'sortieren' => array( 'bootstrap' => 'sort-down' ),
  'asc' => array( 'bootstrap' => 'sort-alpha-down' ),
  'desc' => array( 'bootstrap' => 'sort-alpha-up' ),
  'filtern' => array( 'bootstrap' => 'funnel' ),
  // 'listen' => array( 'bootstrap' => 'list-ul' ),
  // 'liste_speichern' => array( 'bootstrap' => 'list-ol' ),

  // 'speichern' => array( 'bootstrap' => 'check-circle' ),

  'einstellungen' => array( 'bootstrap' => 'gear' ),
  // 'mitglied' => array( 'bootstrap' => 'person' ),
  'bemerkung' => array( 'bootstrap' => 'chat-dots' ),
  'info' => array( 'bootstrap' => 'info-circle' ),
  // 'link' => array( 'bootstrap' => 'link-45deg' ),
  // 'email' => array( 'bootstrap' => 'envelope' ),

  'Anwesenheiten_pruefen' => array( 'bootstrap' => 'person-check' ),
  'personenkreis_beschraenken' => array( 'bootstrap' => 'person-lock' ),

  'abwesend' => array( 'html' => '&#9992' ),
  'geburtstag' => array( 'bootstrap' => 'gift', 'html' => '&#127873' ),
  // 'gesperrt' => array( 'bootstrap' => 'x-octagon', 'html' => '&#128683' ),

  'datum' => array( 'bootstrap' => 'calendar-event' ),
  'zeitraum' => array( 'bootstrap' => 'calendar-range' ),
  // 'uhrzeit' => array( 'bootstrap' => 'clock' ),
  'ort' => array( 'bootstrap' => 'geo-alt-fill' ),
  'zahlenraum' => array( 'bootstrap' => '123' ),

  // 'waehrung' => array( 'bootstrap' => 'currency-euro' ),

  'sichtbar' => array( 'bootstrap' => 'eye' ),
  'unsichtbar' => array( 'bootstrap' => 'eye-slash' ),

  // 'verzeichnis_oeffnen' => array( 'bootstrap' => 'folder-symlink' ),
  'pdf' => array( 'bootstrap' => 'file-earmark-pdf' ),
  'noten' => array( 'bootstrap' => 'file-earmark-music' ),
  'audio' => array( 'bootstrap' => 'play-btn' ),
  'verzeichnis' => array( 'bootstrap' => 'folder' ),


  // 'ebene_hoch' => array( 'bootstrap' => 'arrow-90deg-up' ),
  // 'ebene_runter' => array( 'bootstrap' => 'arrow-90deg-down' ),
  // 'haken' => array( 'bootstrap' => 'check2-circle' ),
  // 'kein_haken' => array( 'bootstrap' => 'circle' ),
) );

// defined('FARBEN') OR define( 'FARBEN', array(
//  'blau' => array( 'bootstrap' => 'primary' ),
//  'grün' => array( 'bootstrap' => 'success' ),
//  'rot' => array( 'bootstrap' => 'danger' ),
//  'gelb' => array( 'bootstrap' => 'warning' ),
//  'grau' => array( 'bootstrap' => 'secondary' ),
// ) );

defined('CONTROLLERS') OR define('CONTROLLERS', array(
  'startseite' => array ( 'titel' => 'Willkommen', 'symbol' => '', 'absprung' => array( 'index', ), ),
  'termine' => array ( 'titel' => 'Termine', 'symbol' => 'calendar-month', 'absprung' => array( 'index', 'details', 'anwesenheiten', ), ),
  'strafkatalog' => array ( 'titel' => 'Strafkatalog', 'symbol' => 'piggy-bank', 'absprung' => array( 'index', 'kassenbuch' ), ),
  'notenbank' => array ( 'titel' => 'Notenbank', 'symbol' => 'file-earmark-music', 'absprung' => array( 'index', 'titel', 'bewertung_notenverzeichnis', ), ),
  'umfragen' => array ( 'titel' => 'Umfragen', 'symbol' => 'signpost-split', 'absprung' => array( 'index', ), ), //stoplights   signpost-split
  'mitglieder' => array ( 'titel' => 'Mitglieder', 'symbol' => 'people', 'absprung' => array( 'index', 'details' ), ),
  'einstellungen' => array ( 'titel' => 'Einstellungen', 'symbol' => SYMBOLE['einstellungen']['bootstrap'], 'absprung' => array( 'index', ), ),

  'status' => array ( 'titel' => 'Status', 'symbol' => SYMBOLE['einstellungen']['bootstrap'], 'absprung' => array(), ),
) );

// defined('AUDIOFORMATE') OR define( 'AUDIOFORMATE', array( 'mp3', 'm4a' ) );

// defined('SEK_PRO_JAHR') OR define( 'SEK_PRO_JAHR', 31556926 );  // 31558152 // 31558149 // 31556926

// defined('SEK_PRO_WOCHE') OR define( 'SEK_PRO_WOCHE', 60*60*24*7 );

// defined('HEUTE') OR define( 'HEUTE', strtotime ( date( 'd.m.Y', time() ).' 00:00:00' ) );
// defined('MORGEN') OR define( 'MORGEN', HEUTE+60*60*24 );
// if( date('N', time() ) == 1 ) { defined('LETZTER_MONTAG') OR define( 'LETZTER_MONTAG', HEUTE ); }
// else { defined('LETZTER_MONTAG') OR define( 'LETZTER_MONTAG', strtotime('last monday') ); }
// defined('NAECHSTER_MONTAG') OR define( 'NAECHSTER_MONTAG', LETZTER_MONTAG + SEK_PRO_WOCHE );
// defined('UEBERNAECHSTER_MONTAG') OR define( 'UEBERNAECHSTER_MONTAG', NAECHSTER_MONTAG + SEK_PRO_WOCHE );

defined('SQL_TIME') OR define( 'SQL_TIME', 'HH:mm:ss' );
defined('SQL_DATE') OR define( 'SQL_DATE', 'yyyy-MM-dd' );
defined('SQL_DATETIME') OR define( 'SQL_DATETIME', 'yyyy-MM-dd HH:mm:ss' );

defined('AJAX_REFRESH_INTERVALL') OR define( 'AJAX_REFRESH_INTERVALL', 10 );

/*
|--------------------------------------------------------------------------
| VEREINSAPP Projekt-spezifische Konstanten
|--------------------------------------------------------------------------*/

$einstellungen = array();
$eigenschaften = array();
$vorgegebene_werte = array();

defined('AKTIVE_CONTROLLER') OR define('AKTIVE_CONTROLLER', array(
  'startseite',
  'termine',
  //'strafkatalog',
  'notenbank',
  'mitglieder',
  'einstellungen',
) );

$menue = AKTIVE_CONTROLLER;
unset($menue[array_search('startseite', $menue)]); 
defined('MENUE') OR define('MENUE', $menue );

defined('OFFIZIELLER_NAME') OR define( 'OFFIZIELLER_NAME', 'Eingetragener Verein e.V.' );
defined('VEREINSAPP_NAME') OR define( 'VEREINSAPP_NAME', 'Eingetragener Verein e.V. Vereinsapp' );  // Sollte generisch feminin sein
defined('OFFIZIELLE_WEBSITE') OR define( 'OFFIZIELLE_WEBSITE', 'https://www.eingetragener-verein.de' );
//defined('OFFIZIELLE_MAILADRESSE') OR define( 'OFFIZIELLE_MAILADRESSE', 'vereinsapp@eingetragener-verein.de' );

defined('MITGLIEDER_ABWESENHEITEN_BEMERKUNG_STANDARD') OR define( 'MITGLIEDER_ABWESENHEITEN_BEMERKUNG_STANDARD', 'Mitglied hat eine Abwesenheit aktiviert!' );


// $einstellungen['startseite']['logo_anzeigen'] = array( 'titel' => 'Logo anzeigen',
//   'werte' => array(
//     'nein' => 'nein',
//     'ja' => 'ja',
//     ),
//   'standardwert' => 'ja',
// );

//#############################################################################################################
$eigenschaften['mitglieder']['mitglieder'] = array(
  'email' => array( 'beschriftung' => 'Email', 'typ' => 'text', 'standard' => '', ),
  
  'vorname' => array(  'beschriftung' => 'Vorname', 'typ' => 'text', 'standard' => '', ),
  'nachname' => array(  'beschriftung' => 'Nachname', 'typ' => 'text', 'standard' => '', ),

  'geburt' => array( 'beschriftung' => 'Geboren am', 'typ' => 'zeitpunkt', 'standard' => date( 'Y-m-d H:i:s', time(), ), ),
  'geburtstag' => array( 'beschriftung' => 'Geburtstag', 'typ' => 'zeitpunkt', 'standard' => date( 'Y-m-d H:i:s', time(), ), ),  // JAVA
  'alter' => array( 'beschriftung' => 'Alter', 'typ' => 'zahl', 'standard' => '', ),  // JAVA
  'alter_geburtstag' => array( 'beschriftung' => 'Nächstes Alter', 'typ' => 'zahl', 'standard' => '', ),  // JAVA

  'postleitzahl' => array( 'beschriftung' => 'PLZ', 'typ' => 'text', 'standard' => '', ),
  'wohnort' => array( 'beschriftung' => 'Wohnort', 'typ' => 'text', 'standard' => '', ),

  'geschlecht' => array( 'beschriftung' => 'Geschlecht', 'typ' => 'vorgegebene_werte', 'standard' => 'd', ),
  'register' => array( 'beschriftung' => 'Instrument', 'typ' => 'vorgegebene_werte', 'standard' => 'ohne', ),
  'funktion' => array( 'beschriftung' => 'Funktion', 'typ' => 'vorgegebene_werte', 'standard' => 'ohne', ),
  'vorstandschaft' => array( 'beschriftung' => 'Vorstandschaft', 'typ' => 'vorgegebene_werte', 'standard' => 0, ),
  'aktiv' => array( 'beschriftung' => 'Aktiv', 'typ' => 'vorgegebene_werte', 'standard' => 1, ),

  'abwesend' => array( 'beschriftung' => 'Abwesend', 'typ' => 'vorgegebene_werte', 'standard' => 0, ),  // JAVA
);

$eigenschaften['mitglieder']['abwesenheiten'] = array(
  'start' => array( 'beschriftung' => 'Beginn', 'typ' => 'zeitpunkt', 'standard' => date( 'Y-m-d', time(), ), ),
  'ende' => array( 'beschriftung' => 'Ende', 'typ' => 'zeitpunkt', 'standard' => date( 'Y-m-d', time(), ), ),
  'mitglied_id' => array( 'beschriftung' => 'Mitglied-ID', 'typ' => 'zahl', 'standard' => '', ),
  'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'typ' => 'text', 'standard' => '', ),
);


defined('MITGLIEDER_EIGENSCHAFTEN_VORSCHAU') OR define( 'MITGLIEDER_EIGENSCHAFTEN_VORSCHAU', array(
  'register',
  'geburtstag',
  'alter',
  'wohnort',
  'funktion',
) );


$sortierbare_eigenschaften['mitglieder'] = array(  
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
);

$sortierbare_eigenschaften['abwesenheiten'] = array(  
  'start',
  'ende',
);

$filterbare_eigenschaften['mitglieder'] = array(  
  'geburt',
  'geburtstag',
  'alter',
  'geschlecht',
  'register',
  'funktion',
  'vorstandschaft',
  'aktiv',
  'abwesend',
);

$filterbare_eigenschaften['abwesenheiten'] = array(  
  'start',
  'ende',
);

$vorgegebene_werte['mitglieder'] = array(
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
);

//defined('MITGLIEDER_GEBURTSTAG_STANDARD_PRE') OR define( 'MITGLIEDER_GEBURTSTAG_STANDARD_PRE', 'Mitglied hat den ' );
//defined('MITGLIEDER_GEBURTSTAG_STANDARD_POST') OR define( 'MITGLIEDER_GEBURTSTAG_STANDARD_POST', '. Geburtstag!' );
//defined('MITGLIEDER_GESPERRT_STANDARD') OR define( 'MITGLIEDER_GESPERRT_STANDARD', 'Der Zugang des Mitglieds ist gesperrt!' );


//#############################################################################################################
$eigenschaften['termine']['termine'] = array(
  'titel' => array( 'beschriftung' => 'Titel', 'typ' => 'text', 'standard' => '', ),
  // 'organisator' => array( 'beschriftung' => 'Organisator', 'typ' => 'text', 'standard' => '', ),

  'start' => array( 'beschriftung' => 'Beginn', 'typ' => 'zeitpunkt', 'standard' => date( 'Y-m-d H:i:s', time(), ), ),
  'ort' => array( 'beschriftung' => 'Ort', 'typ' => 'text', 'standard' => '', ),

  'kategorie' => array( 'beschriftung' => 'Typ', 'typ' => 'vorgegebene_werte', 'standard' => 'allgemein', ),
  'filtern_mitglieder' => array( 'beschriftung' => 'Personenkreis beschränken', 'typ' => 'text', 'standard' => '', ),
  // 'setlist' => array( 'beschriftung' => 'Setlist', 'typ' => 'text', 'standard' => '', ),
  'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'typ' => 'text', 'standard' => '', ),

  'ich_rueckmeldung_id' => array( 'beschriftung' => 'Meine Rückmeldung-ID', 'typ' => 'zahl', 'standard' => '', ),  // JAVA
  'ich_eingeladen' => array( 'beschriftung' => 'Ich bin eingeladen.', 'typ' => 'zahl', 'standard' => '', ),  // JAVA
);

$eigenschaften['termine']['rueckmeldungen'] = array(
  'termin_id' => array( 'beschriftung' => 'Termin-ID', 'typ' => 'zahl', 'standard' => '', ),
  'mitglied_id' => array( 'beschriftung' => 'Mitglied-ID', 'typ' => 'zahl', 'standard' => '', ),
  'status' => array( 'beschriftung' => 'Status', 'typ' => 'zahl', 'standard' => '', ),
  'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'typ' => 'text', 'standard' => '', ),
);

$eigenschaften['termine']['anwesenheiten'] = array(
  'termin_id' => array( 'beschriftung' => 'Termin-ID', 'typ' => 'zahl', 'standard' => '', ),
  'mitglied_id' => array( 'beschriftung' => 'Mitglied-ID', 'typ' => 'zahl', 'standard' => '', ),
  'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'typ' => 'text', 'standard' => '', ),
);

$sortierbare_eigenschaften['termine'] = array(  
  'titel',
  'start',
  'ort',
  'kategorie',
);

$filterbare_eigenschaften['termine'] = array(  
  'start',
  'kategorie',
);

$vorgegebene_werte['termine'] = array(
  'kategorie' => array (
    'allgemein' => array( 'beschriftung' => 'Allgemein', 'symbol' => '', 'filtern_mitglieder_standard' => array() ),
    'auftritt' => array( 'beschriftung' => 'Auftritt', 'symbol' => '&#127930', 'filtern_mitglieder_standard' => array( 'aktiv' => array( 0, ), ), ),
    'musikprobe' => array( 'beschriftung' => 'Musikprobe', 'symbol' => '&#128218', 'filtern_mitglieder_standard' => array( 'aktiv' => array( 0, ), ), ),
    //'vorstandschaftssitzung' => array( 'beschriftung' => 'Vorstandschaftssitzung', 'symbol' => '<img class="title" src="images/vorstandschaftssitzung.png" width="30" />', 'filtern_mitglieder_standard' => array( 'vorstandschaft' => array( 0, ), ), ),
  ),
);

// defined('TERMINE_RUECKMELDUNG_FRIST') OR define( 'TERMINE_RUECKMELDUNG_FRIST', 0 );

// LÖSCHEN defined('TERMINE_EIGENSCHAFTEN_filtern_mitglieder') OR define( 'TERMINE_EIGENSCHAFTEN_FILTERN_MITGLIEDER', array( 'register', 'funktion', 'vorstandschaft', 'aktiv', ) );

// LÖSCHEN defined('TERMINE_ANWESENHEITSKONTROLLE') OR define( 'TERMINE_ANWESENHEITSKONTROLLE', TRUE );

// LÖSCHEN defined('TERMINE_RUECKMELDUNG_DETAIL_FREWILLIG') OR define( 'TERMINE_RUECKMELDUNG_DETAIL_FREWILLIG', TRUE ); // Absage und Zusage Freiwillig!
// LÖSCHEN defined('TERMINE_RUECKMELDUNG_DETAIL_ABSAGE') OR define( 'TERMINE_RUECKMELDUNG_DETAIL_ABSAGE', FALSE );  // Absage als Zwang!

// defined('TERMINE_SETLISTS') OR define( 'TERMINE_SETLISTS', array( 'auftritt' ) );

// $einstellungen['termine']['ich_beschr_anzeigen'] = array( 'titel' => 'Termine ohne Einladung',
//   'werte' => array(
//     0 => 'ausblenden',
//     1 => 'anzeigen',
//     ),
//   'standardwert' => 0,
// );
// $einstellungen['termine']['vergangen_anzeigen'] = array( 'titel' => 'Vergangene Termine',
//   'werte' => array(
//     0 => 'ausblenden',
//     1 => 'anzeigen',
//     ),
//   'standardwert' => 0,
// );

//#############################################################################################################
$eigenschaften['strafkatalog']['strafkatalog'] = array(
  // 'grund' => array( 'beschriftung' => 'Grund', 'typ' => 'text', ),
  // 'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'typ' => 'text', ),
  // 'kapitel_id' => array( 'beschriftung' => 'Kapitel', 'typ' => 'id', ),
  // 'betrag' => array( 'beschriftung' => 'Betrag', 'typ' => 'zahl', ),
);

//#############################################################################################################
$eigenschaften['notenbank']['notenbank'] = array(
  'titel' => array( 'beschriftung' => 'Titel', 'typ' => 'text', 'standard' => '', ),
  'titel_nr' => array( 'beschriftung' => 'Titel-Nr.', 'typ' => 'zahl', 'standard' => '', ),

  'kategorie' => array( 'beschriftung' => 'Genre', 'typ' => 'vorgegebene_werte', 'standard' => 'ohne', ),
  'verzeichnis' => array( 'beschriftung' => 'Verzeichnis', 'typ' => 'text', 'standard' => '', ),
  'anzahl_noten' => array( 'beschriftung' => 'Anzahl Noten', 'typ' => 'zahl', 'standard' => 0, ), // JAVA
  'anzahl_audio' => array( 'beschriftung' => 'Anzahl Audio', 'typ' => 'zahl', 'standard' => 0, ), // JAVA
  'anzahl_verzeichnis' => array( 'beschriftung' => 'Anzahl Verzeichnisse', 'typ' => 'zahl', 'standard' => 0, ), // JAVA
);

$sortierbare_eigenschaften['notenbank'] = array(  
  'titel',
  'titel_nr',
  'kategorie',
  'anzahl_noten',
  'anzahl_audio',
  'anzahl_verzeichnis',
);

$filterbare_eigenschaften['notenbank'] = array(  
  'titel_nr',
  'kategorie',
  'anzahl_noten',
  'anzahl_audio',
  'anzahl_verzeichnis',
);

defined('TERMINE_CLUSTERBARE_EIGENSCHAFTEN') OR define( 'TERMINE_CLUSTERBARE_EIGENSCHAFTEN', array(
  // 'titel',
  // 'organisator',
  // 'start',
  // 'ort',
  // 'typ',
) );

$vorgegebene_werte['notenbank'] = array(
  'kategorie' => array (
    'ohne' => array( 'beschriftung' => 'Ohne Zuordnung', ),
    'modern' => array( 'beschriftung' => 'Modern', ),
    'klassik' => array( 'beschriftung' => 'Klassik', ),
    'kirche' => array( 'beschriftung' => 'Kirche', ),
    'volkstuemlich' => array( 'beschriftung' => 'Volkstümlich', ),
  ),
);

defined('NOTENVERZEICHNIS_PDF') OR define( 'NOTENVERZEICHNIS_PDF', null );//'storage/notenbank/notenverzeichnis.pdf' );
defined('NOTENVERZEICHNIS_VERZEICHNIS_ANZAHL_ZIFFERN') OR define( 'NOTENVERZEICHNIS_VERZEICHNIS_ANZAHL_ZIFFERN', 2 );
defined('NOTENVERZEICHNIS_VERZEICHNIS_ERLAUBTE_DATEITYPEN') OR define( 'NOTENVERZEICHNIS_VERZEICHNIS_ERLAUBTE_DATEITYPEN', array( 'pdf' ) );


//#############################################################################################################
// defined('EINSTELLUNGEN') OR define( 'EINSTELLUNGEN', $einstellungen );
defined('EIGENSCHAFTEN') OR define( 'EIGENSCHAFTEN', $eigenschaften );
defined('SORTIERBARE_EIGENSCHAFTEN') OR define( 'SORTIERBARE_EIGENSCHAFTEN', $sortierbare_eigenschaften );
defined('FILTERBARE_EIGENSCHAFTEN') OR define( 'FILTERBARE_EIGENSCHAFTEN', $filterbare_eigenschaften );
defined('VORGEGEBENE_WERTE') OR define( 'VORGEGEBENE_WERTE', $vorgegebene_werte );