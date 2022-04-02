<?php if( isset( $eintragen['form']) ) echo form_open( $eintragen['form'] ); ?>
  <div class="modal fade" id="strafe_eintragen" tabindex="-1" aria-labelledby="strafe_eintragen_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="strafe_eintragen_label">titel</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">

          <div class="form-group mb-2">
            <label class="small m-0 ml-1" for="strafe_eintragen_grund"><?php echo STRAFKATALOG_KATEGORIEN['grund']['beschriftung']; ?>:</label>
            <input type="text" class="form-control" name="grund" id="strafe_eintragen_grund" value="" />
          </div>

          <div class="form-group mb-2">
            <label class="small m-0 ml-1" for="strafe_eintragen_bemerkung"><?php echo STRAFKATALOG_KATEGORIEN['bemerkung']['beschriftung']; ?>:</label>
            <input type="text" class="form-control" name="bemerkung" id="strafe_eintragen_bemerkung" value="" />
          </div>

          <div class="form-group mb-2">
            <label class="small m-0 ml-1" for="strafe_eintragen_betrag"><?php echo STRAFKATALOG_KATEGORIEN['betrag']['beschriftung']; ?>:</label>
            <input type="number" class="form-control" name="betrag" id="strafe_eintragen_betrag" value="" min="0" />
          </div>

          <div class="form-group mb-2">
            <label class="small m-0 ml-1" for="strafe_eintragen_funktion"><?php echo STRAFKATALOG_KATEGORIEN['kapitel_id']['beschriftung']; ?>:</label>
            <select class="form-control" name="kapitel_id" id="strafe_eintragen_kapitel_id">
            <?php  foreach ( $eintragen['kapiteln'] as $kapitel ): ?>
              <option value="<?php echo $kapitel['id']; ?>"><?php echo $kapitel['titel']; ?></option>
            <?php endforeach; ?>
            </select>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Abbrechen</button>
          <input type="text" class="invisible" name="strafe_id" id="strafe_eintragen_strafe_id" value="" />
          <button type="submit" class="btn btn-outline-success" id="strafe_eintragen_submit">submit</button>
        </div>
      </div>
    </div>
  </div>
<?php if( isset( $eintragen['form']) ) echo '</form>'; ?>

<script>

  $('#strafe_eintragen').on('show.bs.modal', function (event) {

    var strafe_eintragen_titel = new Object();
<?php foreach( $eintragen['titel'] as $aktion => $titel ): ?>
      strafe_eintragen_titel["<?php echo $aktion; ?>"] = "<?php echo $titel; ?>";
<?php endforeach; ?>

    var strafe_eintragen_submit = new Object();
<?php foreach( $eintragen['submit'] as $aktion => $submit ): ?>
      strafe_eintragen_submit["<?php echo $aktion; ?>"] = "<?php echo $submit; ?>";
<?php endforeach; ?>

<?php if( array_key_exists( 'strafen', $eintragen ) AND !empty($eintragen['strafen']) ){ ?>
    var strafe_eintragen_strafen = new Array();
<?php foreach( $eintragen['strafen'] as $strafe_id => $strafe ): ?>
      strafe_eintragen_strafen[<?php echo $strafe_id; ?>] = new Object();
      strafe_eintragen_strafen[<?php echo $strafe_id; ?>]["grund"] = "<?php echo $strafe['grund']; ?>";
      strafe_eintragen_strafen[<?php echo $strafe_id; ?>]["bemerkung"] = "<?php echo $strafe['bemerkung']; ?>";
      strafe_eintragen_strafen[<?php echo $strafe_id; ?>]["betrag"] = "<?php echo $strafe['betrag']; ?>";
      strafe_eintragen_strafen[<?php echo $strafe_id; ?>]["kapitel_id"] = "<?php echo $strafe['kapitel_id']; ?>";
<?php endforeach; } ?>

    var modal = $(this);
    var button = $(event.relatedTarget) // Button that triggered the modal
    var aktion = button.data('aktion');

    modal.find('.modal-title').text( strafe_eintragen_titel[aktion] );
    //modal.find('.modal-title span[name=bemerkung]').text( strafe_auswaehlen_bemerkungen[element_id] );

    if( button.data('strafe_id') !== undefined ) {
      var strafe_id = button.data('strafe_id');
      modal.find('#strafe_eintragen_grund').val( strafe_eintragen_strafen[strafe_id].grund );
      modal.find('#strafe_eintragen_bemerkung').val( strafe_eintragen_strafen[strafe_id].bemerkung );
      modal.find('#strafe_eintragen_betrag').val( strafe_eintragen_strafen[strafe_id].betrag );
      modal.find("#strafe_eintragen_kapitel_id").val( strafe_eintragen_strafen[strafe_id].kapitel_id ).change();
      if( aktion == "aendern" ) modal.find('#strafe_eintragen_strafe_id').val( strafe_id ); else modal.find('#strafe_eintragen_strafe_id').val( "" );
    } else { 
      modal.find('#strafe_eintragen_grund').val( "" );
      modal.find('#strafe_eintragen_bemerkung').val( "" );
      modal.find('#strafe_eintragen_betrag').val( "" );
      modal.find("#strafe_eintragen_kapitel_id").val( "<?php echo array_key_first( $eintragen['kapiteln'] ); ?>" ).change();
      modal.find('#strafe_eintragen_strafe_id').val( "" );
    }
    modal.find('#strafe_eintragen_submit').text( strafe_eintragen_submit[aktion] );

  });

</script>

