<?php echo form_open( site_url().'einstellungen/einstellungen_passwort_aendern' ); ?>
  <div class="modal fade" id="passwort_vergeben" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="passwort_vergeben_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title" id="passwort_vergeben_label">
            <h5>Deine Aufmerksamkeit wird kurz benötigt!</h5>
            Du hast für deinen Zugang zur <?php echo VEREINSAPP_NAME; ?> den Zugang mit Email & Passwort erlaubt, aber du hast noch kein Passwort vergeben.
            Du hast nun die Möglichkeit ein Passwort zu vergeben oder die Passwort-Vergabe um 24 Stunden zu verschieben.
          </div>
        </div>
        <div class="modal-body">
          <div class="form-group mb-2">
            <label class="form-text small m-0 ml-1" for="passwort_neu"><?php if( is_null(ICH['passwort']) ) echo 'Neues '; ?>Passwort eingeben:</label>
            <div class="input-group">
              <input type="password" class="form-control" name="passwort_neu" id="passwort_neu" />
              <div class="input-group-append"><span class="input-group-text"><a class="text-primary passwort_anzeigen" data-feld="passwort_neu"><i class="bi bi-<?php echo SYMBOLE['unsichtbar']['bootstrap']; ?>" id="passwort_neu_anzeigen"></i></a></span></div>
            </div>
          </div>
          <div class="form-text form-group mb-3">
            <label class="small m-0 ml-1" for="passwort_neu2"><?php if( is_null(ICH['passwort']) ) echo 'Neues '; ?>Passwort erneut eingeben:</label>
            <div class="input-group">
              <input type="password" class="form-control" name="passwort_neu2" id="passwort_neu2" />
              <div class="input-group-append"><span class="input-group-text"><a class="text-primary passwort_anzeigen" data-feld="passwort_neu2"><i class="bi bi-<?php echo SYMBOLE['unsichtbar']['bootstrap']; ?>" id="passwort_neu2_anzeigen"></i></a></span></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="col-12 p-0 text-right">
            <button type="button" class="btn btn-outline-danger" onClick="document.cookie='vereinsapp_passwort_vergeben=<?php echo time(); ?>; expires=<?php echo 60*60*24; ?>; path=/'; $('#passwort_vergeben').modal('hide');">Verschieben</button>
            <button type="submit" class="btn btn-outline-success">Passwort vergeben</button>
          </div>
          <div class="col-12 p-0 text-right text-secondary small">Du kannst dein Passwort später in den Einstellungen ändern.</div>
        </div>
      </div>
    </div>
  </div>
</form>

