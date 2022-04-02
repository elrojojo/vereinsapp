<li class="list-group-item list-group-liste_h5<?php
if( array_key_exists( 'modal_id', $liste['element'] ) OR array_key_exists( 'link', $liste['element'] ) ) { ?> list-group-item-action<?php } else { ?> text-body<?php } ?>"<?php
if( array_key_exists( 'modal_id', $liste['element'] ) OR array_key_exists( 'link', $liste['element'] ) ) { ?> role="button"<?php } ?>>

  <div class="h5 text-body"><?php echo $termin['titel']; ?>
    
    <?php if( array_key_exists( 'sortable', $liste['element'] ) ) {
  ?><i class="bi bi-arrow-down-up text-primary float-right ml-1 stretched-link-unwirksam" id="sortable_aendern" role="button"></i>
    <input type="text" class="invisible position" name="sortable_positionen[<?php echo $liste['element']['id']; ?>]" value="<?php echo intval($liste['element']['position']); ?>" /><?php } ?>
    <?php if( isset($liste_element_werkzeugkasten) ) echo $liste_element_werkzeugkasten; ?>
    <?php if( array_key_exists( 'link', $liste['element'] ) ) { ?><a href="<?php echo $liste['element']['link']; ?>" class="stretched-link"><?php }
    elseif( array_key_exists( 'modal_id', $liste['element'] ) ) { ?><span class="stretched-link" data-toggle="modal" href="#<?php echo $liste['element']['modal_id']; ?>" data-element_id="<?php echo $liste['element']['id']; ?>" aria-expanded="false" aria-controls="<?php echo $liste['element']['modal_id']; ?>"><?php } ?>
      <?php if( array_key_exists( 'symbol', $liste['element'] ) ) { ?><i class="bi bi-<?php echo $liste['element']['symbol']; ?> text-<?php if( array_key_exists( 'symbol_farbe', $liste['element'] ) ) echo $liste['element']['symbol_farbe']; else echo 'primary' ?> float-right ml-1"></i><?php } ?>
    <?php if( array_key_exists( 'link', $liste['element'] ) ) { ?></a><?php }
    elseif( array_key_exists( 'modal_id', $liste['element'] ) ) { ?></span><?php } ?>

    <?php if( !empty(VORGEGEBENE_WERTE['termine']['typ'][ $termin['typ'] ]['symbol']) ) { ?><span class="float-right stretched-link-unwirksam" role="button" data-toggle="popover" data-placement="left" data-content="<?php echo VORGEGEBENE_WERTE['termine']['typ'][ $termin['typ'] ]['beschriftung']; ?>" tabindex="0" data-trigger="focus"><?php echo VORGEGEBENE_WERTE['termine']['typ'][ $termin['typ'] ]['symbol']; ?></span><?php } ?>
  </div>

  <div class="row no-gutters mb-2">
    <div class="col text-center small nowrap ml-1"><i class="bi bi-<?php echo SYMBOLE['datum']['bootstrap']; ?>"></i> <?php echo WOCHENTAGE[ intval(date( 'w', $termin['start'] )) ][0]; ?>, <?php echo date( 'd.m.Y', $termin['start'] ); ?></div>
    <div class="col text-center small nowrap mx-1"><i class="bi bi-<?php echo SYMBOLE['uhrzeit']['bootstrap']; ?>"></i> <?php echo date( 'H:i', $termin['start'] ); ?></div>
    <div class="col text-center small nowrap mr-1"><i class="bi bi-<?php echo SYMBOLE['ort']['bootstrap']; ?>"></i> <?php echo $termin['ort']; ?></div>
  </div>

  <?php if( isset($rueckmeldung_machen) ) echo $rueckmeldung_machen; ?>

</li>

