<div class="modal fade formular" id="termin_basiseigenschaften_modal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
        <div class="modal-header">
            <div class="modal-title h5"></div>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">

        <div class="form-floating mb-2">
            <input type="text" class="form-control eigenschaft" data-eigenschaft="titel" placeholder="<?= EIGENSCHAFTEN['termine']['titel']['beschriftung']; ?>" />
            <label><?= EIGENSCHAFTEN['termine']['titel']['beschriftung']; ?></label>
        </div>

        <div class="form-floating mb-2">
            <input type="datetime-local" class="form-control eigenschaft" data-eigenschaft="start" />
            <label><?= EIGENSCHAFTEN['termine']['start']['beschriftung']; ?></label>
        </div>

        <div class="form-floating mb-2">
            <input type="text" class="form-control eigenschaft" data-eigenschaft="ort" placeholder="<?= EIGENSCHAFTEN['termine']['ort']['beschriftung']; ?>" />
            <label><?= EIGENSCHAFTEN['termine']['ort']['beschriftung']; ?></label>
        </div>

        <div class="form-floating mb-2">
            <input type="text" class="form-control eigenschaft" data-eigenschaft="bemerkung" placeholder="<?= EIGENSCHAFTEN['termine']['bemerkung']['beschriftung']; ?>" />
            <label><?= EIGENSCHAFTEN['termine']['bemerkung']['beschriftung']; ?></label>
        </div>

        <div class="form-floating mb-2">
            <select class="form-select eigenschaft" data-eigenschaft="kategorie">
            <?php foreach ( VORGEGEBENE_WERTE['termine']['kategorie'] as $kategorie => $eigenschaften ): ?>
            <option value="<?= $kategorie; ?>"><?= $eigenschaften['beschriftung']; ?></option>
            <?php endforeach; ?>
            </select>
            <label><?= EIGENSCHAFTEN['termine']['kategorie']['beschriftung']; ?></label>
        </div>

        <div class="d-grid"><button type="button" class="btn btn-outline-primary werkzeug eigenschaft" data-eigenschaft="filtern_mitglieder"
        data-bs-toggle="modal" data-bs-target="#liste_filtern_modal" data-title="<?= EIGENSCHAFTEN['termine']['filtern_mitglieder']['beschriftung']; ?>"
        data-aktion="filtern" data-liste="termine" data-filtern_liste="mitglieder">
            <i class="bi bi-<?= SYMBOLE['filtern_mitglieder']['bootstrap']; ?>"></i> <?= EIGENSCHAFTEN['termine']['filtern_mitglieder']['beschriftung']; ?>
        </button></div>
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Abbrechen</button>
            <button type="button" class="btn btn_termin_aktion btn-outline-success">Speichern</button>
        </div>
        </div>
    </div>
</div>

