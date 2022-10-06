<?php
/**
 * Eigener Helper f�r die Vereinsapp
 *
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('html_waehrung') ) {
	function html_waehrung( $betrag ) {
		return strval( number_format( round( $betrag*100 )/100,	2, ",",	"." ) ).' €';
	}
}

if ( !function_exists('html_time') ) {
	function html_time( $zeitstempel ) {
		return strval( date( 'H:i', $zeitstempel ) );
	}
}

if ( !function_exists('html_date') ) {
	function html_date( $zeitstempel ) {
		return strval( date( 'Y-m-d', $zeitstempel ) );
	}
}

if ( !function_exists('html_datetime_local') ) {
	function html_datetime_local( $zeitstempel ) {
		return strval( date( 'Y-m-d\TH:i', $zeitstempel ) );
	}
}


//------------------------------------
if ( !function_exists('mitglied_wert_formatiert') ) {
	function mitglied_wert_formatiert( $wert, $kategorie ) {
			if( $kategorie == 'geburtstag' ) $wert = date( 'd.m.', $wert );
			elseif( $kategorie == 'alter' ) $wert = $wert.' Jahre';
			elseif( $kategorie == 'alter_exakt' ) $wert = floor( $wert ).' Jahre';
			elseif( $kategorie == 'geschlecht' ) $wert = VORGEGEBENE_WERTE['mitglieder']['geschlecht'][ $wert ]['beschriftung'];
			elseif( $kategorie == 'register' ) $wert = VORGEGEBENE_WERTE['mitglieder']['register'][ $wert ]['beschriftung'];
			elseif( $kategorie == 'funktion' ) $wert = VORGEGEBENE_WERTE['mitglieder']['funktion'][ $wert ]['beschriftung'];
			elseif( $kategorie == 'vorstandschaft' ) $wert = JANEIN[ $wert ]['beschriftung'];
			elseif( $kategorie == 'aktiv' ) $wert = JANEIN[ $wert ]['beschriftung'];
		return $wert;
	}
}

if ( !function_exists('mitglieder_kategorie_sortierkorrektur') ) {
	function mitglieder_kategorie_sortierkorrektur( $sortieren ) {
		foreach( $sortieren as $spalte_richtung_id => $spalte_richtung ) {
			if( $spalte_richtung[ array_key_first( $spalte_richtung ) ] == 'alter') $sortieren[ $spalte_richtung_id ][ array_key_first( $spalte_richtung ) ] = 'alter_exakt';
		}
		return $sortieren;
	}
}


//------------------------------------
if ( !function_exists('termin_wert_formatiert') ) {
	function termin_wert_formatiert( $wert, $kategorie ) {
			if( $kategorie == 'start' ) $wert = date( 'd.m.Y H:i', $wert );
			elseif( $kategorie == 'kategorie' ) $wert = TERMINE_KATEGORIEN[ intval($wert) ][0];
		return $wert;
	}
}

if ( !function_exists('termine_kategorie_sortierkorrektur') ) {
	function termine_kategorie_sortierkorrektur( $kategorie ) {
		//if( $kategorie == 'alter') $kategorie = 'alter_exakt';
		return $kategorie;
	}
}

if ( !function_exists('notenverzeichnis_kategorie_sortierkorrektur') ) {
	function notenverzeichnis_kategorie_sortierkorrektur( $kategorie ) {
		//if( $kategorie == 'alter') $kategorie = 'alter_exakt';
		return $kategorie;
	}
}


//------------------------------------
if ( !function_exists('sql_sicherheitscheck') )
{
  function sql_sicherheitscheck( $array ) {
    foreach( $array as $id => $element ) { if( !is_null($element) ) $array[ $id ] = htmlspecialchars( trim( $element ) ); }
    return $array;
  }
}


//------------------------------------
if ( !function_exists('schluessel_generieren') )
{
	function schluessel_generieren() {
    // https://sklueh.de/2013/09/zufaelligen-string-mit-php-erzeugen/ vom 02.05.2020
    /*$zeichen_auswahl = array_merge( range('A', 'Z'), range('a', 'z'), range(0,9), str_split('-') );
    for( $schluessel = '', $zeichen = 0; $zeichen < SCHLUESSEL_LAENGE; $zeichen++ )
      $schluessel .= $zeichen_auswahl[ array_rand($zeichen_auswahl) ];
    return $schluessel;*/
	
	// https://www.joocom.de/blog/posts/einen-zufallsstring-mit-php-erzeugen/ vom 31.12.2021
	//return substr( str_shuffle( str_repeat( implode( '', range('!','z') ), SCHLUESSEL_LAENGE ) ), 0, SCHLUESSEL_LAENGE );	// Für URLs ungeeignet, eher für Passwörter

	return bin2hex( openssl_random_pseudo_bytes( SCHLUESSEL_LAENGE / 2 ) );
  }
}


//------------------------------------
if ( !function_exists('status_feuern') )
{
	function status_feuern( $farbe, $status, $anzeigen = TRUE ) {
		$CI = &get_instance();
		if( $anzeigen ) $CI->data['status_anzeigen_liste'][] = array( 'view' => $CI->load->view('templates/status_dynamisch', array( 'farbe' => $farbe, 'status' => $status, 'prioritaet' => count($CI->data['status_anzeigen_liste']), ), TRUE ) );
		else {
			$status_session = $CI->session->status;
			$status_session[] = array(
				'farbe' => $farbe,
				'status' => $status,
				'prioritaet' => count($status_session),
			);
			$CI->session->status = $status_session;
		}
	}
}