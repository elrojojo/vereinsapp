<div class="modal fade" id="login_erlaubt" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="login_erlaubt_label" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <?php echo form_open( site_url().'einstellungen/einstellungen_login_erlaubt' ); ?>
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title" id="login_erlaubt_label">
            <h5>Deine Aufmerksamkeit wird kurz benötigt!</h5>
            Du musst dich einmalig entscheiden, welche Möglichkeiten du für deinen Zugang zur <?php echo VEREINSAPP_NAME; ?> erlauben möchtest.
            Setze einen Haken oder entferne ihn, um eine Möglichkeit zu erlauben bzw. zu verbieten.
          </div>
        </div>
        <div class="modal-body"><?php foreach( LOGIN_ERLAUBT as $login_erlaubt => $eigenschaften ): ?>
          <h5 class="input-group flex-nowrap">
            <input class="form-check-input-lg" type="checkbox" value="<?php echo $login_erlaubt; ?>" name="login_erlaubt[]" id="<?php echo $login_erlaubt; ?>_modal"<?php
            if( ( is_null(ICH['login_erlaubt']) AND $eigenschaften['standard'] )OR in_array( $login_erlaubt, ICH['login_erlaubt'] ) ) echo ' checked'; ?> />
            <label class="form-check-label" for="<?php echo $login_erlaubt; ?>_modal"><?php echo $eigenschaften['beschriftung']; ?></label>
          </h5>
          <?php echo $eigenschaften['bemerkung']; ?>
          <hr>
          <?php endforeach; ?>
        </div>
        <div class="modal-footer">
          <input type="text" class="invisible" name="mitglied_id" value="<?php echo ICH['id']; ?>" />
          <div class="col-12 p-0 text-right"><button type="submit" class="btn btn-outline-success">Einstellung speichern</button></div>
          <div class="col-12 p-0 text-right text-secondary small">Du kannst diese Entscheidung später in den Einstellungen ändern.</div>
        </div>
      </div>
    </form>
  </div>
</div>

