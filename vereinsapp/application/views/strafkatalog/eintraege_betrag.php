<div class="col-12 mb-3">
    <?php if( isset($eintraege_betrag['farbe']) ) echo '<span class="text-'.$eintraege_betrag['farbe'].'">'; ?><?php echo '&#8721'; ?> <?php echo $eintraege_betrag['beschriftung']; ?>
    <span class="float-right<?php if( isset($eintraege_betrag['farbe']) ) echo ' text-'.$eintraege_betrag['farbe']; ?>"><?php echo html_waehrung( $eintraege_betrag['betrag'] ); ?></span>
</div>

