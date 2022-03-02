<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
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
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


/*
|--------------------------------------------------------------------------
| VEREINSAPP Projekt-übergreifende Konstanten
|--------------------------------------------------------------------------*/

defined('STATUSMELDUNGEN') OR define( 'STATUSMELDUNGEN', array(
	'email_fehlgeschlagen' => array( 'meldung' => 'Es ist ein Fehler beim Email-Versand aufgetreten. Nimm bitte Kontakt mit den dir bekannten Ansprechpersonen auf!' ),
	'speichern_erfolgreich' => array( 'meldung' => ' erfolgreich gespeichert.' ),
	'speichern_fehlgeschlagen' => array( 'meldung' => 'Es ist ein Fehler aufgetreten. Es wurde nicht gespeichert!' ),
	'loeschen_erfolgreich' => array( 'meldung' => ' wurde gelöscht!' ),
	)
  );

defined('JANEIN') OR define( 'JANEIN', array(
	0 => array( 'beschriftung' => 'Nein' ),
	1 => array( 'beschriftung' => 'Ja' ),
	)
  );


defined('MONATE') OR define( 'MONATE', array( // mit 1 beignnen
	0 => array( 'Jan.', 'Januar' ),
	1 => array( 'Feb.', 'Februar' ),
	2 => array( 'März', 'März' ),
	3 => array( 'Apr.', 'April' ),
	4 => array( 'Mai', 'Mai' ),
	5 => array( 'Juni', 'Juni' ),
	6 => array( 'Juli', 'Juli' ),
	7 => array( 'Aug.', 'August' ),
	8 => array( 'Sept.', 'September' ),
	9 => array( 'Okt.', 'Oktober' ),
   10 => array( 'Nov.', 'November' ),
   11 => array( 'Dez.', 'Dezember' ),
 )
);

defined('WOCHENTAGE') OR define( 'WOCHENTAGE', array(
	1 => array( 'Mo.', 'Montag' ),
	2 => array( 'Di.', 'Dienstag' ),
	3 => array( 'Mi', 'Mittwoch' ),
	4 => array( 'Do.', 'Donnnerstag' ),
	5 => array( 'Fr', 'Freitag' ),
	6 => array( 'Sa', 'Samstag' ),
	0 => array( 'So', 'Sonntag' ),
 )
);

defined('SYMBOLE') OR define( 'SYMBOLE', array(
 'aendern' => array( 'bootstrap' => 'pencil' ),
 'hinzufuegen' => array( 'bootstrap' => 'plus-lg' ),
 'duplizieren' => array( 'bootstrap' => 'files' ),
 'loeschen' => array( 'bootstrap' => 'trash' ),

 'sortieren' => array( 'bootstrap' => 'sort-down' ),
 'aufsteigend' => array( 'bootstrap' => 'sort-alpha-down' ),
 'absteigend' => array( 'bootstrap' => 'sort-alpha-down-alt' ),
 'filtern' => array( 'bootstrap' => 'funnel' ),

 'speichern' => array( 'bootstrap' => 'check-circle' ),

 'einstellungen' => array( 'bootstrap' => 'gear' ),
 'mitglied' => array( 'bootstrap' => 'person' ),
 'bemerkung' => array( 'bootstrap' => 'chat-dots' ),
 'info' => array( 'bootstrap' => 'info-circle' ),
 'link' => array( 'bootstrap' => 'link-45deg' ),
 'email' => array( 'bootstrap' => 'envelope' ),

 'abwesend' => array( 'html' => '&#9992' ),
 'geburtstag' => array( 'bootstrap' => 'gift', 'html' => '&#127873' ),
 'gesperrt' => array( 'bootstrap' => 'x-octagon', 'html' => '&#128683' ),

 'datum' => array( 'bootstrap' => 'calendar-event' ),
 'zeitraum' => array( 'bootstrap' => 'calendar-range' ),
 'uhrzeit' => array( 'bootstrap' => 'clock' ),
 'ort' => array( 'bootstrap' => 'geo-alt-fill' ),

 'waehrung' => array( 'bootstrap' => 'currency-euro' ),

 'play' => array( 'bootstrap' => 'play-btn' ),

 'sichtbar' => array( 'bootstrap' => 'eye' ),
 'unsichtbar' => array( 'bootstrap' => 'eye-slash' ),

 'verzeichnis' => array( 'bootstrap' => 'folder' ),
 'verzeichnis_oeffnen' => array( 'bootstrap' => 'folder-symlink' ),
 'noten' => array( 'bootstrap' => 'file-earmark-music' ),
 'pdf' => array( 'bootstrap' => 'file-earmark-pdf' ),

 'ebene_hoch' => array( 'bootstrap' => 'arrow-90deg-up' ),
 'ebene_runter' => array( 'bootstrap' => 'arrow-90deg-down' ),
 'haken' => array( 'bootstrap' => 'check2-circle' ),
 'kein_haken' => array( 'bootstrap' => 'circle' ),
 )
);

