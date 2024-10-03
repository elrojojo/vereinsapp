<div class="form-floating mb-2">
    <input type="text" class="form-control eigenschaft" data-eigenschaft="titel" placeholder="<?= EIGENSCHAFTEN['kassenbuch']['titel']['beschriftung']; ?>" />
    <label><?= EIGENSCHAFTEN['kassenbuch']['titel']['beschriftung']; ?></label>
</div>

<div class="form-floating mb-2">
    <input type="number" step="0.01" class="form-control eigenschaft" data-eigenschaft="wert" placeholder="<?= EIGENSCHAFTEN['kassenbuch']['wert']['beschriftung']; ?>" min="0.00" />
    <label><?= EIGENSCHAFTEN['kassenbuch']['wert']['beschriftung']; ?></label>
</div>

<div class="form-floating mb-2">
    <input type="text" class="form-control eigenschaft" data-eigenschaft="bemerkung" placeholder="<?= EIGENSCHAFTEN['kassenbuch']['bemerkung']['beschriftung']; ?>" />
    <label><?= EIGENSCHAFTEN['kassenbuch']['bemerkung']['beschriftung']; ?></label>
</div>