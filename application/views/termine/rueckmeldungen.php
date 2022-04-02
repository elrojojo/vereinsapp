<div class="col-md-6 mb-3">
  <?php $zusagen_gesamt = 0; $absagen_gesamt = 0; foreach( $termin['rueckmeldungen_cluster'] as $wert => $rueckmeldung_cluster ):
    $zusagen = count( $rueckmeldung_cluster['zusagen'] ); $zusagen_gesamt += $zusagen;
    $absagen = count( $rueckmeldung_cluster['absagen'] ); $absagen_gesamt += $absagen;
    $maximal = count( $mitglieder_cluster[ $wert ] );
    ?><div <?php if( $zusagen OR $absagen ) { ?>role="button" <?php } ?>data-toggle="collapse" href="#rueckmeldungen_<?php echo $wert; ?>" aria-expanded="false" aria-controls="rueckmeldungen_<?php echo $wert; ?>">
    <div class="row no-gutters mt-1">
      <div class="col-1 text-left"><h5><?php echo $zusagen; ?></h5></div>
      <div class="col-10 text-center">
        <?php echo mitglied_wert_formatiert( $wert, $mitglieder_gruppieren_nach ); ?> <?php if( $zusagen OR $absagen ) { ?><span class="text-primary"><i class="bi bi-caret-down"></i></span><?php } ?>
        <div class="progress">

          <?php $laenge = $zusagen/$maximal*100; ?>
          <div class="progress-bar bg-success nowrap" style="width: <?php echo $laenge; ?>%" role="progressbar" aria-valuenow="<?php echo $laenge; ?>" aria-valuemin="0" aria-valuemax="100"></div>

          <?php $laenge = ($maximal-$zusagen-$absagen)/$maximal*100; ?>
          <div class="progress-bar bg-transparent nowrap" style="width: <?php echo $laenge; ?>%" role="progressbar" aria-valuenow="<?php echo $laenge; ?>" aria-valuemin="0" aria-valuemax="100"></div>

          <?php $laenge = $absagen/$maximal*100; ?>
          <div class="progress-bar bg-danger nowrap" style="width: <?php echo $laenge; ?>%" role="progressbar" aria-valuenow="<?php echo $laenge; ?>" aria-valuemin="0" aria-valuemax="100"></div>

        </div>
      </div>
      <div class="col-1 text-right"><h5><?php echo $absagen; ?></h5></div>
    </div>
  </div>
  <?php if( $zusagen > 0 OR $absagen > 0 ) { ?><div class="collapse" id="rueckmeldungen_<?php echo $wert; ?>"><div class="row no-gutters">
    <div class="col-6 text-center"><div class="row no-gutters">
      <?php foreach( $rueckmeldung_cluster['zusagen'] as $zusage ): ?><div class="col-12 text-success"><?php
        if( !empty($zusage['bemerkung']) ) { ?> <a role="button" data-toggle="popover" data-placement="right" data-content="<?php echo $zusage['bemerkung']; ?>" tabindex="0" data-trigger="focus"><?php } ?>
        <?php echo MITGLIEDER[ intval($zusage['mitglied_id']) ]['vorname']; ?> <?php echo MITGLIEDER[ intval($zusage['mitglied_id']) ]['nachname'][0]; ?>.<?php
        if( !empty($zusage['bemerkung']) ) { ?> <span class="text-primary"><i class="bi bi-<?php echo SYMBOLE['bemerkung']['bootstrap']?>"></i></span></a><?php } ?>
      </div><?php endforeach; ?>
    </div></div>
    <div class="col-6 text-center"><div class="row no-gutters">
      <?php foreach( $rueckmeldung_cluster['absagen'] as $absage ): ?><div class="col-12 text-danger"><?php
        if( !empty($absage['bemerkung']) ) { ?> <a role="button" data-toggle="popover" data-placement="left" data-content="<?php echo $absage['bemerkung']; ?>" tabindex="0" data-trigger="focus"><?php } ?>
        <?php echo MITGLIEDER[ intval($absage['mitglied_id']) ]['vorname']; ?> <?php echo MITGLIEDER[ intval($absage['mitglied_id']) ]['nachname'][0]; ?>.<?php
        if( !empty($absage['bemerkung']) ) { ?> <span class="text-primary"><i class="bi bi-<?php echo SYMBOLE['bemerkung']['bootstrap']?>"></i></span></a><?php } ?>
      </div><?php endforeach; ?>
    </div></div>
    <div class="col-12 text-center text-secondary small"><?php foreach( $rueckmeldung_cluster['mitglieder_ausstehend'] as $mitglied ): ?>
        <?php echo $mitglied['vorname']; ?> <?php echo $mitglied['nachname'][0]; ?>.<?php if( array_key_last( $rueckmeldung_cluster['mitglieder_ausstehend'] ) != $mitglied['id'] ) echo ','; ?>
    <?php endforeach; ?></div>
  </div></div><?php } ?><?php endforeach; ?>
  <div class="row no-gutters mt-1">
    <div class="col-1 text-left"><?php echo $zusagen_gesamt; ?></div>
    <div class="col-10 text-center">Summe</div>
    <div class="col-1 text-right"><?php echo $absagen_gesamt; ?></div>
  </div>
  
</div>

