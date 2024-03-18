<div class="modal fade formular" id="rueckmeldung_detaillieren_modal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title h5"></div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

        <div class="form-floating mb-2">
          <input type="text" class="form-control eigenschaft" data-eigenschaft="bemerkung" placeholder="<?= EIGENSCHAFTEN['rueckmeldungen']['bemerkung']['beschriftung']; ?>" />
          <label><?= EIGENSCHAFTEN['rueckmeldungen']['bemerkung']['beschriftung']; ?></label>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Abbrechen</button>
        <button type="button" class="btn_erfolgreich_abschliessen btn btn-outline-success">Speichern</button>
      </div>
    </div>
  </div>
</div>

