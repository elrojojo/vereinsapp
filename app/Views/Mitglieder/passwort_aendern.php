<div class="formular mt-1 d-grid">

<div class="input-group mb-1">
    <div class="form-floating">
      <input type="password" class="form-control eigenschaft" data-eigenschaft="passwort_alt" placeholder="Altes Passwort" />
      <label>Altes Passwort</label>
    </div>
    <span class="input-group-text text-primary passwort_anzeigen" role="button"><i class="bi bi-<?= SYMBOLE['unsichtbar']['bootstrap']; ?>"></i></span>
  </div>

  <div class="input-group mb-1">
    <div class="form-floating">
      <input type="password" class="form-control eigenschaft" data-eigenschaft="passwort_neu" placeholder="Neues Passwort" />
      <label>Neues Passwort</label>
    </div>
    <span class="input-group-text text-primary passwort_anzeigen" role="button"><i class="bi bi-<?= SYMBOLE['unsichtbar']['bootstrap']; ?>"></i></span>
  </div>

  <div class="input-group mb-1">
    <div class="form-floating">
      <input type="password" class="form-control eigenschaft" data-eigenschaft="passwort_neu2" placeholder="Neues Passwort (Wiederholung)" />
      <label>Neues Passwort (Wiederholung)</label>
    </div>
    <span class="input-group-text text-primary passwort_anzeigen" role="button"><i class="bi bi-<?= SYMBOLE['unsichtbar']['bootstrap']; ?>"></i></span>
  </div>
  
  <button type="button" class="btn_element_erstellen btn btn-outline-success" data-liste="mitglieder" data-aktion="passwort_aendern" data-element_id="<?= ICH['id']; ?>"><i class="bi bi-<?= SYMBOLE['mitglied']['bootstrap']; ?>"></i> Mein Passwort ändern</button>

</div>

