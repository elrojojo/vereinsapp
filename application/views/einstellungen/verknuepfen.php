<div class="col-md-12"><div class="alert alert-success" role="alert">
  <?php if( $dauerhaft_angemeldet ) { ?>Dieses Gerät ist mit <?php echo ICH['vorname']; ?> <?php echo ICH['nachname']; ?> verknüpft (ID = <?php echo substr( $dauerhaft_angemeldet_identifier, 0, 16 ); ?>).<?php }
  else { ?>Du bist als <?php echo ICH['vorname']; ?> <?php echo ICH['nachname']; ?> angemeldet.<?php } ?>
</div></div>

