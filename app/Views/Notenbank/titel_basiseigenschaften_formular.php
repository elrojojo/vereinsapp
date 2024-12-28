<div class="form-floating mb-2">
    <input type="text" class="form-control eingabe" data-eingabe="titel" placeholder="<?= EIGENSCHAFTEN['notenbank']['titel']['beschriftung']; ?>" />
    <label><?= EIGENSCHAFTEN['notenbank']['titel']['beschriftung']; ?></label>
</div>

<div class="form-floating mb-2">
    <input type="number" class="form-control eingabe" data-eingabe="titel_nr" placeholder="<?= EIGENSCHAFTEN['notenbank']['titel_nr']['beschriftung']; ?>" />
    <label><?= EIGENSCHAFTEN['notenbank']['titel_nr']['beschriftung']; ?></label>
</div>

<div class="form-floating mb-2">
    <select class="form-select eingabe" data-eingabe="kategorie">
    <?php foreach ( VORGEGEBENE_WERTE['notenbank']['kategorie'] as $kategorie => $eigenschaften ): ?>
        <option value="<?= $kategorie; ?>"><?= $eigenschaften['beschriftung']; ?></option>
    <?php endforeach; ?>
    </select>
    <label><?= EIGENSCHAFTEN['notenbank']['kategorie']['beschriftung']; ?></label>
</div>