<?php if( isset( $eintragen['form']) ) echo form_open( $eintragen['form'] ); ?>
  <div class="modal fade" id="termin_eintragen" tabindex="-1" aria-labelledby="termin_eintragen_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="termin_eintragen_label">titel</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">

          <div class="form-group mb-2">
            <label class="small m-0 ml-1" for="termin_eintragen_titel"><?php echo TERMINE_KATEGORIEN['titel']['beschriftung']; ?>:</label>
            <input type="text" class="form-control" name="titel" id="termin_eintragen_titel" value="" />
          </div>

          <div class="form-group mb-2">
            <label class="small m-0 ml-1" for="termin_eintragen_start_datum"><?php echo TERMINE_KATEGORIEN['start']['beschriftung']; ?>:</label>
            <div class="input-group flex-nowrap ">
              <input type="date" class="form-control" name="start_datum" id="termin_eintragen_start_datum" value="<?php echo html_date( ceil( time()/60/60 )*60*60 ); ?>" min="<?php echo html_date( time() ); ?>" />
              <input type="time" class="form-control" name="start_zeit" id="termin_eintragen_start_zeit" value="<?php echo html_time( ceil( time()/60/60 )*60*60 ); ?>" />
            </div>
          </div>

          <div class="form-group mb-2">
            <label class="small m-0 ml-1" for="termin_eintragen_ort"><?php echo TERMINE_KATEGORIEN['ort']['beschriftung']; ?>:</label>
            <input type="text" class="form-control" name="ort" id="termin_eintragen_ort" value="" />
          </div>

          <?php if( array_key_exists( 'organisator', TERMINE_KATEGORIEN ) ) { ?><div class="form-group mb-2">
            <label class="small m-0 ml-1" for="termin_eintragen_organisator"><?php echo TERMINE_KATEGORIEN['organisator']['beschriftung']; ?>:</label>
            <input type="text" class="form-control" placeholder="(optional)" name="organisator" id="termin_eintragen_organisator" value="" />
          </div><?php } ?>

          <?php if( array_key_exists( 'bemerkung', TERMINE_KATEGORIEN ) ) { ?><div class="form-group mb-2">
            <label class="small m-0 ml-1" for="termin_eintragen_bemerkung"><?php echo TERMINE_KATEGORIEN['bemerkung']['beschriftung']; ?>:</label>
            <input type="text" class="form-control" placeholder="(optional)" name="bemerkung" id="termin_eintragen_bemerkung" value="" />
          </div><?php } ?>

          <div class="form-group mb-2">
            <label class="small m-0 ml-1" for="termin_eintragen_typ"><?php echo TERMINE_KATEGORIEN['typ']['beschriftung']; ?>:</label>
            <select class="form-control" name="typ" id="termin_eintragen_typ">
            <?php  foreach ( VORGEGEBENE_WERTE['termine']['typ'] as $typ => $eigenschaften ): ?>
              <option value="<?php echo $typ; ?>"><?php echo $eigenschaften['beschriftung']; ?></option>
            <?php endforeach; ?>
            </select>
          </div>

          <div class="form-check invisible">
            <input class="form-check-input-lg-ml" type="checkbox" value="beschr_mitglieder" name="beschr_mitglieder" id="termin_eintragen_beschr_mitglieder" checked>
            <label class="form-check-label" for="termin_eintragen_beschr_mitglieder">Einladungen übernehmen</label>
            <input type="text" class="invisible" name="termin_id_beschr_mitglieder" id="termin_eintragen_termin_id_beschr_mitglieder" value="" />
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Abbrechen</button>
          <input type="text" class="invisible" name="termin_id" id="termin_eintragen_termin_id" value="" />
          <button type="submit" class="btn btn-outline-success" id="termin_eintragen_submit">submit</button>
        </div>
      </div>
    </div>
  </div>
<?php if( isset( $eintragen['form']) ) echo '</form>'; ?>

