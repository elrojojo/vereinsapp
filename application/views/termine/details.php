<div class="col-12 fixed-top filler-sticky bg-white"></div>
<div class="col-12 pb-3 sticky-top second-sticky bg-white">
  <div class="row no-gutters">
    <div class="col-auto text-left mb-1">
      <a class="h5 text<?php if( !$vorheriger_termin ) echo '-secondary disabled'; else echo '-primary' ?> mr-1"<?php if( $vorheriger_termin ) echo ' href="'.site_url().'termine/'.METHOD.'/'.$vorheriger_termin['id'].'"'; ?>>
        <i class="bi bi-arrow-left"></i>
      </a>
    </div>
    <div class="col text-center">
      <div class="h5"><?php echo $termin['titel']; ?></div>
      <div class="small"><?php echo $termin['bemerkung']; ?></div>
    </div>
    <div class="col-auto text-right mb-1">
      <a class="h5 text<?php if( !$naechster_termin ) echo '-secondary disabled'; else echo '-primary' ?> ml-1"<?php if( $naechster_termin ) echo ' href="'.site_url().'termine/'.METHOD.'/'.$naechster_termin['id'].'"'; ?>>
        <i class="bi bi-arrow-right"></i>
      </a>
    </div>
  </div>

  <div class="row no-gutters mb-2">
    <div class="col text-center nowrap ml-1"><i class="bi bi-<?php echo SYMBOLE['datum']['bootstrap']; ?>"></i> <?php echo WOCHENTAGE[ intval(date( 'w', $termin['start'] )) ][0]; ?>, <?php echo date( 'd.m.Y', $termin['start'] ); ?></div>
    <div class="col text-center nowrap mx-1"><i class="bi bi-<?php echo SYMBOLE['uhrzeit']['bootstrap']; ?>"></i> <?php echo date( 'H:i', $termin['start'] ); ?></div>
    <?php if( !empty(VORGEGEBENE_WERTE['termine']['typ'][ $termin['typ'] ]['symbol']) ) { ?><div class="col text-center nowrap mx-1" role="button" data-toggle="popover" data-placement="left" data-content="<?php echo VORGEGEBENE_WERTE['termine']['typ'][ $termin['typ'] ]['beschriftung']; ?>" tabindex="0" data-trigger="focus"><?php echo VORGEGEBENE_WERTE['termine']['typ'][ $termin['typ'] ]['symbol']; ?></div><?php } ?>
    <div class="col text-center nowrap mr-1"><i class="bi bi-<?php echo SYMBOLE['ort']['bootstrap']; ?>"></i> <?php echo $termin['ort']; ?></div>
  </div>

  <?php if( isset($rueckmeldung_machen) ) echo $rueckmeldung_machen; ?>

</div>

