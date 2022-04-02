<?php if( isset( $notenverzeichnis_auswaehlen['ziel']) ) echo form_open( $notenverzeichnis_auswaehlen['ziel'] ); ?>
  <div class="modal fade" id="notenverzeichnis_auswaehlen" tabindex="-1" aria-labelledby="notenverzeichnis_auswaehlen_label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title" id="notenverzeichnis_auswaehlen_label">
            <h5>Titel auswählen</h5>
            <span name="bemerkung">bemerkung</span>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal_body"><?php /*foreach( $notenverzeichnis_auswaehlen['notenverzeichnis_cluster'] as $wert => $notenverzeichnis ): ?>
          <div class="col-12 text-muted text-center"><?php if( array_key_exists( $notenverzeichnis_auswaehlen['notenverzeichnis_gruppieren_nach'], VORGEGEBENE_WERTE['notenverzeichnis'] ) ) echo VORGEGEBENE_WERTE['notenverzeichnis'][ $notenverzeichnis_auswaehlen['notenverzeichnis_gruppieren_nach'] ][ $wert ]['beschriftung']; else echo $wert; ?></div>
          <table class="table table-sm"><?php foreach( $notenverzeichnis as $titel ):*/ ?>
          <table class="table table-sm"><?php foreach( $notenverzeichnis_auswaehlen['notenverzeichnis'] as $titel ): ?>
            <tr><td><div class="col">
              <div class="form-check">
                <input class="form-check-input-lg-ml" type="checkbox" value="<?php echo $titel['id']; ?>" name="notenverzeichnis[]" id="titel_<?php echo $titel['id']; ?>"<?php
                if( !isset($notenverzeichnis_auswaehlen['ziel']) ) echo ' disabled'; ?>>
                <label class="form-check-label" for="titel_<?php echo $titel['id']; ?>" id="for_titel_<?php echo $titel['id']; ?>"> <?php echo $titel['titel_nr']; ?> <?php echo $titel['titel']; ?></label>
              </div>
            </div>
          </td></tr><?php endforeach; ?></table>
        <?php //endforeach; ?></div><?php if( isset( $notenverzeichnis_auswaehlen['ziel']) ) { ?><div class="modal-footer pt-0 pb-0">
          <div class="form-check mr-auto ml-3">
            <input class="form-check-input-lg-ml" type="checkbox" id="gesamtes_notenverzeichnis_auswaehlen">
            <label class="form-check-label" for="gesamtes_notenverzeichnis_auswaehlen" id="for_gesamtes_notenverzeichnis_auswaehlen"> Alles auswählen</label>
            <button type="button" class="btn btn-sm btn-outline-primary" id="gesamtes_notenverzeichnis_auswaehlen_reset">Zurücksetzen</button>
          </div>
        </div><?php } ?>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Abbrechen</button>
          <?php if( isset( $notenverzeichnis_auswaehlen['ziel']) ) { ?><input type="text" class="invisible" name="element_id" id="element_id" value="element_id" />
          <button type="submit" class="btn btn-outline-success"><?php echo $notenverzeichnis_auswaehlen['beschriftung']; ?></button><?php } ?>
        </div>
      </div>
    </div>
  </div>
<?php if( isset( $notenverzeichnis_auswaehlen['ziel']) ) echo '</form>'; ?>

<script>

  $('#notenverzeichnis_auswaehlen').on('show.bs.modal', function (event) {

    var gesamtes_notenverzeichnis_auswaehlen_reset = new Array();
    var notenverzeichnis_auswaehlen_bemerkungen = new Array();
    var notenverzeichnis_auswaehlen_checked = new Array();
    var notenverzeichnis_auswaehlen_css = new Array();

<?php foreach( $notenverzeichnis_auswaehlen['elemente'] as $element_id => $element ): ?>
      notenverzeichnis_auswaehlen_bemerkungen[<?php echo $element_id; ?>] = '<?php echo $element['bemerkung']; ?>';
      notenverzeichnis_auswaehlen_checked[<?php echo $element_id; ?>] = new Array();
      <?php if( array_key_exists( 'checked', $element ) ) { /*foreach( $notenverzeichnis_auswaehlen['notenverzeichnis_cluster'] as $wert => $notenverzeichnis ): foreach( $notenverzeichnis as $titel ):*/ foreach( $notenverzeichnis_auswaehlen['notenverzeichnis'] as $titel ): ?>
        notenverzeichnis_auswaehlen_checked[<?php echo $element_id; ?>][<?php echo $titel['id']; ?>] = <?php if( array_key_exists( $titel['id'], $element['checked'] ) AND $element['checked'][ $titel['id'] ] ) echo 'true'; else echo 'false'; ?>;
      <?php endforeach; /*endforeach;*/ } ?>

        notenverzeichnis_auswaehlen_css[<?php echo $element_id; ?>] = new Array();
      <?php if( array_key_exists( 'css', $element ) ) { foreach( $element['css'] as $titel_id => $css ): ?>
        notenverzeichnis_auswaehlen_css[<?php echo $element_id; ?>][<?php echo $titel_id; ?>] = '<?php if( $css ) echo $css; else echo $css; ?>';
      <?php endforeach; } ?>
<?php endforeach; ?>

    var modal = $(this);
    var button = $(event.relatedTarget) // Button that triggered the modal
    var element_id = button.data('element_id');

    modal.find('.modal-title span[name=bemerkung]').text( notenverzeichnis_auswaehlen_bemerkungen[element_id] );
    <?php if( isset( $notenverzeichnis_auswaehlen['ziel']) ) { ?>modal.find('#element_id').val( element_id );
    <?php } ?>

    $.each(notenverzeichnis_auswaehlen_checked[element_id], function(titel_id, checked){
      $('#titel_'+titel_id).prop('checked', checked );
    });

    $.each(notenverzeichnis_auswaehlen_css[element_id], function(titel_id, css){
      $('#for_titel_'+titel_id).addClass( css );
    });

    if( button.data('titel_id') !== undefined ) {
      var titel_id = button.data('titel_id');
      $('#titel_'+titel_id).prop('checked', true );
    }

<?php if( isset( $notenverzeichnis_auswaehlen['ziel']) ) { ?>
    $('#gesamtes_notenverzeichnis_auswaehlen').click( function() {
      $('input[name=notenverzeichnis\\[\\]]').prop( 'checked', $( '#gesamtes_notenverzeichnis_auswaehlen').prop( 'checked') );
    });

    $('#gesamtes_notenverzeichnis_auswaehlen_reset').click( function() {
      $('#gesamtes_notenverzeichnis_auswaehlen').prop('checked', false );
      $.each(notenverzeichnis_auswaehlen_checked[element_id], function(titel_id, checked){
        $('#titel_'+titel_id).prop('checked', checked );
      });
      if( button.data('titel_id') !== undefined ) {
        var titel_id = button.data('titel_id');
        $('#titel_'+titel_id).prop('checked', true );
      }
    });<?php } ?>

  });

</script>

