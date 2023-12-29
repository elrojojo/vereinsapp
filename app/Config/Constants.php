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

defined('JANEIN') OR define( 'JANEIN', array(
	0 => array( 'beschriftung' => 'Nein' ),
	1 => array( 'beschriftung' => 'Ja' ),
) );

defined('WOCHENTAGE_KURZ') OR define( 'WOCHENTAGE_KURZ', array(
	1 => array( 'beschriftung' => 'Mo.' ),
	2 => array( 'beschriftung' => 'Di.' ),
	3 => array( 'beschriftung' => 'Mi.' ),
	4 => array( 'beschriftung' => 'Do.' ),
	5 => array( 'beschriftung' => 'Fr.' ),
	6 => array( 'beschriftung' => 'Sa.' ),
	7 => array( 'beschriftung' => 'So.' ),
) );

defined('WOCHENTAGE_LANG') OR define( 'WOCHENTAGE_LANG', array(
	1 => array( 'beschriftung' => 'Montag' ),
	2 => array( 'beschriftung' => 'Dienstag' ),
	3 => array( 'beschriftung' => 'Mittwoch' ),
	4 => array( 'beschriftung' => 'Donnnerstag' ),
	5 => array( 'beschriftung' => 'Freitag' ),
	6 => array( 'beschriftung' => 'Samstag' ),
	7 => array( 'beschriftung' => 'Sonntag' ),
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


  'einstellungen' => array( 'bootstrap' => 'gear' ),
  'bemerkung' => array( 'bootstrap' => 'chat-dots' ),
  'info' => array( 'bootstrap' => 'info-circle' ),
  // 'link' => array( 'bootstrap' => 'link-45deg' ),
  // 'email' => array( 'bootstrap' => 'envelope' ),

  'anwesenheiten_dokumentieren' => array( 'bootstrap' => 'person-check' ),
  'filtern_mitglieder' => array( 'bootstrap' => 'person-gear' ),

  'abwesend' => array( 'html' => '&#9992' ),
  'geburtstag' => array( 'bootstrap' => 'gift', 'html' => '&#127873' ),

  'datum' => array( 'bootstrap' => 'calendar-event' ),
  'zeitraum' => array( 'bootstrap' => 'calendar-range' ),
  'ort' => array( 'bootstrap' => 'geo-alt-fill' ),
  'zahlenraum' => array( 'bootstrap' => '123' ),

  'sichtbar' => array( 'bootstrap' => 'eye' ),
  'unsichtbar' => array( 'bootstrap' => 'eye-slash' ),

  'pdf' => array( 'bootstrap' => 'file-earmark-pdf' ),
  'mp3' => array( 'bootstrap' => 'file-play' ),
  'm4a' => array( 'bootstrap' => 'file-play' ),
  'noten' => array( 'bootstrap' => 'file-earmark-music' ),
  'audio' => array( 'bootstrap' => 'play-btn' ),
  'verzeichnis' => array( 'bootstrap' => 'folder' ),
  'verzeichnis_basis' => array( 'bootstrap' => 'folder-symlink' ),
) );

defined('SQL_TIME') OR define( 'SQL_TIME', 'HH:mm:ss' );
defined('SQL_TIME_REGEX') OR define( 'SQL_TIME_REGEX', '/^[0-9]{2}\:[0-9]{2}\:[0-9]{2}?$/' );
defined('SQL_DATE') OR define( 'SQL_DATE', 'yyyy-MM-dd' );
defined('SQL_DATE_REGEX') OR define( 'SQL_DATE_REGEX', '/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}?$/' );
defined('SQL_DATETIME') OR define( 'SQL_DATETIME', 'yyyy-MM-dd HH:mm:ss' );
defined('SQL_DATETIME_REGEX') OR define( 'SQL_DATETIME_REGEX', '/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}\ [0-9]{2}\:[0-9]{2}\:[0-9]{2}?$/' );

enum AJAX_ZUSTAND
{
    case VORBEREITET;
    case RAUS;
    case WARTEND;
    case REIN_FEHLER;
    case REIN_ERFOLG;
    case FERTIG;
}

/*
|--------------------------------------------------------------------------
| VEREINSAPP Projekt-spezifische Konstanten
|--------------------------------------------------------------------------*/

$eigenschaften = array();
$vorgegebene_werte = array();

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