defined('FARBEN') OR define( 'FARBEN', array(
 'blau' => array( 'bootstrap' => 'primary' ),
 'grün' => array( 'bootstrap' => 'success' ),
 'rot' => array( 'bootstrap' => 'danger' ),
 'gelb' => array( 'bootstrap' => 'warning' ),
 'grau' => array( 'bootstrap' => 'secondary' ),
 )
);

defined('AUDIOFORMATE') OR define( 'AUDIOFORMATE', array( 'mp3', 'm4a' ) );

defined('SEK_PRO_JAHR') OR define( 'SEK_PRO_JAHR', 31556926 );  // 31558152 // 31558149 // 31556926

defined('SEK_PRO_WOCHE') OR define( 'SEK_PRO_WOCHE', 60*60*24*7 );

defined('HEUTE') OR define( 'HEUTE', strtotime ( date( 'd.m.Y', time() ).' 00:00:00' ) );
defined('MORGEN') OR define( 'MORGEN', HEUTE+60*60*24 );
if( date('N', time() ) == 1 ) { defined('LETZTER_MONTAG') OR define( 'LETZTER_MONTAG', HEUTE ); }
else { defined('LETZTER_MONTAG') OR define( 'LETZTER_MONTAG', strtotime('last monday') ); }
defined('NAECHSTER_MONTAG') OR define( 'NAECHSTER_MONTAG', LETZTER_MONTAG + SEK_PRO_WOCHE );
defined('UEBERNAECHSTER_MONTAG') OR define( 'UEBERNAECHSTER_MONTAG', NAECHSTER_MONTAG + SEK_PRO_WOCHE );

/*
|--------------------------------------------------------------------------
| VEREINSAPP Projekt-spezifische Konstanten
|--------------------------------------------------------------------------*/

$einstellungen = array();
$vorgegebene_werte = array();

defined('OFFIZIELLER_NAME') OR define( 'OFFIZIELLER_NAME', 'Eingetragener Verein e.V.' );
defined('VEREINSAPP_NAME') OR define( 'VEREINSAPP_NAME', 'Eingetragener Verein e.V. Vereinsapp' );  // Sollte generisch feminin sein
defined('OFFIZIELLE_WEBSITE') OR define( 'OFFIZIELLE_WEBSITE', 'https://www.eingetragener-verein.de' );
defined('OFFIZIELLE_MAILADRESSE') OR define( 'OFFIZIELLE_MAILADRESSE', 'vereinsapp@eingetragener-verein.de' );

defined('LOGIN_COOKIE_EXPIRE') OR define( 'LOGIN_COOKIE_EXPIRE', 60*60*24*30*6 );
defined('LOGIN_EINMAL_LINK_EXPIRE') OR define( 'LOGIN_EINMAL_LINK_EXPIRE', 60*60*24*7 );
defined('LOGIN_PASSWORT_VERGEBEN_EXPIRE') OR define( 'LOGIN_PASSWORT_VERGEBEN_EXPIRE', 60*60*2 );
defined('LOGIN_ZUGANG_ENTSPERREN_EXPIRE') OR define( 'LOGIN_ZUGANG_ENTSPERREN_EXPIRE', 60*60*2 );
defined('LOGIN_VERSUCHE') OR define( 'LOGIN_VERSUCHE', 3 );
defined('LOGIN_ERLAUBT') OR define( 'LOGIN_ERLAUBT', array(
  'email_passwort' => array ( 'beschriftung' => 'Zugang mit Email & Passwort', 'standard' => TRUE, 'bemerkung' => 'Du kannst dein Passwort frei wählen und es jederzeit ändern. Wenn du dein Passwort vergessen hast, dann kannst du es per Email wieder neu vergeben. <span class="text-success">Diese Möglichkeit ist die gängigste Variante in der digitalen Welt und sichert deinen Zugang bestmöglich ab.</span>' ),
  'einmal_link' => array ( 'beschriftung' => 'Zugang mit Einmal-Link', 'standard' => TRUE, 'bemerkung' => 'Mit einem Einmal-Link kannst du dich einmal einloggen, danach ist dein Gerät dauerhaft mit der '.VEREINSAPP_NAME.' mittels Cookies verbunden und der Link wird ungültig. Wenn du einen neuen Link benötigst, kannst du dir einen per Email zuschicken lassen. <span class="text-danger">Diese Möglichkeit ist die bequemste Variante aber im Allgemeinen weniger sicher als der Zugang per Email & Passwort.</span>' ),
) );

