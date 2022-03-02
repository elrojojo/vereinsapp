<div class="col-md-12">
  <div class="card">
    <h5 class="card-header text-center text-secondary">Neues Passwort vergeben</h5>
    <div class="card-body">

      <?php echo form_open( site_url().'login/passwort_vergeben/'.$mitglied_id.'/'.$schluessel ) ; ?>
        Du hast nun die Möglichkeit ein neues Passwort zu vergeben:
        <div class="input-group mt-2">
          <div class="input-group-prepend"><span class="input-group-text">Passwort:</span></div>
          <input type="password" class="form-control" name="passwort_neu" id="passwort_neu" />
          <div class="input-group-append"><span class="input-group-text"><a class="text-primary passwort_anzeigen" data-feld="passwort_neu"><i class="bi bi-<?php echo SYMBOLE['unsichtbar']['bootstrap']; ?>" id="passwort_neu_anzeigen"></i></a></span></div>
        </div>
        <div class="input-group mt-2">
          <div class="input-group-prepend"><span class="input-group-text">Wiederh.:</span></div>
          <input type="password" class="form-control" name="passwort_neu2" id="passwort_neu2" />
          <div class="input-group-append"><span class="input-group-text"><a class="text-primary passwort_anzeigen" data-feld="passwort_neu2"><i class="bi bi-<?php echo SYMBOLE['unsichtbar']['bootstrap']; ?>" id="passwort_neu2_anzeigen"></i></a></span></div>
        </div>
        <button type="submit" class="btn btn-outline-success btn-block mt-2">Neues Passwort vergeben</button>
      </form>

    </div>
  </div>
</div>
<script>

$(document).ready(function() {

  $(".passwort_anzeigen").on('click', function(event) {
    event.preventDefault();
    var feld = $(this).data('feld');

    if($('#'+feld).attr("type") == "text"){
      $('#'+feld).attr('type', 'password');
      $('#'+feld+'_anzeigen').addClass( "bi-<?php echo SYMBOLE['unsichtbar']['bootstrap']; ?>" );
      $('#'+feld+'_anzeigen').removeClass( "bi-<?php echo SYMBOLE['sichtbar']['bootstrap']; ?>" );
    }
    else if($('#'+feld).attr("type") == "password"){
      $('#'+feld).attr('type', 'text');
      $('#'+feld+'_anzeigen').addClass( "bi-<?php echo SYMBOLE['sichtbar']['bootstrap']; ?>" );
      $('#'+feld+'_anzeigen').removeClass( "bi-<?php echo SYMBOLE['unsichtbar']['bootstrap']; ?>" );
    }
  });
  
});

</script>
