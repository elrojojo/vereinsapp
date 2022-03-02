<?php if( isset( $mitglieder_auswaehlen['form']) ) echo form_open( $mitglieder_auswaehlen['form'] ); ?>
  <div class="modal fade" id="mitglieder_auswaehlen" tabindex="-1" aria-labelledby="mitglieder_auswaehlen_label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title" id="mitglieder_auswaehlen_label">
            <div class="h5">Mitglieder auswählen</div>
            <div name="bemerkung">bemerkung</div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal_body"><?php foreach( $mitglieder_auswaehlen['mitglieder_cluster'] as $wert => $mitglieder ): ?>
          <div class="col-12 text-muted text-center"><?php if( array_key_exists( $mitglieder_auswaehlen['mitglieder_gruppieren_nach'], VORGEGEBENE_WERTE['mitglieder'] ) ) echo VORGEGEBENE_WERTE['mitglieder'][ $mitglieder_auswaehlen['mitglieder_gruppieren_nach'] ][ $wert ]['beschriftung']; else echo $wert; ?></div>
          <table class="table table-sm"><?php foreach( $mitglieder as $mitglied ): ?>
            <tr><td><div class="col">
              <div class="form-check">
                <input class="form-check-input-lg-ml" type="checkbox" value="<?php echo $mitglied['id']; ?>" name="mitglieder[]" id="mitglied_<?php echo $mitglied['id']; ?>"<?php
                if( !isset($mitglieder_auswaehlen['form']) ) echo ' disabled'; ?>>
                <label class="form-check-label" for="mitglied_<?php echo $mitglied['id']; ?>" id="for_mitglied_<?php echo $mitglied['id']; ?>"> <?php echo $mitglied['vorname']; ?> <?php echo $mitglied['nachname']; ?></label>
              </div>
            </div>
          </td></tr><?php endforeach; ?></table>
        <?php endforeach; ?></div><?php if( isset( $mitglieder_auswaehlen['form']) ) { ?><div class="modal-footer pt-0 pb-0">
          <div class="form-check mr-auto ml-3">
            <input class="form-check-input-lg-ml" type="checkbox" id="alle_mitglieder_auswaehlen">
            <label class="form-check-label" for="alle_mitglieder_auswaehlen" id="for_alle_mitglieder_auswaehlen"> Alles auswählen</label>
            <button type="button" class="btn btn-sm btn-outline-primary" id="alle_mitglieder_auswaehlen_reset">Zurücksetzen</button>
          </div>
        </div><?php } ?>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Abbrechen</button>
          <?php if( isset( $mitglieder_auswaehlen['form']) ) { ?><input type="text" class="invisible" name="element_id" id="element_id" value="element_id" />
          <button type="submit" class="btn btn-outline-success"><?php echo $mitglieder_auswaehlen['beschriftung']; ?></button><?php } ?>
        </div>
      </div>
    </div>
  </div>
<?php if( isset( $mitglieder_auswaehlen['form']) ) echo '</form>'; ?>

<script>

  $('#mitglieder_auswaehlen').on('show.bs.modal', function (event) {

    var alle_mitglieder_auswaehlen_reset = new Array();
    var mitglieder_auswaehlen_bemerkungen = new Array();
    var mitglieder_auswaehlen_checked = new Array();
    var mitglieder_auswaehlen_css = new Array();

<?php foreach( $mitglieder_auswaehlen['elemente'] as $element_id => $element ): ?>
      mitglieder_auswaehlen_bemerkungen[<?php echo $element_id; ?>] = '<?php echo $element['bemerkung']; ?>';
      mitglieder_auswaehlen_checked[<?php echo $element_id; ?>] = new Array();
      <?php if( array_key_exists( 'checked', $element ) ) { foreach( $mitglieder_auswaehlen['mitglieder_cluster'] as $wert => $mitglieder ): foreach( $mitglieder as $mitglied ): ?>
        mitglieder_auswaehlen_checked[<?php echo $element_id; ?>][<?php echo $mitglied['id']; ?>] = <?php if( array_key_exists( $mitglied['id'], $element['checked'] ) AND $element['checked'][ $mitglied['id'] ] ) echo 'true'; else echo 'false'; ?>;
      <?php endforeach; endforeach; } ?>

        mitglieder_auswaehlen_css[<?php echo $element_id; ?>] = new Array();
      <?php if( array_key_exists( 'css', $element ) ) { foreach( $element['css'] as $mitglied_id => $css ): ?>
        mitglieder_auswaehlen_css[<?php echo $element_id; ?>][<?php echo $mitglied_id; ?>] = '<?php if( $css ) echo $css; else echo $css; ?>';
      <?php endforeach; } ?>
<?php endforeach; ?>

    var modal = $(this);
    var button = $(event.relatedTarget) // Button that triggered the modal
    var element_id = button.data('element_id');

    modal.find('.modal-title div[name=bemerkung]').text( mitglieder_auswaehlen_bemerkungen[element_id] );
    <?php if( isset( $mitglieder_auswaehlen['form']) ) { ?>modal.find('#element_id').val( element_id );
    <?php } ?>

    $.each(mitglieder_auswaehlen_checked[element_id], function(mitglied_id, checked){
      $('#mitglied_'+mitglied_id).prop('checked', checked );
    });

    $.each(mitglieder_auswaehlen_css[element_id], function(mitglied_id, css){
      $('#for_mitglied_'+mitglied_id).addClass( css );
    });

    if( button.data('mitglied_id') !== undefined ) {
      var mitglied_id = button.data('mitglied_id');
      $('#mitglied_'+mitglied_id).prop('checked', true );
    }

<?php if( isset( $mitglieder_auswaehlen['form']) ) { ?>
    $('#alle_mitglieder_auswaehlen').click( function() {
      $('input[name=mitglieder\\[\\]]').prop( 'checked', $( '#alle_mitglieder_auswaehlen').prop( 'checked') );
    });

    $('#alle_mitglieder_auswaehlen_reset').click( function() {
      $('#alle_mitglieder_auswaehlen').prop('checked', false );
      $.each(mitglieder_auswaehlen_checked[element_id], function(mitglied_id, checked){
        $('#mitglied_'+mitglied_id).prop('checked', checked );
      });
      if( button.data('mitglied_id') !== undefined ) {
        var mitglied_id = button.data('mitglied_id');
        $('#mitglied_'+mitglied_id).prop('checked', true );
      }
    });<?php } ?>

  });

</script>

