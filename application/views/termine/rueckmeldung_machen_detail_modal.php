<?php echo form_open( site_url().'termine/rueckmeldung_machen' ) ; ?>
  <div class="modal fade" id="<?php if( $rueckmeldung_machen_detail_modal ) echo 'zusage'; else echo 'absage' ?>_machen_detail" tabindex="-1" aria-labelledby="<?php if( $rueckmeldung_machen_detail_modal ) echo 'zusage'; else echo 'absage' ?>_machen_detail_label" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title" id="<?php if( $rueckmeldung_machen_detail_modal ) echo 'zusage'; else echo 'absage' ?>_machen_detail_label">
            Für deine <?php if( $rueckmeldung_machen_detail_modal ) echo 'Zusage'; else echo 'Absage' ?>
            ist eine kurze <?php if( $rueckmeldung_machen_detail_modal OR ( !$rueckmeldung_machen_detail_modal AND !TERMINE_RUECKMELDUNG_DETAIL_ABSAGE ) ) echo 'Bemerkung möglich'; else echo 'Begründung erforderlich' ?>!
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
        <input type="text" class="form-control"<?php if( $rueckmeldung_machen_detail_modal OR ( !$rueckmeldung_machen_detail_modal AND !TERMINE_RUECKMELDUNG_DETAIL_ABSAGE ) ) echo ' placeholder="(optional)"'; ?> name="bemerkung" value="bemerkung">
          <input type="text" class="invisible" name="termin_id" value="" />
          <input type="text" class="invisible" name="status" value="<?php echo $rueckmeldung_machen_detail_modal; ?>" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Abbrechen</button>
          <button type="submit" class="btn btn-outline-<?php if( $rueckmeldung_machen_detail_modal OR ( !$rueckmeldung_machen_detail_modal AND !TERMINE_RUECKMELDUNG_DETAIL_ABSAGE ) ) echo 'success'; else echo 'danger' ?>"><?php
          if( $rueckmeldung_machen_detail_modal OR ( !$rueckmeldung_machen_detail_modal AND !TERMINE_RUECKMELDUNG_DETAIL_ABSAGE ) ) echo ' Speichern'; else echo 'Absagen'; ?></button>
        </div>
      </div>
    </div>
  </div>
</form>

<script>

  $('#<?php if( $rueckmeldung_machen_detail_modal ) echo 'zusage'; else echo 'absage' ?>_machen_detail').on('show.bs.modal', function (event) {
    var bemerkungen = [];
    <?php if( isset($termine) ) foreach( $termine as $termin ): ?>
    bemerkungen[<?php echo $termin['id']; ?>] = "<?php if( isset($ich_rueckmeldung[ $termin['id'] ]) AND intval($ich_rueckmeldung[ $termin['id'] ]['status']) == $rueckmeldung_machen_detail_modal ) echo $ich_rueckmeldung[ $termin['id'] ]['bemerkung']; ?>";
    <?php endforeach; else { ?>
    bemerkungen[<?php echo $termin['id']; ?>] = "<?php if( isset($ich_rueckmeldung[ $termin['id'] ]) AND intval($ich_rueckmeldung[ $termin['id'] ]['status']) == $rueckmeldung_machen_detail_modal ) echo $ich_rueckmeldung[ $termin['id'] ]['bemerkung']; ?>";
    <?php } ?>

    var button = $(event.relatedTarget) // Button that triggered the modal
    var termin_id = button.data('termin_id');
    var modal = $(this);
    modal.find('.modal-body input[name=termin_id]').val(termin_id);
    modal.find('.modal-body input[name=bemerkung]').val(bemerkungen[termin_id]);
  })
  
</script>

