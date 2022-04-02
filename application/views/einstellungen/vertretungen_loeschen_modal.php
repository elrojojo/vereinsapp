<?php echo form_open( site_url().'einstellungen/einstellungen_vertretung_austragen' ); ?>
  <div class="modal fade" id="<?php if( $ich_vertrete ) echo 'ich_vertrete'; else echo 'ich_werde_vertreten'; ?>_loeschen" tabindex="-1" aria-labelledby="<?php if( $ich_vertrete ) echo 'ich_vertrete'; else echo 'ich_werde_vertreten'; ?>_loeschen_label" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title" id="<?php if( $ich_vertrete ) echo 'ich_vertrete'; else echo 'ich_werde_vertreten'; ?>_loeschen_label">
            <div class="h5">Vertretung löschen</div>
            <div name="bemerkung">Welches Recht innerhalb der Vertretung <?php if( $ich_vertrete ) echo 'von'; else echo 'durch'; ?> <span id="<?php if( $ich_vertrete ) echo 'ich_vertrete'; else echo 'ich_werde_vertreten'; ?>_mitglied">mitglied</span> willst du löschen?</div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <div class="modal-body">
            <ul id="<?php if( $ich_vertrete ) echo 'ich_vertrete'; else echo 'ich_werde_vertreten'; ?>_liste" class="list-group">
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Abbrechen</button>
          </div>
      </div>
    </div>
  </div>
</form>
<script>
  

  $('#<?php if( $ich_vertrete ) echo 'ich_vertrete'; else echo 'ich_werde_vertreten'; ?>_loeschen').on('show.bs.modal', function (event) {

    var <?php if( $ich_vertrete ) echo 'ich_vertrete'; else echo 'ich_werde_vertreten'; ?>_vertretungen_cluster = new Array();
<?php foreach( $vertretungen_cluster as $element_id => $vertretungen ): ?>
      <?php if( $ich_vertrete ) echo 'ich_vertrete'; else echo 'ich_werde_vertreten'; ?>_vertretungen_cluster[<?php echo $element_id; ?>] = new Object();
      <?php if( $ich_vertrete ) echo 'ich_vertrete'; else echo 'ich_werde_vertreten'; ?>_vertretungen_cluster[<?php echo $element_id; ?>]["mitglied"] = "<?php if( array_key_exists( intval($element_id), MITGLIEDER ) ) echo MITGLIEDER[ $element_id ]['vorname'].' '.MITGLIEDER[ $element_id ]['nachname']; else echo 'Mitglied gelöscht'; ?>";
      <?php if( $ich_vertrete ) echo 'ich_vertrete'; else echo 'ich_werde_vertreten'; ?>_vertretungen_cluster[<?php echo $element_id; ?>]["vertretungen"] = new Array();
<?php foreach( $vertretungen as $vertretung ): ?>
        <?php if( $ich_vertrete ) echo 'ich_vertrete'; else echo 'ich_werde_vertreten'; ?>_vertretungen_cluster[<?php echo $element_id; ?>]["vertretungen"][<?php echo $vertretung['id']; ?>] = "<?php echo RECHTE[ $vertretung['recht'] ]['beschriftung']; ?>";
<?php endforeach; ?>
<?php endforeach; ?>

    var modal = $(this);
    var button = $(event.relatedTarget) // Button that triggered the modal
    var element_id = button.data('element_id');

    modal.find('#<?php if( $ich_vertrete ) echo 'ich_vertrete'; else echo 'ich_werde_vertreten'; ?>_mitglied').text( <?php if( $ich_vertrete ) echo 'ich_vertrete'; else echo 'ich_werde_vertreten'; ?>_vertretungen_cluster[element_id]["mitglied"] );

    var html_body = '';
    <?php if( $ich_vertrete ) echo 'ich_vertrete'; else echo 'ich_werde_vertreten'; ?>_vertretungen_cluster[element_id]["vertretungen"].forEach( (vertretung, vertretung_id) => {
      html_body += '<button type="submit" class="list-group-item list-group-item-action" name="vertretung_id" value="'+vertretung_id+'">'+vertretung+' <i class="bi bi-trash text-danger float-right"></i></button>';
    } );
    modal.find('#<?php if( $ich_vertrete ) echo 'ich_vertrete'; else echo 'ich_werde_vertreten'; ?>_liste').html( html_body );

  })

</script>