defined('SCHLUESSEL_LAENGE') OR define( 'SCHLUESSEL_LAENGE', 100 );

defined('RECHTE') OR define( 'RECHTE', array(
  '-t' => array ( 'beschriftung' => 'Rechte zur Termin-Verwaltung', 'veraenderbar' => TRUE ),
  '-a' => array ( 'beschriftung' => 'Rechte zur Anwesenheitskontrolle', 'veraenderbar' => TRUE ),
  //'-f' => array ( 'beschriftung' => 'Rechte zum Ändern des Fahrerplan', 'veraenderbar' => TRUE ),
  //'-s' => array ( 'beschriftung' => 'Rechte zum Verteilen von Strafen', 'veraenderbar' => TRUE ),
  '-n' => array ( 'beschriftung' => 'Rechte zur Notenbank-Verwaltung', 'veraenderbar' => TRUE ),
  '-m' => array ( 'beschriftung' => 'Rechte zur Mitglieder-Verwaltung', 'veraenderbar' => TRUE ),
  '-r' => array ( 'beschriftung' => 'Rechte zum Ändern der Rechte', 'veraenderbar' => FALSE ),
  '-e' => array ( 'beschriftung' => 'Rechte für Entwickler-Funktionen', 'veraenderbar' => FALSE ),
) );


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


$einstellungen['startseite']['logo_anzeigen'] = array( 'titel' => 'Logo anzeigen',
  'werte' => array(
    'nein' => 'nein',
    'ja' => 'ja',
    ),
  'standardwert' => 'ja',
);
$einstellungen['startseite']['termine_zeitraum'] = array( 'titel' => 'Termine im Zeitraum',
  'werte' => array(
    'kommende_14_tage' => 'Kommende 14 Tage',
    'diese_naechste_woche' => 'Diese und nächste Woche',
    ),
  'standardwert' => 'kommende_14_tage',
);


