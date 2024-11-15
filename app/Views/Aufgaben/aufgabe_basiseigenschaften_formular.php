<div class="form-floating mb-2">
    <input type="text" class="form-control eigenschaft" data-eigenschaft="titel" placeholder="<?= EIGENSCHAFTEN['aufgaben']['titel']['beschriftung']; ?>" />
    <label><?= EIGENSCHAFTEN['aufgaben']['titel']['beschriftung']; ?></label>
</div>

<div class="form-floating mb-2">
    <input type="text" class="form-control eigenschaft" data-eigenschaft="bemerkung" placeholder="<?= EIGENSCHAFTEN['aufgaben']['bemerkung']['beschriftung']; ?>" />
    <label><?= EIGENSCHAFTEN['aufgaben']['bemerkung']['beschriftung']; ?></label>
</div>

<div class="input-group mb-2">
    <div class="form-floating">
        <select class="form-select eigenschaft" data-eigenschaft="zugeordnete_liste">
        <?php foreach ( VORGEGEBENE_WERTE['aufgaben']['zugeordnete_liste'] as $zugeordnete_liste => $eigenschaften ): ?>
            <option value="<?= $zugeordnete_liste; ?>"><?= $eigenschaften['beschriftung']; ?></option>
        <?php endforeach; ?>
        </select>
        <label><?= EIGENSCHAFTEN['aufgaben']['zugeordnete_liste']['beschriftung']; ?></label>
    </div>
    <button type="button" class="btn btn_aufgabe_element_zuordnen auswahl_einfordern btn-outline-primary eigenschaft verlinkte_eigenschaft disabled" data-eigenschaft="zugeordnete_element_id" data-verlinkte_eigenschaft="zugeordnete_liste" data-title="auswählen"><i class="bi bi-<?= SYMBOLE['auswaehlen']['bootstrap'] ?>"></i></button>
</div>

<div class="input-group mb-2">
  <input type="text" class="form-control" placeholder="<?= EIGENSCHAFTEN['aufgaben']['zugeordnetes_element']['beschriftung']; ?>" readonly>
</div>