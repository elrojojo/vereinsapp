</ul><?php if( !array_key_exists( 'beschriftung_h5', $liste ) ) { ?></div><?php } ?>
<?php if( array_key_exists( 'form_inputs', $liste ) ) foreach( $liste['form_inputs'] as $name => $value ): ?><input type="text" class="invisible" name="<?php echo $name; ?>" value="<?php echo $value; ?>" /><?php endforeach; ?>
<?php if( array_key_exists( 'fuss_werkzeugkasten', $liste) ) echo $liste['fuss_werkzeugkasten']; ?>
<?php if( array_key_exists( 'form', $liste ) ) echo '</form>' ?>