defined('MITGLIEDER_KATEGORIEN') OR define( 'MITGLIEDER_KATEGORIEN', array(
  'zeitpunkt' => array( 'beschriftung' => 'Zeitpunkt', 'db' => TRUE, 'num' => TRUE, ),

  'email' => array( 'beschriftung' => 'Email', 'db' => TRUE, 'num' => FALSE, ),

  'loginversuche' => array( 'beschriftung' => 'Verbleibende Login-Versuche', 'db' => TRUE, 'num' => TRUE, ),
  'passwort' => array( 'beschriftung' => 'Passwort', 'db' => TRUE, 'num' => FALSE, ),
  'login_schluessel' => array( 'beschriftung' => 'Aktiver Schlüssel', 'db' => TRUE, 'num' => FALSE, ),
  'login_schluessel_zeitpunkt' => array( 'beschriftung' => 'Zeitpunkt Aktiver Schlüssel', 'db' => TRUE, 'num' => TRUE, ),
  'login_erlaubt' => array( 'beschriftung' => 'Erlaubte Login-Möglichkeiten', 'db' => TRUE, 'num' => FALSE, ),

  'rechte' => array( 'beschriftung' => 'Rechte', 'db' => TRUE, 'num' => FALSE, ),
  'rechte_db' => array( 'beschriftung' => 'Rechte', 'db' => FALSE, 'num' => FALSE, ),

  'vorname' => array( 'beschriftung' => 'Vorname', 'db' => TRUE, 'num' => FALSE, ),
  'nachname' => array(  'beschriftung' => 'Nachname', 'db' => TRUE, 'num' => FALSE, ),

  'geburt' => array( 'beschriftung' => 'Geboren am', 'db' => TRUE, 'num' => TRUE, ),
  'geburtstag' => array( 'beschriftung' => 'Geburtstag', 'db' => FALSE, 'num' => TRUE, ),
  'alter' => array( 'beschriftung' => 'Alter', 'db' => FALSE, 'num' => TRUE, ),
  'alter_exakt' => array( 'beschriftung' => 'Exaktes Alter', 'db' => FALSE, 'num' => TRUE, ),

  //'adresse' => array( 'beschriftung' => 'Adresse', 'db' => TRUE, 'num' => FALSE, ),
  'postleitzahl' => array( 'beschriftung' => 'Postleitzahl', 'db' => TRUE, 'num' => TRUE, ),
  'wohnort' => array( 'beschriftung' => 'Wohnort', 'db' => TRUE, 'num' => FALSE, ),

  'geschlecht' => array( 'beschriftung' => 'Geschlecht', 'db' => TRUE, 'num' => FALSE, ),
  'register' => array( 'beschriftung' => 'Instrument', 'db' => TRUE, 'num' => FALSE, ),
  'funktion' => array( 'beschriftung' => 'Funktion', 'db' => TRUE, 'num' => FALSE, ),
  'vorstandschaft' => array( 'beschriftung' => 'Vorstandschaft', 'db' => TRUE, 'num' => FALSE, ),
  'aktiv' => array( 'beschriftung' => 'Aktiv', 'db' => TRUE, 'num' => FALSE, ),

  'archiv' => array( 'beschriftung' => 'Archiv', 'db' => TRUE, 'num' => FALSE, ),
) );
$mitglieder_kategorien_db = array(); foreach( MITGLIEDER_KATEGORIEN as $kategorie => $eigenschaften ) if( $eigenschaften['db'] ) {
  $mitglieder_kategorien_db[] = $kategorie; if( $eigenschaften['num'] ) { $mitglieder_kategorien_db[] = $kategorie.'<='; $mitglieder_kategorien_db[] = $kategorie.'>='; }
} defined('MITGLIEDER_KATEGORIEN_DB') OR define( 'MITGLIEDER_KATEGORIEN_DB', $mitglieder_kategorien_db );
defined('MITGLIEDER_KATEGORIEN_VORSCHAU') OR define( 'MITGLIEDER_KATEGORIEN_VORSCHAU', array( 'register', 'geburtstag', 'alter', 'wohnort', 'funktion', ) );
defined('MITGLIEDER_BESCHR_TABELLE') OR define( 'MITGLIEDER_BESCHR_TABELLE', array( 'aktiv' => array( 0, ), ) );

