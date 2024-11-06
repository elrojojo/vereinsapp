<div class="row row-cols-3 g-1 element_navigation" data-instanz="<?= $element_navigation['instanz']; ?>"<?php
if( array_key_exists( 'filtern', $element_navigation ) ) { ?> data-filtern='<?= json_encode( $element_navigation['filtern'], JSON_UNESCAPED_UNICODE ); ?>'<?php }
if( array_key_exists( 'sortieren', $element_navigation ) ) { ?> data-sortieren='<?= json_encode( $element_navigation['sortieren'], JSON_UNESCAPED_UNICODE ); ?>'<?php }
?>>
    <div class="col-2 d-grid float-start"><a class="btn btn-sm text-primary vorheriges_element"><i class="bi bi-arrow-left"></i></a></div>
    <div class="col-8 d-grid "><a class="btn btn-sm text-primary" href="<?= site_url( AKTIVER_CONTROLLER ); ?>">Zurück zur Übersicht</a></div>
    <div class="col-2 d-grid float-end"><a class="btn btn-sm text-primary naechstes_element"><i class="bi bi-arrow-right"></i></a></div>
</div>

