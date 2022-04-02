<?php if( isset( $eintragen['form']) ) echo form_open( $eintragen['form'] ); ?>
  <div class="modal fade" id="eintrag_eintragen" tabindex="-1" aria-labelledby="eintrag_eintragen_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="eintrag_eintragen_label">titel</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">

          <div class="input-group mb-2">
            <div class="input-group-prepend">
              <label class="input-group-text" for="eintrag_eintragen_zeitpunkt"><i class="bi bi-<?php echo SYMBOLE['datum']['bootstrap']; ?>"></i></label>
            </div>
            <input type="date" class="form-control" name="zeitpunkt" id="eintrag_eintragen_zeitpunkt" vvalue="" max="<?php echo html_date( time() ); ?>">
          </div>

          <div class="input-group mb-2">
            <div class="input-group-prepend">
              <label class="input-group-text" for="eintrag_eintragen_mitglied_id"><i class="bi bi-<?php echo SYMBOLE['mitglied']['bootstrap']; ?>"></i></label>
            </div>
            <select class="form-control" name="mitglied_id" id="eintrag_eintragen_mitglied_id">
            <?php foreach ( MITGLIEDER as $mitglied ): ?>
              <option value="<?php echo $mitglied['id']; ?>"><?php echo $mitglied['vorname'].' '.$mitglied['nachname']; ?></option>
            <?php endforeach; ?>
            </select>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Abbrechen</button>
          <input type="text" class="invisible" name="eintrag_id" id="eintrag_eintragen_eintrag_id" value="" />
          <button type="submit" class="btn btn-outline-success" id="eintrag_eintragen_submit">submit</button>
        </div>
      </div>
    </div>
  </div>
<?php if( isset( $eintragen['form']) ) echo '</form>'; ?>

<script>

  $('#eintrag_eintragen').on('show.bs.modal', function (event) {

    var eintrag_eintragen_titel = new Object();
<?php foreach( $eintragen['titel'] as $aktion => $titel ): ?>
      eintrag_eintragen_titel["<?php echo $aktion; ?>"] = "<?php echo $titel; ?>";
<?php endforeach; ?>

    var eintrag_eintragen_submit = new Object();
<?php foreach( $eintragen['submit'] as $aktion => $submit ): ?>
      eintrag_eintragen_submit["<?php echo $aktion; ?>"] = "<?php echo $submit; ?>";
<?php endforeach; ?>

<?php if( array_key_exists( 'eintraege', $eintragen ) AND !empty($eintragen['eintraege']) ){ ?>
    var eintrag_eintragen_eintraege = new Array();
<?php foreach( $eintragen['eintraege'] as $eintrag_id => $eintrag ): ?>
      eintrag_eintragen_eintraege[<?php echo $eintrag_id; ?>] = new Object();
      eintrag_eintragen_eintraege[<?php echo $eintrag_id; ?>]["zeitpunkt"] = "<?php echo html_date( $eintrag['zeitpunkt'] ); ?>";
      eintrag_eintragen_eintraege[<?php echo $eintrag_id; ?>]["mitglied_id"] = "<?php echo $eintrag['mitglied_id']; ?>";
<?php endforeach; } ?>

    var modal = $(this);
    var button = $(event.relatedTarget) // Button that triggered the modal
    var aktion = button.data('aktion');

    modal.find('.modal-title').text( eintrag_eintragen_titel[aktion] );
    //modal.find('.modal-title span[name=bemerkung]').text( eintrag_auswaehlen_bemerkungen[element_id] );

    if( button.data('eintrag_id') !== undefined ) {
      var eintrag_id = button.data('eintrag_id');
      modal.find('#eintrag_eintragen_zeitpunkt').val( eintrag_eintragen_eintraege[eintrag_id].zeitpunkt );
      modal.find('#eintrag_eintragen_mitglied_id').val( eintrag_eintragen_eintraege[eintrag_id].mitglied_id ).change();
      if( aktion == "aendern" ) modal.find('#eintrag_eintragen_eintrag_id').val( eintrag_id ); else modal.find('#eintrag_eintragen_eintrag_id').val( "" );
    } else { 
      modal.find('#eintrag_eintragen_zeitpunkt').val( "" );
      modal.find('#eintrag_eintragen_mitglied_id').val( "" ).change();
      modal.find('#eintrag_eintragen_eintrag_id').val( "" );
    }
    modal.find('#eintrag_eintragen_submit').text( eintrag_eintragen_submit[aktion] );

  });

</script>

