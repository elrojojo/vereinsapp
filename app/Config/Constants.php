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
    'startseite' => array ( 'bootstrap' => '' ),
    'termine' => array ( 'bootstrap' => 'calendar-month' ),
    'strafkatalog' => array ( 'bootstrap' => 'piggy-bank' ),
    'notenbank' => array ( 'bootstrap' => 'file-earmark-music' ),
    'umfragen' => array ( 'bootstrap' => 'signpost-split' ),
    'mitglieder' => array ( 'bootstrap' => 'people' ),
    'einstellungen' => array( 'bootstrap' => 'gear' ),

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

    'mitglied' => array ( 'bootstrap' => 'person' ),
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

    'einmal_link_anzeigen' => array( 'bootstrap' => 'link' ),
    'einmal_link_email' => array( 'bootstrap' => 'envelope' ),
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
