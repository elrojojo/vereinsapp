<div class="form-floating mb-2">
    <input type="text" class="form-control eigenschaft" data-eigenschaft="titel" placeholder="<?= EIGENSCHAFTEN['aufgaben']['titel']['beschriftung']; ?>" />
    <label><?= EIGENSCHAFTEN['aufgaben']['titel']['beschriftung']; ?></label>
</div>

<div class="form-floating mb-2">
    <input type="text" class="form-control eigenschaft" data-eigenschaft="bemerkung" placeholder="<?= EIGENSCHAFTEN['aufgaben']['bemerkung']['beschriftung']; ?>" />
    <label><?= EIGENSCHAFTEN['aufgaben']['bemerkung']['beschriftung']; ?></label>
</div>

<div class="form-floating mb-2">
    <select class="form-select eigenschaft" data-eigenschaft="zugeordnete_liste">
    <?php foreach ( VORGEGEBENE_WERTE['aufgaben']['zugeordnete_liste'] as $zugeordnete_liste => $eigenschaften ): ?>
        <option value="<?= $zugeordnete_liste; ?>"><?= $eigenschaften['beschriftung']; ?></option>
    <?php endforeach; ?>
    </select>
    <label><?= EIGENSCHAFTEN['aufgaben']['zugeordnete_liste']['beschriftung']; ?></label>
</div>

<div class="d-grid mb-2"><button type="button" class="btn btn_auswahl_modal_oeffnen btn-outline-primary eigenschaft verlinkte_eigenschaft disabled" data-eigenschaft="zugeordnete_element_id" data-verlinkte_eigenschaft="zugeordnete_liste" data-title="Element auswählen">Element auswählen</button></div>