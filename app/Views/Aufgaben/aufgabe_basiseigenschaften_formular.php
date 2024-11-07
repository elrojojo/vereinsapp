<div class="form-floating mb-2">
    <input type="text" class="form-control eigenschaft" data-eigenschaft="titel" placeholder="<?= EIGENSCHAFTEN['aufgaben']['titel']['beschriftung']; ?>" />
    <label><?= EIGENSCHAFTEN['aufgaben']['titel']['beschriftung']; ?></label>
</div>

<div class="form-floating mb-2">
    <input type="text" class="form-control eigenschaft" data-eigenschaft="bemerkung" placeholder="<?= EIGENSCHAFTEN['aufgaben']['bemerkung']['beschriftung']; ?>" />
    <label><?= EIGENSCHAFTEN['aufgaben']['bemerkung']['beschriftung']; ?></label>
</div>

<div class="form-floating mb-2">
    <select class="form-select eigenschaft" data-eigenschaft="liste">
    <?php foreach ( VORGEGEBENE_WERTE['aufgaben']['liste'] as $liste => $eigenschaften ): ?>
        <option value="<?= $liste; ?>"><?= $eigenschaften['beschriftung']; ?></option>
    <?php endforeach; ?>
    </select>
    <label><?= EIGENSCHAFTEN['aufgaben']['liste']['beschriftung']; ?></label>
</div>