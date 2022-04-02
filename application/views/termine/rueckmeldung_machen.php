<?php if( $termin['ich_beschr'] ) { ?><div class="text-secondary small text-center">Du bist zu diesem Termin nicht eingeladen, deshalb kannst du keine Rückmeldung machen.</div><?php }
  elseif( $termin['ich_abwesend'] ) { ?><div class="text-danger small text-center">Dieser Termin liegt innerhalb deiner Abwesenheit, deshalb hast du automatisch abgesagt.</div><?php }

else { ?>
<div class="row no-gutters">
  
  <div class="col-6" style="z-index: 2;"><?php if( !( isset( $ich_rueckmeldung[ $termin['id'] ] ) AND intval($ich_rueckmeldung[ $termin['id'] ]['status']) >= 1 ) AND !intval($termin['start'])-TERMINE_RUECKMELDUNG_FRIST < time() ) echo form_open( site_url().'termine/rueckmeldung_machen' ); ?>
    <div class="row no-gutters">
      <div class="col<?php if( TERMINE_RUECKMELDUNG_DETAIL_FREWILLIG AND isset( $ich_rueckmeldung[ $termin['id'] ] ) AND intval($ich_rueckmeldung[ $termin['id'] ]['status']) >= 1 ) echo '-9'; ?>">
        <input type="text" class="invisible" name="termin_id" value="<?php echo $termin['id']; ?>" />
        <input type="text" class="invisible" name="status" value="1" />
        <button <?php
        if( ( isset( $ich_rueckmeldung[ $termin['id'] ] ) AND intval($ich_rueckmeldung[ $termin['id'] ]['status']) >= 1 ) OR intval($termin['start'])-TERMINE_RUECKMELDUNG_FRIST < time() ) echo 'type="button" disabled ';
        else echo 'type="submit" '; ?>class="btn btn<?php if( !isset($ich_rueckmeldung[ $termin['id'] ]) OR intval($ich_rueckmeldung[ $termin['id'] ]['status']) == 0 ) echo '-outline'; ?>-success btn-sm btn-block">
          <?php if( isset($ich_rueckmeldung[ $termin['id'] ]) AND intval($ich_rueckmeldung[ $termin['id'] ]['status']) >= 1 ) echo 'ZUGESAGT'; else echo 'ZUSAGEN'; ?>
        </button>
      </div>
      <?php if( TERMINE_RUECKMELDUNG_DETAIL_FREWILLIG AND isset( $ich_rueckmeldung[ $termin['id'] ] ) AND intval($ich_rueckmeldung[ $termin['id'] ]['status']) >= 1 ) {
        ?><div class="col-3">
        <button type="button" class="btn btn<?php if( empty($ich_rueckmeldung[ $termin['id'] ]['bemerkung']) ) echo '-outline'; ?>-success btn-sm btn-block"<?php
        if( intval($termin['start'])-TERMINE_RUECKMELDUNG_FRIST < time() ) echo ' disabled'; ?>
        data-toggle="modal"
        data-target="#zusage_machen_detail"
        data-termin_id="<?php echo $termin['id']; ?>"
        aria-expanded="false" aria-controls="zusage_machen_detail">
          <i class="bi bi-<?php echo SYMBOLE['bemerkung']['bootstrap']; ?>"></i>
        </button>
      </div><?php } ?>
    </div>
  <?php if( !( isset( $ich_rueckmeldung[ $termin['id'] ] ) AND intval($ich_rueckmeldung[ $termin['id'] ]['status']) >= 1 ) AND !intval($termin['start'])-TERMINE_RUECKMELDUNG_FRIST < time() ) echo '</form>'; ?></div>


  <div class="col-6" style="z-index: 2;"><?php if( !( isset( $ich_rueckmeldung[ $termin['id'] ] ) AND intval($ich_rueckmeldung[ $termin['id'] ]['status']) == 0 ) AND !intval($termin['start'])-TERMINE_RUECKMELDUNG_FRIST < time() ) echo form_open( site_url().'termine/rueckmeldung_machen' ); ?>
    <div class="row no-gutters">
      <div class="col<?php if( ( TERMINE_RUECKMELDUNG_DETAIL_FREWILLIG OR TERMINE_RUECKMELDUNG_DETAIL_ABSAGE ) AND isset($ich_rueckmeldung[ $termin['id'] ]) AND intval($ich_rueckmeldung[ $termin['id'] ]['status']) == 0 ) echo '-9'; ?>">
        <input type="text" class="invisible" name="termin_id" value="<?php echo $termin['id']; ?>" />
        <input type="text" class="invisible" name="status" value="0" />
        <button <?php
        if( ( isset( $ich_rueckmeldung[ $termin['id'] ] ) AND intval($ich_rueckmeldung[ $termin['id'] ]['status']) == 0 ) OR intval($termin['start'])-TERMINE_RUECKMELDUNG_FRIST < time() ) echo 'type="button" disabled ';
        elseif( TERMINE_RUECKMELDUNG_DETAIL_ABSAGE AND ( !isset( $ich_rueckmeldung[ $termin['id'] ] ) OR intval($ich_rueckmeldung[ $termin['id'] ]['status']) >= 1 ) ) { echo 'type="button"
        data-toggle="modal"
        data-target="#absage_machen_detail"
        data-termin_id="'.$termin['id'].'"
        aria-expanded="false" aria-controls="absage_machen_detail" '; }
        else echo 'type="submit" '; ?>class="btn btn<?php if( !isset($ich_rueckmeldung[ $termin['id'] ]) OR intval($ich_rueckmeldung[ $termin['id'] ]['status']) >= 1 ) echo '-outline'; ?>-danger btn-sm btn-block">
          <?php if( isset($ich_rueckmeldung[ $termin['id'] ]) AND intval($ich_rueckmeldung[ $termin['id'] ]['status']) == 0 ) echo 'ABGESAGT'; else echo 'ABSAGEN'; ?>
        </button>
      </div>
      <?php if( ( TERMINE_RUECKMELDUNG_DETAIL_FREWILLIG OR TERMINE_RUECKMELDUNG_DETAIL_ABSAGE ) AND isset( $ich_rueckmeldung[ $termin['id'] ] ) AND intval($ich_rueckmeldung[ $termin['id'] ]['status']) == 0 ) {
        ?><div class="col-3">
        <button type="button" class="btn btn<?php if( empty($ich_rueckmeldung[ $termin['id'] ]['bemerkung']) ) echo '-outline'; ?>-danger btn-sm btn-block"<?php
        if( intval($termin['start'])-TERMINE_RUECKMELDUNG_FRIST < time() ) echo ' disabled'; ?>
        data-toggle="modal"
        data-target="#absage_machen_detail"
        data-termin_id="<?php echo $termin['id']; ?>"
        aria-expanded="false" aria-controls="absage_machen_detail">
          <i class="bi bi-<?php echo SYMBOLE['bemerkung']['bootstrap']; ?>"></i>
        </button>
      </div><?php } ?>
    </div>
  <?php if( !( isset( $ich_rueckmeldung[ $termin['id'] ] ) AND intval($ich_rueckmeldung[ $termin['id'] ]['status']) == 0 ) AND !intval($termin['start'])-TERMINE_RUECKMELDUNG_FRIST < time() ) echo '</form>'; ?></div>


</div><?php } ?>

