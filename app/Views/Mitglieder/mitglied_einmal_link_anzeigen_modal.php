<div class="modal fade formular" id="mitglied_einmal_link_anzeigen_modal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title h5"></div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2">Willst du für <span class="beschriftung"></span> wirklich einen Einmal-Link erstellen und anzeigen?</div>
        <div class="input-group mb-1">
            <div class="form-floating">
                <input type="text" class="form-control einmal_link" readonly />
                <label>Einmal-Link</label>
            </div>
            <span class="input-group-text text-primary inhalt_kopieren" data-clipboard-target=".einmal_link" role="button"><i class="bi bi-<?= SYMBOLE['duplizieren']['bootstrap']; ?>"></i></span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Abbrechen</button>
        <button type="button" class="btn btn_erfolgreich_abschliessen btn-outline-success">Einmal-Link anzeigen</button>
      </div>
    </div>
  </div>
</div>

