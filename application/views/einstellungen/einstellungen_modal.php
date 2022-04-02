<?php echo form_open( site_url().'einstellungen/einstellung_setzen' ) ; ?>
  <div class="modal fade" id="einstellungen" tabindex="-1" aria-labelledby="einstellungen_label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="einstellungen_label">Einstellungen</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <div class="modal-body">
            <?php foreach( $einstellungen as $gruppe => $funktionen ): foreach( $funktionen as $funktion => $meine_einstellung ): ?>

              <div class="form-group mb-2">
                <label class="form-text m-0 ml-1" for="passwort_neu"><?php echo EINSTELLUNGEN[ $gruppe ][ $funktion ]['titel']; ?>:</label>
                <select class="form-control" name="<?php echo $gruppe; ?>_<?php echo $funktion; ?>_wert">
                <?php  foreach ( EINSTELLUNGEN[ $gruppe ][ $funktion ]['werte'] as $wert => $beschriftung ): ?>
                  <option value="<?php echo $wert; ?>"<?php if( $wert == $meine_einstellung ) echo ' selected'; ?>><?php echo $beschriftung; ?></option>
                <?php endforeach; ?>
                </select>
                <input type="text" class="invisible" name="<?php echo $gruppe; ?>_gruppe" value="<?php echo $gruppe; ?>" />
                <input type="text" class="invisible" name="<?php echo $funktion; ?>_funktion" value="<?php echo $funktion; ?>" />
              </div>

            <?php endforeach; endforeach; ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Abbrechen</button>
            <button type="submit" class="btn btn-outline-success">Speichern</button>
          </div>
      </div>
    </div>
  </div>
</form>

