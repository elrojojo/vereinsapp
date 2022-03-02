<?php
/**
 * Eigener Helper f�rs Verzeichnishandling
 *
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('pfad_aus_array') )
{
  function pfad_aus_array( $array ) {
    $pfad = '';
    foreach( $array as $verzeichnis ):
      $pfad .= '/'.$verzeichnis;
    endforeach;
    return $pfad;
  }
}