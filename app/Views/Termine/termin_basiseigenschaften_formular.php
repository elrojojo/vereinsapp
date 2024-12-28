<div class="form-floating mb-2">
    <input type="text" class="form-control eingabe" data-eingabe="titel" placeholder="<?= EIGENSCHAFTEN['termine']['titel']['beschriftung']; ?>" />
    <label><?= EIGENSCHAFTEN['termine']['titel']['beschriftung']; ?></label>
</div>

<div class="form-floating mb-2">
    <input type="datetime-local" class="form-control eingabe" data-eingabe="start" />
    <label><?= EIGENSCHAFTEN['termine']['start']['beschriftung']; ?></label>
</div>

<div class="form-floating mb-2">
    <input type="text" class="form-control eingabe" data-eingabe="ort" placeholder="<?= EIGENSCHAFTEN['termine']['ort']['beschriftung']; ?>" />
    <label><?= EIGENSCHAFTEN['termine']['ort']['beschriftung']; ?></label>
</div>

<div class="form-floating mb-2">
    <input type="text" class="form-control eingabe" data-eingabe="bemerkung" placeholder="<?= EIGENSCHAFTEN['termine']['bemerkung']['beschriftung']; ?>" />
    <label><?= EIGENSCHAFTEN['termine']['bemerkung']['beschriftung']; ?></label>
</div>

<div class="form-floating mb-2">
    <select class="form-select eingabe" data-eingabe="kategorie">
    <?php foreach ( VORGEGEBENE_WERTE['termine']['kategorie'] as $kategorie => $eigenschaften ): ?>
        <option value="<?= $kategorie; ?>"><?= $eigenschaften['beschriftung']; ?></option>
    <?php endforeach; ?>
    </select>
    <label><?= EIGENSCHAFTEN['termine']['kategorie']['beschriftung']; ?></label>
</div>

<div class="d-grid mb-2">
    <button type="button" class="btn btn_filtern_modal_oeffnen btn-outline-primary eingabe" data-eingabe="filtern_mitglieder" data-liste="mitglieder" data-title="<?= EIGENSCHAFTEN['termine']['filtern_mitglieder']['beschriftung']; ?>">
        <?= EIGENSCHAFTEN['termine']['filtern_mitglieder']['beschriftung']; ?>
    </button>
</div>