$vorgegebene_werte['mitglieder'] = array(
    'geschlecht' => array (
        'm' => array( 'beschriftung' => 'Männl.', ),
        'w' => array( 'beschriftung' => 'Weibl.', ),
        'd' => array( 'beschriftung' => 'Keine Angabe', ),
    ),
    'register' => array (
        '' => array( 'beschriftung' => 'ohne Instrument', ),
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
        '' => array( 'beschriftung' => 'keine Funktion', ),
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
    );

$einstellungen['mitglieder']['sortieren_nach'] = array( 'titel' => 'Mitglieder sortieren nach',
  'werte' => array(
    'vorname' => MITGLIEDER_KATEGORIEN['vorname']['beschriftung'],
    'nachname' => MITGLIEDER_KATEGORIEN['nachname']['beschriftung'],
    'geburtstag' => MITGLIEDER_KATEGORIEN['geburtstag']['beschriftung'],
    'alter' => MITGLIEDER_KATEGORIEN['alter']['beschriftung'],
    'geschlecht' => MITGLIEDER_KATEGORIEN['geschlecht']['beschriftung'],
    //'postleitzahl' => MITGLIEDER_KATEGORIEN['postleitzahl']['beschriftung'],
    'wohnort' => MITGLIEDER_KATEGORIEN['wohnort']['beschriftung'],
    'register' => MITGLIEDER_KATEGORIEN['register']['beschriftung'],
    'funktion' => MITGLIEDER_KATEGORIEN['funktion']['beschriftung'],
  ),
  'standardwert' => 'nachname',
);   
defined('MITGLIEDER_SORTIERBARE_KATEGORIEN') OR define( 'MITGLIEDER_SORTIERBARE_KATEGORIEN', array_keys( $einstellungen['mitglieder']['sortieren_nach']['werte'] ) );
defined('MITGLIEDER_FILTERBARE_KATEGORIEN') OR define( 'MITGLIEDER_FILTERBARE_KATEGORIEN', array(/*
  'vorname' => 'anfangsbuchstabe',
  'nachname' => 'anfangsbuchstabe',
  //'geburtstag' => 'zeitraum_jahr',
  //'geburt' => 'zeitraum',
  'alter' => 'zahlenraum',
  'geschlecht' => 'verfuegbare_werte',
  'wohnort' => 'verfuegbare_werte',
  'register' => 'verfuegbare_werte',
  'funktion' => 'verfuegbare_werte',
  'vorstandschaft' => 'verfuegbare_werte',
  'aktiv' => 'verfuegbare_werte',*/
) );
$einstellungen['mitglieder']['gruppieren_nach'] = array( 'titel' => 'Mitglieder gruppieren nach',
  'werte' => array(
    'geschlecht' => MITGLIEDER_KATEGORIEN['geschlecht']['beschriftung'],
    //'postleitzahl' => MITGLIEDER_KATEGORIEN['postleitzahl']['beschriftung'],
    'wohnort' => MITGLIEDER_KATEGORIEN['wohnort']['beschriftung'],
    'register' => MITGLIEDER_KATEGORIEN['register']['beschriftung'],
    //'geburtstag' => MITGLIEDER_KATEGORIEN['geburtstag']['beschriftung'],
    'alter' => MITGLIEDER_KATEGORIEN['alter']['beschriftung'],
    'funktion' => MITGLIEDER_KATEGORIEN['funktion']['beschriftung'],
  ),
  'standardwert' => 'register',
);

defined('MITGLIEDER_ABWESENHEITEN_BEMERKUNG_STANDARD') OR define( 'MITGLIEDER_ABWESENHEITEN_BEMERKUNG_STANDARD', 'Mitglied hat eine Abwesenheit aktiviert!' );
defined('MITGLIEDER_GEBURTSTAG_STANDARD_PRE') OR define( 'MITGLIEDER_GEBURTSTAG_STANDARD_PRE', 'Mitglied hat den ' );
defined('MITGLIEDER_GEBURTSTAG_STANDARD_POST') OR define( 'MITGLIEDER_GEBURTSTAG_STANDARD_POST', '. Geburtstag!' );
defined('MITGLIEDER_GESPERRT_STANDARD') OR define( 'MITGLIEDER_GESPERRT_STANDARD', 'Der Zugang des Mitglieds ist gesperrt!' );



if( in_array( 'termine', AKTIVE_CONTROLLER ) ) {
  defined('TERMINE_KATEGORIEN') OR define( 'TERMINE_KATEGORIEN', array(
    'zeitpunkt' => array( 'beschriftung' => 'Zeitpunkt', 'db' => TRUE, 'num' => TRUE, ),

    'titel' => array( 'beschriftung' => 'Titel', 'db' => TRUE, 'num' => FALSE, ),
    //'organisator' => array( 'beschriftung' => 'Organisator', 'db' => TRUE, 'num' => FALSE, ),
    'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'db' => TRUE, 'num' => FALSE, ),

    'start' => array( 'beschriftung' => 'Beginn', 'db' => TRUE, 'num' => TRUE, ),
    'ort' => array( 'beschriftung' => 'Ort', 'db' => TRUE, 'num' => FALSE, ),

    'typ' => array( 'beschriftung' => 'Typ', 'db' => TRUE, 'num' => FALSE, ),
    'beschr_mitglieder' => array( 'beschriftung' => 'Mitglieder-Beschränkung', 'db' => TRUE, 'num' => FALSE, ),
    'ich_beschr' => array( 'beschriftung' => 'Nicht eingeladen', 'db' => FALSE, 'num' => FALSE, ),

    'vergangen' => array( 'beschriftung' => 'Vergangen', 'db' => FALSE, 'num' => FALSE, ),
    'archiv' => array( 'beschriftung' => 'Archiv', 'db' => TRUE, 'num' => FALSE, ),
  ) );
  $termine_kategorien_db = array(); foreach( TERMINE_KATEGORIEN as $kategorie => $eigenschaften ) if( $eigenschaften['db'] ) {
    $termine_kategorien_db[] = $kategorie; if( $eigenschaften['num'] ) { $termine_kategorien_db[] = $kategorie.'<='; $termine_kategorien_db[] = $kategorie.'>='; }
  } defined('TERMINE_KATEGORIEN_DB') OR define( 'TERMINE_KATEGORIEN_DB', $termine_kategorien_db );

  $vorgegebene_werte['termine'] = array(
    'typ' => array (
        'allgemein' => array( 'beschriftung' => 'Allgemein', 'symbol' => '', 'beschr_mitglieder_standard' => array() ),
        'auftritt' => array( 'beschriftung' => 'Auftritt', 'symbol' => '&#127930', 'beschr_mitglieder_standard' => array( 'aktiv' => array( 0, ), ), ),
        'probe' => array( 'beschriftung' => 'Musikprobe', 'symbol' => '&#128218', 'beschr_mitglieder_standard' => array( 'aktiv' => array( 0, ), ), ),
        //'vorstandschaftssitzung' => array( 'beschriftung' => 'Vorstandschaftssitzung', 'symbol' => '<img class="title" src="/vereinsapp_images/vorstandschaftssitzung.png" width="30" />', 'beschr_mitglieder_standard' => array( 'vorstandschaft' => array( 0, ), ), ),
    ),
    'vorstandschaft' => JANEIN,
    'aktiv' => JANEIN,
  );

  $einstellungen['termine']['sortieren_nach'] = array( 'titel' => 'Termine sortieren nach',
    'werte' => array(
      'titel' => TERMINE_KATEGORIEN['titel']['beschriftung'],
      //'organisator' => TERMINE_KATEGORIEN['organisator']['beschriftung'],
      'start' => TERMINE_KATEGORIEN['start']['beschriftung'],
      'ort' => TERMINE_KATEGORIEN['ort']['beschriftung'],
      'typ' => TERMINE_KATEGORIEN['typ']['beschriftung'],
      ),
    'standardwert' => 'start',
  );
  defined('TERMINE_SORTIERBARE_KATEGORIEN') OR define( 'TERMINE_SORTIERBARE_KATEGORIEN', array_keys( $einstellungen['termine']['sortieren_nach']['werte'] ) );
  defined('TERMINE_FILTERBARE_KATEGORIEN') OR define( 'TERMINE_FILTERBARE_KATEGORIEN', array(/*
    'titel' => 'verfuegbare_werte',
    //'organisator' => 'verfuegbare_werte',
    //'start' => 'zeitraum',
    'ort' => 'verfuegbare_werte',
    'typ' => 'verfuegbare_werte',*/
  ) );
  
  $einstellungen['termine']['ich_beschr_anzeigen'] = array( 'titel' => 'Termine ohne Einladung',
    'werte' => array(
      0 => 'ausblenden',
      1 => 'anzeigen',
      ),
    'standardwert' => 0,
  );
  $einstellungen['termine']['vergangen_anzeigen'] = array( 'titel' => 'Vergangene Termine',
    'werte' => array(
      0 => 'ausblenden',
      1 => 'anzeigen',
      ),
    'standardwert' => 0,
  );
  $einstellungen['termine']['gruppieren_nach'] = array( 'titel' => 'Termine gruppieren nach',
    'werte' => array(
      'titel' => TERMINE_KATEGORIEN['titel']['beschriftung'],
      //'organisator' => TERMINE_KATEGORIEN['organisator']['beschriftung'],
      'start' => TERMINE_KATEGORIEN['start']['beschriftung'],
      'ort' => TERMINE_KATEGORIEN['ort']['beschriftung'],
      'typ' => TERMINE_KATEGORIEN['typ']['beschriftung'],
      ),
    'standardwert' => 'start',
  );

  defined('TERMINE_KATEGORIEN_BESCHR_MITGLIEDER') OR define( 'TERMINE_KATEGORIEN_BESCHR_MITGLIEDER', array( 'register', 'funktion', 'vorstandschaft', ) );

  defined('TERMINE_RUECKMELDUNG_FRIST') OR define( 'TERMINE_RUECKMELDUNG_FRIST', 0 );

  //defined('TERMINE_FAHRERPLAN') OR define( 'TERMINE_FAHRERPLAN', FALSE );

  defined('TERMINE_ANWESENHEITSKONTROLLE') OR define( 'TERMINE_ANWESENHEITSKONTROLLE', TRUE );

  defined('TERMINE_RUECKMELDUNG_DETAIL_FREWILLIG') OR define( 'TERMINE_RUECKMELDUNG_DETAIL_FREWILLIG', TRUE ); // Absage und Zusage Freiwillig!
  defined('TERMINE_RUECKMELDUNG_DETAIL_ABSAGE') OR define( 'TERMINE_RUECKMELDUNG_DETAIL_ABSAGE', FALSE );  // Absage als Zwang!

  defined('TERMINE_SETLISTS') OR define( 'TERMINE_SETLISTS', TRUE );
  defined('TERMINE_SETLISTS_TYPEN') OR define( 'TERMINE_SETLISTS_TYPEN', array( 'auftritt' ) );
}


if( in_array( 'strafkatalog', AKTIVE_CONTROLLER ) ) {
  defined('STRAFKATALOG_KATEGORIEN') OR define( 'STRAFKATALOG_KATEGORIEN', array(
    'zeitpunkt' => array( 'beschriftung' => 'Zeitpunkt', 'db' => TRUE, 'num' => TRUE, ),

    'grund' => array( 'beschriftung' => 'Grund', 'db' => TRUE, 'num' => FALSE, ),
    'bemerkung' => array( 'beschriftung' => 'Bemerkung', 'db' => TRUE, 'num' => FALSE, ),
    'kapitel_id' => array( 'beschriftung' => 'Kapitel', 'db' => TRUE, 'num' => TRUE, ),
    'betrag' => array( 'beschriftung' => 'Betrag', 'db' => TRUE, 'num' => TRUE, ),

    'archiv' => array( 'beschriftung' => 'Archiv', 'db' => TRUE, 'num' => FALSE, ),
  ) );
  $strafkatalog_kategorien_db = array(); foreach( STRAFKATALOG_KATEGORIEN as $kategorie => $eigenschaften ) if( $eigenschaften['db'] ) {
    $strafkatalog_kategorien_db[] = $kategorie; if( $eigenschaften['num'] ) { $strafkatalog_kategorien_db[] = $kategorie.'<='; $strafkatalog_kategorien_db[] = $kategorie.'>='; }
  } defined('STRAFKATALOG_KATEGORIEN_DB') OR define( 'STRAFKATALOG_KATEGORIEN_DB', $strafkatalog_kategorien_db );
  defined('STRAFKATALOG_KATEGORIEN_VORSCHAU') OR define( 'STRAFKATALOG_KATEGORIEN_VORSCHAU', array() );
  defined('STRAFKATALOG_BESCHR_TABELLE') OR define( 'STRAFKATALOG_BESCHR_TABELLE', array() );

  $vorgegebene_werte['strafkatalog'] = array(
    /*'kategorie' => array (
      'wert_kuerzel' => array( 'beschriftung' => 'wert_beschriftung', ),
    ),*/
  );

  $einstellungen['strafkatalog']['sortieren_nach'] = array( /*'titel' => 'Strafkatalog sortieren nach',*/
    'werte' => array(/*
      'grund' => STRAFKATALOG_KATEGORIEN['grund']['beschriftung'],
      'kapitel_id' => STRAFKATALOG_KATEGORIEN['kapitel_id']['beschriftung'],
      'betrag' => STRAFKATALOG_KATEGORIEN['betrag']['beschriftung'],*/
      ),
    /*'standardwert' => 'titel_nr',*/
  );
  defined('STRAFKATALOG_SORTIERBARE_KATEGORIEN') OR define( 'STRAFKATALOG_SORTIERBARE_KATEGORIEN', array_keys( $einstellungen['strafkatalog']['sortieren_nach']['werte'] ) );
  defined('STRAFKATALOG_FILTERBARE_KATEGORIEN') OR define( 'STRAFKATALOG_FILTERBARE_KATEGORIEN', array(/*
    'grund' => 'anfangsbuchstabe',
    'kapitel_id' => 'verfuegbare_werte',
    'betrag' => 'zahlenraum',*/
  ) );
  $einstellungen['strafkatalog']['gruppieren_nach'] = array( /*'titel' => 'Strafkatalog gruppieren nach',
    'werte' => array(
      'kapitel_id' => STRAFKATALOG_KATEGORIEN['kapitel_id']['beschriftung'],
      ),
    'standardwert' => 'titel_nr',*/
  );
}


if( in_array( 'notenbank', AKTIVE_CONTROLLER ) ) {
  defined('NOTENVERZEICHNIS_KATEGORIEN') OR define( 'NOTENVERZEICHNIS_KATEGORIEN', array(
    'zeitpunkt' => array( 'beschriftung' => 'Zeitpunkt', 'db' => TRUE, 'num' => TRUE, ),

    'titel_nr' => array( 'beschriftung' => 'Titel-Nr.', 'db' => TRUE, 'num' => TRUE, ),
    'titel' => array( 'beschriftung' => 'Titel', 'db' => TRUE, 'num' => FALSE, ),

    'archiv' => array( 'beschriftung' => 'Archiv', 'db' => TRUE, 'num' => FALSE, ),
  ) );
  $notenverzeichnis_kategorien_db = array(); foreach( NOTENVERZEICHNIS_KATEGORIEN as $kategorie => $eigenschaften ) if( $eigenschaften['db'] ) {
    $notenverzeichnis_kategorien_db[] = $kategorie; if( $eigenschaften['num'] ) { $notenverzeichnis_kategorien_db[] = $kategorie.'<='; $notenverzeichnis_kategorien_db[] = $kategorie.'>='; }
  } defined('NOTENVERZEICHNIS_KATEGORIEN_DB') OR define( 'NOTENVERZEICHNIS_KATEGORIEN_DB', $notenverzeichnis_kategorien_db );
  defined('NOTENVERZEICHNIS_KATEGORIEN_VORSCHAU') OR define( 'NOTENVERZEICHNIS_KATEGORIEN_VORSCHAU', array() );
  defined('NOTENVERZEICHNIS_BESCHR_TABELLE') OR define( 'NOTENVERZEICHNIS_BESCHR_TABELLE', array() );

  $vorgegebene_werte['notenverzeichnis'] = array(
    /*'kategorie' => array (
      'wert_kuerzel' => array( 'beschriftung' => 'wert_beschriftung', ),
    ),*/
  );

  $einstellungen['notenverzeichnis']['sortieren_nach'] = array( 'titel' => 'Notenverzeichnis sortieren nach',
    'werte' => array(
      'titel_nr' => NOTENVERZEICHNIS_KATEGORIEN['titel_nr']['beschriftung'],
      'titel' => NOTENVERZEICHNIS_KATEGORIEN['titel']['beschriftung'],
      ),
    'standardwert' => 'titel_nr',
  );
  defined('NOTENVERZEICHNIS_SORTIERBARE_KATEGORIEN') OR define( 'NOTENVERZEICHNIS_SORTIERBARE_KATEGORIEN', array_keys( $einstellungen['notenverzeichnis']['sortieren_nach']['werte'] ) );
  defined('NOTENVERZEICHNIS_FILTERBARE_KATEGORIEN') OR define( 'NOTENVERZEICHNIS_FILTERBARE_KATEGORIEN', array(/*
    //'titel_nr' => 'zahlenraum',
    'titel' => 'anfangsbuchstabe',*/
  ) );
  $einstellungen['notenverzeichnis']['gruppieren_nach'] = array( /*'titel' => 'Notenverzeichnis gruppieren nach',
    'werte' => array(
      'titel_nr' => NOTENVERZEICHNIS_KATEGORIEN['titel_nr']['beschriftung'],
      ),
    'standardwert' => 'titel_nr',*/
  );

  defined('NOTENVERZEICHNIS_PDF') OR define( 'NOTENVERZEICHNIS_PDF', FALSE ); //'../vereinsapp_storage/notenbank/notenverzeichnis.pdf'

}


defined('EINSTELLUNGEN') OR define( 'EINSTELLUNGEN', $einstellungen );
defined('VORGEGEBENE_WERTE') OR define( 'VORGEGEBENE_WERTE', $vorgegebene_werte );
