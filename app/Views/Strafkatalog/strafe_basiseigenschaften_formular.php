<div class="form-floating mb-2">
    <input type="text" class="form-control eigenschaft" data-eigenschaft="titel" placeholder="<?= EIGENSCHAFTEN['strafkatalog']['titel']['beschriftung']; ?>" />
    <label><?= EIGENSCHAFTEN['strafkatalog']['titel']['beschriftung']; ?></label>
</div>

<div class="form-floating mb-2">
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
    <input type="text" class="form-control eigenschaft" data-eigenschaft="bemerkung" placeholder="<?= EIGENSCHAFTEN['strafkatalog']['bemerkung']['beschriftung']; ?>" />
    <label><?= EIGENSCHAFTEN['strafkatalog']['bemerkung']['beschriftung']; ?></label>
</div>