<?php echo form_open( site_url().'strafkatalog/eintrag_erledigen' ); ?>
  <div class="modal fade" id="eintrag_erledigen" tabindex="-1" aria-labelledby="eintrag_erledigen_label" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title" id="eintrag_erledigen_label"><div class="h5">Kassenbuch aktualisieren</div></div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <span id="eintrag_erledigen_beschriftung">beschriftung</span>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Abbrechen</button>
          <input type="text" class="invisible" name="eintrag_id" id="eintrag_erledigen_eintrag_id" value="" />
          <button type="submit" class="btn btn-outline-success">Ja!</button>
        </div>
      </div>
    </div>
  </div>
</form>

<script>

  $('#eintrag_erledigen').on('show.bs.modal', function (event) {

<?php if( array_key_exists( 'eintraege', $eintrag_erledigen ) AND !empty($eintrag_erledigen['eintraege']) ){ ?>
    var eintrag_erledigen_eintraege = new Array();
<?php foreach( $eintrag_erledigen['eintraege'] as $eintrag_id => $eintrag ): ?>
      eintrag_erledigen_eintraege[<?php echo $eintrag_id; ?>] = new Object();
      eintrag_erledigen_eintraege[<?php echo $eintrag_id; ?>]["beschriftung"] = "<?php echo $eintrag['beschriftung']; ?>";
<?php endforeach; } ?>

    var modal = $(this);
    var button = $(event.relatedTarget) // Button that triggered the modal
    var eintrag_id = button.data('element_id');

    modal.find('#eintrag_erledigen_beschriftung').text( eintrag_erledigen_eintraege[eintrag_id].beschriftung );
    modal.find('#eintrag_erledigen_eintrag_id').val( eintrag_id );
  
  });

</script>

