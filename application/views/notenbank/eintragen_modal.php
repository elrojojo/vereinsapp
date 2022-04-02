<?php if( isset( $eintragen['form']) ) echo form_open( $eintragen['form'] ); ?>
  <div class="modal fade" id="notenverzeichnis_eintragen" tabindex="-1" aria-labelledby="notenverzeichnis_eintragen_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="notenverzeichnis_eintragen_label">titel</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group form-row mb-2">
            <div class="col-3">
              <label class="small m-0 ml-1" for="notenverzeichnis_eintragen_titel_nr"><?php echo NOTENVERZEICHNIS_KATEGORIEN['titel_nr']['beschriftung']; ?>:</label>
              <input type="number" class="form-control" name="titel_nr" id="notenverzeichnis_eintragen_titel_nr" value="" />
            </div>
            <div class="col-9">
              <label class="small m-0 ml-1" for="notenverzeichnis_eintragen_titel"><?php echo NOTENVERZEICHNIS_KATEGORIEN['titel']['beschriftung']; ?>:</label>
              <input type="text" class="form-control" name="titel" id="notenverzeichnis_eintragen_titel" value="" />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Abbrechen</button>
          <input type="text" class="invisible" name="titel_id" id="notenverzeichnis_eintragen_titel_id" value="" />
          <button type="submit" class="btn btn-outline-success" id="notenverzeichnis_eintragen_submit">submit</button>
        </div>
      </div>
    </div>
  </div>
<?php if( isset( $eintragen['form']) ) echo '</form>'; ?>

<script>

  $('#notenverzeichnis_eintragen').on('show.bs.modal', function (event) {

    var notenverzeichnis_eintragen_titel = new Object();
<?php foreach( $eintragen['titel'] as $aktion => $titel ): ?>
      notenverzeichnis_eintragen_titel["<?php echo $aktion; ?>"] = "<?php echo $titel; ?>";
<?php endforeach; ?>

    var notenverzeichnis_eintragen_submit = new Object();
<?php foreach( $eintragen['submit'] as $aktion => $submit ): ?>
      notenverzeichnis_eintragen_submit["<?php echo $aktion; ?>"] = "<?php echo $submit; ?>";
<?php endforeach; ?>

<?php if( array_key_exists( 'notenverzeichnis', $eintragen ) AND !empty($eintragen['notenverzeichnis']) ){ ?>
    var notenverzeichnis_eintragen_notenverzeichnis = new Array();
<?php foreach( $eintragen['notenverzeichnis'] as $titel_id => $titel ): ?>
      notenverzeichnis_eintragen_notenverzeichnis[<?php echo $titel_id; ?>] = new Object();
      notenverzeichnis_eintragen_notenverzeichnis[<?php echo $titel_id; ?>]["titel_nr"] = "<?php echo $titel['titel_nr']; ?>";
      notenverzeichnis_eintragen_notenverzeichnis[<?php echo $titel_id; ?>]["titel"] = "<?php echo $titel['titel']; ?>";
<?php endforeach; } ?>

    var modal = $(this);
    var button = $(event.relatedTarget) // Button that triggered the modal
    var aktion = button.data('aktion');

    modal.find('.modal-title').text( notenverzeichnis_eintragen_titel[aktion] );
    //modal.find('.modal-title span[name=bemerkung]').text( notenverzeichnis_auswaehlen_bemerkungen[element_id] );

    if( button.data('titel_id') !== undefined ) {
      var titel_id = button.data('titel_id');
      if( aktion == "duplizieren" ) modal.find('#notenverzeichnis_eintragen_titel_nr').val( "<?php echo $eintragen['naechste_freie_titel_nr'] ?>" );
      else modal.find('#notenverzeichnis_eintragen_titel_nr').val( notenverzeichnis_eintragen_notenverzeichnis[titel_id].titel_nr );
      modal.find('#notenverzeichnis_eintragen_titel').val( notenverzeichnis_eintragen_notenverzeichnis[titel_id].titel );
      if( aktion == "aendern" ) modal.find('#notenverzeichnis_eintragen_titel_id').val( titel_id );
      else modal.find('#notenverzeichnis_eintragen_titel_id').val( "" );
    } else {
      modal.find('#notenverzeichnis_eintragen_titel_nr').val( "<?php echo $eintragen['naechste_freie_titel_nr'] ?>" );
      modal.find('#notenverzeichnis_eintragen_titel').val( "" );
      modal.find('#notenverzeichnis_eintragen_titel_id').val( "" );
    }
    modal.find('#notenverzeichnis_eintragen_submit').text( notenverzeichnis_eintragen_submit[aktion] );

  });

</script>

