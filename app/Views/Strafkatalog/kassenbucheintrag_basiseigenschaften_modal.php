<div class="blanko invisible fade" id="basiseigenschaften" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title h5"></div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

      <div class="form-floating mb-2">
        <input type="text" class="form-control eigenschaft" data-eigenschaft="titel" placeholder="<?= EIGENSCHAFTEN['kassenbuch']['titel']['beschriftung']; ?>" />
        <label><?= EIGENSCHAFTEN['kassenbuch']['titel']['beschriftung']; ?></label>
      </div>

      <div class="col-4 form-floating mb-2">
        <input type="number" step="0.01" class="form-control eigenschaft" data-eigenschaft="wert" placeholder="<?= EIGENSCHAFTEN['kassenbuch']['wert']['beschriftung']; ?>" min="0.00" />
        <label><?= EIGENSCHAFTEN['kassenbuch']['wert']['beschriftung']; ?></label>
      </div>

      <div class="form-floating mb-2">
        <input type="datetime-local" class="form-control eigenschaft" data-eigenschaft="zeitpunkt" />
        <label><?= EIGENSCHAFTEN['kassenbuch']['zeitpunkt']['beschriftung']; ?></label>
      </div>

      <div class="form-floating mb-2">
        <select class="form-select eigenschaft" data-eigenschaft="aktiv">
        <?php foreach ( VORGEGEBENE_WERTE['kassenbuch']['aktiv'] as $aktiv => $eigenschaften ): ?>
          <option value="<?= $aktiv; ?>"><?= $eigenschaften['beschriftung']; ?></option>
        <?php endforeach; ?>
        </select>
        <label><?= EIGENSCHAFTEN['kassenbuch']['aktiv']['beschriftung']; ?></label>
      </div>

      <div class="form-floating mb-2">
        <input type="text" class="form-control eigenschaft" data-eigenschaft="bemerkung" placeholder="<?= EIGENSCHAFTEN['notenbank']['bemerkung']['beschriftung']; ?>" />
        <label><?= EIGENSCHAFTEN['notenbank']['bemerkung']['beschriftung']; ?></label>
      </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Abbrechen</button>
        <button type="button" class="btn_kassenbucheintrag_aktion btn btn-outline-success">Speichern</button>
      </div>
    </div>
  </div>
</div>

