<ul id="<?= $auswertungen['id']; ?>" class="auswertungen text-center<?php
if( array_key_exists( 'sortable', $auswertungen ) AND $auswertungen['sortable'] ) echo ' sortable';
?> p-0 mb-1" data-auswertungen="<?= $auswertungen['auswertungen']; ?>" data-status_auswahl='<?= json_encode( $auswertungen['status_auswahl'], JSON_UNESCAPED_UNICODE ); ?>'<?php
if( array_key_exists( 'liste', $auswertungen ) ) { ?> data-liste='<?= json_encode( $auswertungen['liste'], JSON_UNESCAPED_UNICODE ); ?>'<?php }
if( array_key_exists( 'gegen_liste', $auswertungen ) ) { ?> data-gegen_liste='<?= json_encode( $auswertungen['gegen_liste'], JSON_UNESCAPED_UNICODE ); ?>'<?php }
?>>

<?= view( $view ); ?>

</ul>

<?= view( $view.'_zusammenfassung', array( 'zusammenfassung' => array( 'instanz' => $auswertungen['id'], 'beschriftung' => "Summe", ), ) ); ?>

