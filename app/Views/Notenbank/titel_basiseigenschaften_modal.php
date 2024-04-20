<div class="blanko invisible fade" id="basiseigenschaften" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title h5"></div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

      <div class="form-floating mb-2">
        <input type="text" class="form-control eigenschaft" data-eigenschaft="titel" placeholder="<?= EIGENSCHAFTEN['notenbank']['titel']['beschriftung']; ?>" />
        <label><?= EIGENSCHAFTEN['notenbank']['titel']['beschriftung']; ?></label>
      </div>

      <div class="col-4 form-floating mb-2">
        <input type="number" class="form-control eigenschaft" data-eigenschaft="titel_nr" placeholder="<?= EIGENSCHAFTEN['notenbank']['titel_nr']['beschriftung']; ?>" />
        <label><?= EIGENSCHAFTEN['notenbank']['titel_nr']['beschriftung']; ?></label>
      </div>

      <div class="form-floating mb-2">
        <select class="form-select eigenschaft" data-eigenschaft="kategorie">
        <?php foreach ( VORGEGEBENE_WERTE['notenbank']['kategorie'] as $kategorie => $eigenschaften ): ?>
          <option value="<?= $kategorie; ?>"><?= $eigenschaften['beschriftung']; ?></option>
        <?php endforeach; ?>
        </select>
        <label><?= EIGENSCHAFTEN['notenbank']['kategorie']['beschriftung']; ?></label>
      </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Abbrechen</button>
        <button type="button" class="btn_titel_aktion btn btn-outline-success">Speichern</button>
      </div>
    </div>
  </div>
</div>