<script>

  $('#termin_eintragen').on('show.bs.modal', function (event) {

    var termin_eintragen_titel = new Object();
<?php foreach( $eintragen['titel'] as $aktion => $titel ): ?>
      termin_eintragen_titel["<?php echo $aktion; ?>"] = "<?php echo $titel; ?>";
<?php endforeach; ?>

    var termin_eintragen_submit = new Object();
<?php foreach( $eintragen['submit'] as $aktion => $submit ): ?>
      termin_eintragen_submit["<?php echo $aktion; ?>"] = "<?php echo $submit; ?>";
<?php endforeach; ?>

<?php if( array_key_exists( 'termine', $eintragen ) AND !empty($eintragen['termine']) ){ ?>
    var termin_eintragen_termine = new Array();
<?php foreach( $eintragen['termine'] as $termin_id => $termin ): ?>
      termin_eintragen_termine[<?php echo $termin_id; ?>] = new Object();
      termin_eintragen_termine[<?php echo $termin_id; ?>]["titel"] = "<?php echo $termin['titel']; ?>";
      termin_eintragen_termine[<?php echo $termin_id; ?>]["start_datum"] = "<?php echo html_date( intval($termin['start']) ); ?>";
      termin_eintragen_termine[<?php echo $termin_id; ?>]["start_zeit"] = "<?php echo html_time( intval($termin['start']) ); ?>";
      termin_eintragen_termine[<?php echo $termin_id; ?>]["ort"] = "<?php echo $termin['ort']; ?>";
      <?php if( array_key_exists( 'organisator', TERMINE_KATEGORIEN ) ) { ?>termin_eintragen_termine[<?php echo $termin_id; ?>]["organisator"] = "<?php echo $termin['organisator']; ?>";<?php } ?>
      <?php if( array_key_exists( 'bemerkung', TERMINE_KATEGORIEN ) ) { ?>termin_eintragen_termine[<?php echo $termin_id; ?>]["bemerkung"] = "<?php echo $termin['bemerkung']; ?>";<?php } ?>
      termin_eintragen_termine[<?php echo $termin_id; ?>]["typ"] = "<?php echo $termin['typ']; ?>";
<?php endforeach; } ?>

    var modal = $(this);
    var button = $(event.relatedTarget) // Button that triggered the modal
    var aktion = button.data('aktion');

    modal.find('.modal-title').text( termin_eintragen_titel[aktion] );
    //modal.find('.modal-title span[name=bemerkung]').text( mitglieder_auswaehlen_bemerkungen[element_id] );

    modal.find('#termin_eintragen_beschr_mitglieder').parent().addClass( 'invisible' );  // beschr_mitglieder ausblenden
    modal.find('#termin_eintragen_beschr_mitglieder').prop( 'checked', false );
    modal.find('#termin_eintragen_termin_id_beschr_mitglieder').val();

    if( button.data('termin_id') !== undefined ) {
      var termin_id = button.data('termin_id');
      modal.find('#termin_eintragen_titel').val( termin_eintragen_termine[termin_id].titel );
      modal.find('#termin_eintragen_start_datum').val( termin_eintragen_termine[termin_id].start_datum );
      modal.find('#termin_eintragen_start_zeit').val( termin_eintragen_termine[termin_id].start_zeit );
      modal.find('#termin_eintragen_ort').val( termin_eintragen_termine[termin_id].ort );
      <?php if( array_key_exists( 'organisator', TERMINE_KATEGORIEN ) ) { ?>modal.find('#termin_eintragen_organisator').val( termin_eintragen_termine[termin_id].organisator );<?php } ?>
      <?php if( array_key_exists( 'bemerkung', TERMINE_KATEGORIEN ) ) { ?> modal.find('#termin_eintragen_bemerkung').val( termin_eintragen_termine[termin_id].bemerkung );<?php } ?>
      modal.find("#termin_eintragen_typ").val( termin_eintragen_termine[termin_id].typ ).change();
      if( aktion == "duplizieren" ) { // beschr_mitglieder einblenden
        modal.find('#termin_eintragen_beschr_mitglieder').parent().removeClass( 'invisible' );
        modal.find('#termin_eintragen_beschr_mitglieder').prop( 'checked', true );
        modal.find('#termin_eintragen_termin_id_beschr_mitglieder').val( termin_id );
      }
      if( aktion == "aendern" ) modal.find('#termin_eintragen_termin_id').val( termin_id ); else modal.find('#termin_eintragen_termin_id').val( "" );
    } else { 
      modal.find('#termin_eintragen_titel').val( "" );
      modal.find('#termin_eintragen_start_datum').val( "" );
      modal.find('#termin_eintragen_start_zeit').val( "" );
      modal.find('#termin_eintragen_ort').val( "" );
      <?php if( array_key_exists( 'organisator', TERMINE_KATEGORIEN ) ) { ?>modal.find('#termin_eintragen_organisator').val( "" );<?php } ?>
      <?php if( array_key_exists( 'bemerkung', TERMINE_KATEGORIEN ) ) { ?>modal.find('#termin_eintragen_bemerkung').val( "" );<?php } ?>
      modal.find("#termin_eintragen_typ").val( "" ).change();
      modal.find('#termin_eintragen_termin_id').val( "" );
    }
    modal.find('#termin_eintragen_submit').text( termin_eintragen_submit[aktion] );

  });

</script>

