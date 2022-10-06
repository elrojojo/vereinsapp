<div class="col-md-12">
  <div class="card">
    <h5 class="card-header text-center text-secondary">Login</h5>
    <div class="card-body">
      <div class="collapse<?php if( isset($login['aktion']) AND $login['aktion'] == 'login' ) echo ' show'; ?>" id="login">
        Um die <?php echo VEREINSAPP_NAME; ?> nutzen zu können musst du dich mit deiner Email und einem gültigen Passwort einloggen:
        <?php echo form_open( site_url().'login' ); ?>
          <div class="input-group mt-2">
            <div class="input-group-prepend"><span class="input-group-text">Email:</span></div>
            <input type="email" class="form-control" name="email" id="email_login" <?php if( isset($login['email']) ) echo ' value="'.$login['email'].'"'; ?> onChange="document.getElementById('email_passwort_vergessen').value = this.value; document.getElementById('email_einmal_link_erzeugen').value = this.value;" />
          </div>
          <div class="input-group mt-2">
            <div class="input-group-prepend"><span class="input-group-text">Passwort:</span></div>
            <input type="password" class="form-control" name="passwort" id="passwort" />
            <div class="input-group-append"><span class="input-group-text"><a class="text-primary passwort_anzeigen" data-feld="passwort"><i class="bi bi-<?php echo SYMBOLE['unsichtbar']['bootstrap']; ?>" id="passwort_anzeigen"></i></a></span></div>
          </div>
          <div class="input-group mt-3">
            <input class="form-check-input-lg" type="checkbox" value="angemeldet_bleiben" name="angemeldet_bleiben" id="angemeldet_bleiben" checked />
            <label class="form-check-label" for="angemeldet_bleiben">Angemeldet bleiben</label>
          </div>
          <input type="text" class="invisible" name="aktion" value="login" />
          <button type="submit" class="btn btn-outline-success btn-block mt-2">Einloggen</button>
        </form>
        <hr>
        <button type="button" class="btn btn-outline-primary btn-block btn-sm mt-2" data-toggle="collapse" href="#passwort_vergessen" aria-expanded="false" aria-controls="passwort_vergessen">Passwort vergessen?</button>
        <hr>
        <button type="button" class="btn btn-outline-primary btn-block btn-sm mt-2" data-toggle="collapse" href="#einmal_link_erzeugen" aria-expanded="false" aria-controls="einmal_link_erzeugen">Einmal-Link erzeugen?</button>
      </div>

      <div class="collapse<?php if( isset($login['aktion']) AND $login['aktion'] == 'passwort_vergessen' ) echo ' show'; ?>" id="passwort_vergessen">
        Um ein neues Passwort vergeben zu können musst du deine Email angeben:
        <?php echo form_open( site_url().'login' ); ?>
          <div class="input-group mt-2">
            <div class="input-group-prepend"><span class="input-group-text">Email:</span></div>
            <input type="email" class="form-control" name="email" id="email_passwort_vergessen" <?php if( isset($login['email']) ) echo ' value="'.$login['email'].'"'; ?> onChange="document.getElementById('email_login').value = this.value; document.getElementById('email_einmal_link_erzeugen').value = this.value;" />
          </div>
          <input type="text" class="invisible" name="aktion" value="passwort_vergessen" />
          <button type="submit" class="btn btn-outline-danger btn-block mt-3">Neues Passwort vergeben</button>
        </form>
        <hr>
        <button type="button" class="btn btn-outline-primary btn-block btn-sm mt-2" data-toggle="collapse" href="#login" aria-expanded="false" aria-controls="login">Zurück zum Login</button>
      </div>

      <div class="collapse<?php if( isset($login['aktion']) AND $login['aktion'] == 'einmal_link_erzeugen' ) echo ' show'; ?>" id="einmal_link_erzeugen">
        Um einen Einmal-Link erzeugen zu können musst du deine Email angeben:
        <?php echo form_open( site_url().'login' ); ?>
          <div class="input-group mt-2">
            <div class="input-group-prepend"><span class="input-group-text">Email:</span></div>
            <input type="email" class="form-control" name="email" id="email_einmal_link_erzeugen" <?php if( isset($login['email']) ) echo ' value="'.$login['email'].'"'; ?> onChange="document.getElementById('email_login').value = this.value; document.getElementById('email_passwort_vergessen').value = this.value;" />
          </div>
          <input type="text" class="invisible" name="aktion" value="einmal_link_erzeugen" />
          <button type="submit" class="btn btn-outline-danger btn-block mt-3">Einmal-Link erzeugen</button>
        </form>
        <hr>
        <button type="button" class="btn btn-outline-primary btn-block btn-sm mt-2" data-toggle="collapse" href="#login" aria-expanded="false" aria-controls="login">Zurück zum Login</button>
      </div>

    </div>
  </div>
</div>
<script type='text/javascript'>
  
  $('#login').on('show.bs.collapse', function () {
    $('#passwort_vergessen').collapse('hide');
    $('#einmal_link_erzeugen').collapse('hide');
  } );

  $('#passwort_vergessen').on('show.bs.collapse', function () {
    $('#login').collapse('hide');
    $('#einmal_link_erzeugen').collapse('hide');
  } );

  $('#einmal_link_erzeugen').on('show.bs.collapse', function () {
    $('#login').collapse('hide');
    $('#passwort_vergessen').collapse('hide');
  } );

</script>

