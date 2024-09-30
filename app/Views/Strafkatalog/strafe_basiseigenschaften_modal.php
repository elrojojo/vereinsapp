<div class="blanko invisible fade" id="basiseigenschaften" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title h5"></div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

      <div class="form-floating mb-2">
        <input type="text" class="form-control eigenschaft" data-eigenschaft="titel" placeholder="<?= EIGENSCHAFTEN['strafkatalog']['titel']['beschriftung']; ?>" />
        <label><?= EIGENSCHAFTEN['strafkatalog']['titel']['beschriftung']; ?></label>
      </div>

      <div class="col-4 form-floating mb-2">
        <input type="number" step="0.01" class="form-control eigenschaft" data-eigenschaft="wert" placeholder="<?= EIGENSCHAFTEN['strafkatalog']['wert']['beschriftung']; ?>" min="0.00" />
        <label><?= EIGENSCHAFTEN['strafkatalog']['wert']['beschriftung']; ?></label>
      </div>

      <div class="form-floating mb-2">
        <select class="form-select eigenschaft" data-eigenschaft="kategorie">
        <?php foreach ( VORGEGEBENE_WERTE['strafkatalog']['kategorie'] as $kategorie => $eigenschaften ): ?>
          <option value="<?= $kategorie; ?>"><?= $eigenschaften['beschriftung']; ?></option>
        <?php endforeach; ?>
        </select>
        <label><?= EIGENSCHAFTEN['strafkatalog']['kategorie']['beschriftung']; ?></label>
      </div>

      <div class="form-floating mb-2">
        <input type="text" class="form-control eigenschaft" data-eigenschaft="bemerkung" placeholder="<?= EIGENSCHAFTEN['notenbank']['bemerkung']['beschriftung']; ?>" />
        <label><?= EIGENSCHAFTEN['notenbank']['bemerkung']['beschriftung']; ?></label>
      </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Abbrechen</button>
        <button type="button" class="btn btn_strafe_aktion btn-outline-success">Speichern</button>
      </div>
    </div>
  </div>
</div>

