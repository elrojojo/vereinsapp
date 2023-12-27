<div class="modal fade formular" id="termin_erstellen_Modal" tabindex="-1" aria-labelledby="termin_erstellen_Modal_Label" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title h5" id="termin_erstellen_Modal_Label"></div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <div class="form-floating mb-2">
        <input type="text" class="form-control eigenschaft" data-eigenschaft="titel" placeholder="<?= EIGENSCHAFTEN['termine']['termine']['titel']['beschriftung']; ?>" />
        <label><?= EIGENSCHAFTEN['termine']['termine']['titel']['beschriftung']; ?></label>
      </div>

      <?php if( array_key_exists( 'organisator', EIGENSCHAFTEN['termine']['termine'] ) ) { ?><div class="form-floating mb-2">
        <input type="text" class="form-control eigenschaft" data-eigenschaft="organisator" placeholder="<?= EIGENSCHAFTEN['termine']['termine']['organisator']['beschriftung']; ?>" />
        <label><?= EIGENSCHAFTEN['termine']['termine']['organisator']['beschriftung']; ?></label>
      </div><?php } ?>

      <div class="row g-2">
        <div class="col form-floating mb-2">
          <input type="date" class="form-control eigenschaft" data-eigenschaft="start" />
          <label><?= EIGENSCHAFTEN['termine']['termine']['start']['beschriftung'].' (Datum)'; ?></label>
        </div>
        <div class="col form-floating mb-2">
        <input type="time" class="form-control eigenschaft" data-eigenschaft="start" />
          <label><?= EIGENSCHAFTEN['termine']['termine']['start']['beschriftung'].' (Zeit)'; ?></label>
        </div>
      </div>

      <div class="form-floating mb-2">
        <input type="text" class="form-control eigenschaft" data-eigenschaft="ort" placeholder="<?= EIGENSCHAFTEN['termine']['termine']['ort']['beschriftung']; ?>" />
        <label><?= EIGENSCHAFTEN['termine']['termine']['ort']['beschriftung']; ?></label>
      </div>

      <div class="form-floating mb-2">
        <input type="text" class="form-control eigenschaft" data-eigenschaft="bemerkung" placeholder="<?= EIGENSCHAFTEN['termine']['termine']['bemerkung']['beschriftung']; ?>" />
        <label><?= EIGENSCHAFTEN['termine']['termine']['bemerkung']['beschriftung']; ?></label>
      </div>

      <div class="form-floating mb-2">
        <select class="form-select eigenschaft" data-eigenschaft="kategorie">
        <?php foreach ( VORGEGEBENE_WERTE['termine']['kategorie'] as $kategorie => $eigenschaften ): ?>
          <option value="<?= $kategorie; ?>"><?= $eigenschaften['beschriftung']; ?></option>
        <?php endforeach; ?>
        </select>
        <label><?= EIGENSCHAFTEN['termine']['termine']['kategorie']['beschriftung']; ?></label>
      </div>

      <button type="button" class="btn btn-outline">Termin beschränken</button>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Abbrechen</button>
        <button type="button" class="btn_element_erstellen btn btn-outline-success">Speichern</button>
      </div>
    </div>
  </div>
</div>

