<?php
/**
 * Eigener Helper f�r die Tabellenverarbeitung
 *
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('tabelle_sortieren') )
{
	function tabelle_sortieren( $tabelle, $sortieren ) {

    if( is_array($sortieren) ) {
      $sortieren_sammler = array();
      foreach( $sortieren as $reihenfolge ) {
        $sortieren_sammler[] = array_column( $tabelle, $reihenfolge[ array_key_first( $reihenfolge ) ] );
        $sortieren_sammler[] = $reihenfolge['richtung'];
      }
      $sortieren_sammler[] = &$tabelle;
      array_multisort( ...$sortieren_sammler );
    }
    else array_multisort( array_column( $tabelle, $sortieren ), SORT_ASC, $tabelle );

    $tabelle_sortiert = array();
    foreach( $tabelle as $zeile ):
      $tabelle_sortiert[ $zeile['id'] ] = $zeile;
    endforeach;

    return $tabelle_sortiert;
  }
}

if ( !function_exists('tabelle_clustern') )
{
	function tabelle_clustern( $tabelle, $spaltenindex ) {
		$tabelle_geclustert = array();
    $werte = verfuegbare_werte_in_spalte( array_column( $tabelle, $spaltenindex ) );
    foreach( $werte as $wert ):
      $tabelle_geclustert[ $wert ] = private_zeilen_nach_parameter( $tabelle, array( $spaltenindex => $wert ) );
    endforeach;
    return $tabelle_geclustert;
  }
}

if ( !function_exists('verfuegbare_werte_in_spalte') )
{
    function verfuegbare_werte_in_spalte( $spalte, $sortiert = TRUE ) {
        $werte = array();
        foreach( $spalte as $index => $wert ):
            if( !in_array( $wert, $werte ) ) array_push($werte, $wert );
        endforeach;
        if( $sortiert ) sort( $werte );
        return $werte;
    }
}

if ( !function_exists('private_zeilen_nach_parameter') )
{
    function private_zeilen_nach_parameter( $tabelle, $parameter ) {
        $zeilen = array();
        foreach( $tabelle as $zeile_id => $zeile ):
            if( array_intersect_assoc( $parameter, $zeile ) == $parameter ) $zeilen[ $zeile_id ] = $zeile;
        endforeach;
        return $zeilen;
    }
}
