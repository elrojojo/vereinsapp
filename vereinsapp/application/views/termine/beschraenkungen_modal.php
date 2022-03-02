<?php if( isset( $beschraenkungen['ziel']) ) echo form_open( $beschraenkungen['ziel'] ); ?>
<div class="modal fade" id="beschraenkungen" tabindex="-1" aria-labelledby="beschraenkungen_label" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title" id="beschraenkungen_label">
          <h5>Eingeladene Mitglieder</h5>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php foreach( TERMINE_KATEGORIEN_BESCHR_MITGLIEDER as $beschr_kategorie ): ?><div class="col-12 text-muted text-center"><?php echo MITGLIEDER_KATEGORIEN[ $beschr_kategorie ]['beschriftung']; ?></div>
        <table class="table table-sm"><?php foreach( verfuegbare_werte_in_spalte( array_column( MITGLIEDER, $beschr_kategorie ) ) as $wert ): ?><tr><td><div class="col">
          <div class="form-check">
            <input class="form-check-input-lg-ml" type="checkbox" value="<?php echo $wert; ?>" name="<?php echo $beschr_kategorie; ?>[]" id="<?php echo $beschr_kategorie.'_'.$wert; ?>"<?php
            if( !array_key_exists( $beschr_kategorie, $termin['beschr_mitglieder'] ) OR !in_array( $wert, $termin['beschr_mitglieder'][ $beschr_kategorie ] ) ) echo ' checked'; ?><?php
            if( !isset($beschraenkungen['ziel']) ) echo ' disabled'; ?>>
            <label class="form-check-label" for="<?php echo $beschr_kategorie.'_'.$wert; ?>"> <?php if( array_key_exists( $beschr_kategorie, VORGEGEBENE_WERTE['mitglieder'] ) ) echo VORGEGEBENE_WERTE['mitglieder'][ $beschr_kategorie ][ $wert ]['beschriftung']; else echo $wert; ?></label>
          </div>
        </div></td></tr><?php endforeach; ?></table>
      <?php endforeach; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Abbrechen</button>
        <?php if( isset( $beschraenkungen['ziel']) ) { ?><input type="text" class="invisible" name="termin_id" value="<?php echo $termin['id']; ?>" />
        <button type="submit" class="btn btn-outline-success">Auswahl speichern</button><?php } ?>
      </div>
    </div>
  </div>
</div>
<?php if( isset( $beschraenkungen['ziel']) ) echo '</form>'; ?>

