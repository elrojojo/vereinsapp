<div class="col-12 mb-3">
  <?php echo form_open( site_url().'einstellungen/einstellungen_passwort_aendern' ) ; ?>
<?php if( !is_null(ICH['passwort']) ) { ?>
    <div class="form-group mb-2">
      <label class="form-text small m-0 ml-1" for="passwort">Aktuelles Passwort eingeben:</label>
      <div class="input-group">
        <input type="password" class="form-control" name="passwort" id="passwort" />
        <div class="input-group-append"><span class="input-group-text"><a class="text-primary passwort_anzeigen" data-feld="passwort"><i class="bi bi-<?php echo SYMBOLE['unsichtbar']['bootstrap']; ?>" id="passwort_anzeigen"></i></a></span></div>
      </div>
    </div>
<?php } ?>
    <div class="form-group mb-2">
      <label class="form-text small m-0 ml-1" for="passwort_neu"><?php if( is_null(ICH['passwort']) ) echo 'Neues '; ?>Passwort eingeben:</label>
      <div class="input-group">
        <input type="password" class="form-control" name="passwort_neu" id="passwort_neu" />
        <div class="input-group-append"><span class="input-group-text"><a class="text-primary passwort_anzeigen" data-feld="passwort_neu"><i class="bi bi-<?php echo SYMBOLE['unsichtbar']['bootstrap']; ?>" id="passwort_neu_anzeigen"></i></a></span></div>
      </div>
    </div>

    <div class="form-group mb-3">
      <label class="form-text small m-0 ml-1" for="passwort_neu2"><?php if( is_null(ICH['passwort']) ) echo 'Neues '; ?>Passwort erneut eingeben:</label>
      <div class="input-group">
        <input type="password" class="form-control" name="passwort_neu2" id="passwort_neu2" />
        <div class="input-group-append"><span class="input-group-text"><a class="text-primary passwort_anzeigen" data-feld="passwort_neu2"><i class="bi bi-<?php echo SYMBOLE['unsichtbar']['bootstrap']; ?>" id="passwort_neu2_anzeigen"></i></a></span></div>
      </div>
    </div>

    <button type="submit" class="btn btn-outline-success btn-block">Passwort <?php if( !is_null(ICH['passwort']) ) echo 'ändern'; else echo 'vergeben'; ?></button>
  </form>
</div>

