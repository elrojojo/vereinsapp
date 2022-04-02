<li class="list-group-item list-group-striped">
  <div class="row no-gutters">
    <div class="col mr-2">
      <div class="text-truncate"><?php echo $titel['titel_nr']; ?> <?php echo $titel['titel']; ?><span class="h5 float-right"><?php echo $gesamtbewertung; ?></span></div>

        <?php if( $gesamtanzahl > 0 ) { ?><div class="progress">
          <?php foreach( $verfuegbare_werte as $wert => $verfuegbarer_wert ):
            $laenge = count( $bewertungen_cluster_objekt[ $wert ] )/$gesamtanzahl*100; ?>
          <div class="progress-bar bg-<?php echo $verfuegbarer_wert['farbe']; ?> nowrap" role="progressbar" style="width: <?php echo $laenge; ?>%" aria-valuenow="<?php echo $laenge; ?>" aria-valuemin="0" aria-valuemax="100">
            <?php if( $laenge >= 25 ) echo round( $laenge ).'%'; ?>
          </div>
          <?php endforeach; ?>
        </div><?php } ?>

    </div>
    <?php foreach( $verfuegbare_werte as $wert => $verfuegbarer_wert ): ?><div class="col-auto"><?php echo form_open( site_url().CONTROLLER.'/'.METHOD ); ?>
      <input type="text" class="invisible" name="objekt_id" value="<?php echo $objekt_id; ?>" />
      <input type="text" class="invisible" name="wert" value="<?php echo $wert; ?>" />
      <button type="submit" class="btn btn-<?php if( is_null($von_mir_bewertet) OR $von_mir_bewertet != $wert ) echo 'outline-'; ?><?php echo $verfuegbarer_wert['farbe']; ?> btn-sm">
        <?php if( array_key_exists( 'beschriftung', $verfuegbarer_wert ) ) echo $verfuegbarer_wert['beschriftung']; else echo $wert; ?>
      </button>
    </form></div><?php endforeach; ?>
  </div>
</li>
      
