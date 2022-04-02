<li class="list-group-item<?php if( array_key_exists( 'beschriftung_h5', $liste ) ) echo ' list-group-liste_h5';?><?php
if( array_key_exists( 'modal_id', $liste['element'] ) OR array_key_exists( 'link', $liste['element'] ) ) { ?> list-group-item-action<?php } ?> text-body"<?php
if( array_key_exists( 'modal_id', $liste['element'] ) OR array_key_exists( 'link', $liste['element'] ) ) { ?> role="button"<?php } ?>>

  <?php if( array_key_exists( 'beschriftung_h5', $liste ) ) { ?><div class="h5 text-body"><?php } ?><?php echo $liste['element']['beschriftung']; ?>
  
    <?php if( array_key_exists( 'sortable', $liste['element'] ) ) {
  ?><i class="bi bi-arrow-down-up text-primary float-right ml-1 stretched-link-unwirksam" id="sortable_aendern" role="button"></i>
    <input type="text" class="invisible position" name="sortable_positionen[]" value="<?php echo intval($liste['element']['id']); ?>" /><?php } ?>
    <?php if( isset($liste_element_werkzeugkasten) ) echo $liste_element_werkzeugkasten; ?>
    <?php if( array_key_exists( 'link', $liste['element'] ) ) { ?><a href="<?php echo $liste['element']['link']; ?>" class="stretched-link"><?php }
    elseif( array_key_exists( 'modal_id', $liste['element'] ) ) { ?><span class="stretched-link" data-toggle="modal" href="#<?php echo $liste['element']['modal_id']; ?>" data-element_id="<?php echo $liste['element']['id']; ?>" aria-expanded="false" aria-controls="<?php echo $liste['element']['modal_id']; ?>"><?php } ?>
      <?php if( array_key_exists( 'symbol', $liste['element'] ) ) { ?><i class="bi bi-<?php echo $liste['element']['symbol']; ?> text-<?php if( array_key_exists( 'symbol_farbe', $liste['element'] ) ) echo $liste['element']['symbol_farbe']; else echo 'primary' ?> float-right ml-1"></i><?php } ?>
    <?php if( array_key_exists( 'link', $liste['element'] ) ) { ?></a><?php }
    elseif( array_key_exists( 'modal_id', $liste['element'] ) ) { ?></span><?php } ?>
    <?php if( array_key_exists( 'float_right', $liste['element'] ) AND !empty($liste['element']['float_right']) ) { ?><span class="float-right"><?php echo $liste['element']['float_right']; ?></span><?php } ?>
  <?php if( array_key_exists( 'beschriftung_h5', $liste ) ) { ?></div><?php } ?>

  <?php if( array_key_exists( 'small', $liste['element'] ) AND !empty($liste['element']['small']) ) { ?><div class="text-secondary small"><?php echo $liste['element']['small']; ?></div><?php } 
    elseif( array_key_exists( 'truncate', $liste['element'] ) AND !empty($liste['element']['truncate']) ) { ?><div class="text-secondary text-truncate"><?php echo $liste['element']['truncate']; ?></div><?php } ?>

</li>

