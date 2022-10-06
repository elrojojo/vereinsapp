<?php if( array_key_exists('form', $liste ) ) echo form_open( $liste['form'] ); ?>
<?php if( !array_key_exists( 'beschriftung_h5', $liste ) ) { ?><div class="col-12 mb-3"><?php } ?><ul class="list-group<?php if( array_key_exists( 'beschriftung_h5', $liste ) ) echo ' list-group-flush';?><?php if( array_key_exists( 'sortable', $liste ) ) echo ' sortable';?>">