$eigenschaften['mitglieder']['vergebene_rechte'] = array(
    'mitglied_id' => array( 'beschriftung' => 'Mitglied-ID', 'typ' => 'zahl', 'standard' => '', ),
    'verfuegbares_recht_id' => array( 'beschriftung' => 'Verfuegbares-Recht-ID', 'typ' => 'zahl', 'standard' => '', ),
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


//#############################################################################################################
$eigenschaften['termine']['termine'] = array(
  'titel' => array( 'beschriftung' => 'Titel', 'typ' => 'text', 'standard' => '', ),

  'start' => array( 'beschriftung' => 'Beginn', 'typ' => 'zeitpunkt', 'standard' => date( 'Y-m-d H:i:s', time(), ), ),
  'ort' => array( 'beschriftung' => 'Ort', 'typ' => 'text', 'standard' => '', ),

  'kategorie' => array( 'beschriftung' => 'Typ', 'typ' => 'vorgegebene_werte', 'standard' => 'allgemein', ),
  'filtern_mitglieder' => array( 'beschriftung' => 'Personenkreis beschränken', 'typ' => 'text', 'standard' => '', ),
  'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'typ' => 'text', 'standard' => '', ),

  'ich_rueckgemeldet' => array( 'beschriftung' => 'Ich habe Rückmeldung gegeben', 'typ' => 'vorgegebene_werte', 'standard' => '', ),  // JAVA
  'ich_eingeladen' => array( 'beschriftung' => 'Ich bin eingeladen.', 'typ' => 'vorgegebene_werte', 'standard' => '', ),  // JAVA
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
  'ich_rueckgemeldet',
);

$vorgegebene_werte['termine'] = array(
  'kategorie' => array (
    'allgemein' => array( 'beschriftung' => 'Allgemein', 'symbol' => '', 'filtern_mitglieder' => array() ),
    'auftritt' => array( 'beschriftung' => 'Auftritt', 'symbol' => '&#127930', 'filtern_mitglieder' => array( 'aktiv' => array( 0, ), ), ),
    'musikprobe' => array( 'beschriftung' => 'Musikprobe', 'symbol' => '&#128218', 'filtern_mitglieder' => array( 'aktiv' => array( 0, ), ), ),
    //'vorstandschaftssitzung' => array( 'beschriftung' => 'Vorstandschaftssitzung', 'symbol' => '<img class="title" src="images/vorstandschaftssitzung.png" width="30" />', 'filtern_mitglieder' => array( 'vorstandschaft' => array( 0, ), ), ),
  ),
  'ich_rueckgemeldet' => JANEIN,
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

$vorgegebene_werte['notenbank'] = array(
  'kategorie' => array (
    'ohne' => array( 'beschriftung' => 'Ohne Zuordnung', ),
    'modern' => array( 'beschriftung' => 'Modern', ),
    'klassik' => array( 'beschriftung' => 'Klassik', ),
    'kirche' => array( 'beschriftung' => 'Kirche', ),
    'volkstuemlich' => array( 'beschriftung' => 'Volkstümlich', ),
  ),
);

defined('NOTENVERZEICHNIS_ANZAHL_ZIFFERN') OR define( 'NOTENVERZEICHNIS_ANZAHL_ZIFFERN', 2 );
defined('NOTENVERZEICHNIS_ERLAUBTE_DATEITYPEN_NOTEN') OR define( 'NOTENVERZEICHNIS_ERLAUBTE_DATEITYPEN_NOTEN', array( 'pdf') );
defined('NOTENVERZEICHNIS_ERLAUBTE_DATEITYPEN_AUDIO') OR define( 'NOTENVERZEICHNIS_ERLAUBTE_DATEITYPEN_AUDIO', array( 'mp3', 'm4a' ) );


//#############################################################################################################
defined('EIGENSCHAFTEN') OR define( 'EIGENSCHAFTEN', $eigenschaften );
defined('SORTIERBARE_EIGENSCHAFTEN') OR define( 'SORTIERBARE_EIGENSCHAFTEN', $sortierbare_eigenschaften );
defined('FILTERBARE_EIGENSCHAFTEN') OR define( 'FILTERBARE_EIGENSCHAFTEN', $filterbare_eigenschaften );
defined('VORGEGEBENE_WERTE') OR define( 'VORGEGEBENE_WERTE', $vorgegebene_werte );