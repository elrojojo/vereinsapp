<div class="modal fade formular" id="titel_erstellen_Modal" tabindex="-1" aria-labelledby="titel_erstellen_Modal_Label" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title h5" id="titel_erstellen_Modal_Label"></div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

      <?php if( array_key_exists( 'kategorie', EIGENSCHAFTEN['notenbank'] ) ) { ?><div class="form-floating mb-2">
        <select class="form-select eigenschaft" data-eigenschaft="kategorie">
        <?php foreach ( VORGEGEBENE_WERTE['notenbank']['kategorie'] as $kategorie => $eigenschaften ): ?>
          <option value="<?= $kategorie; ?>"><?= $eigenschaften['beschriftung']; ?></option>
        <?php endforeach; ?>
        </select>
        <label><?= EIGENSCHAFTEN['notenbank']['kategorie']['beschriftung']; ?></label>
      </div><?php } ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Abbrechen</button>
        <button type="button" class="btn_element_erstellen btn btn-outline-success">Speichern</button>
      </div>
    </div>
  </div>
</div>

