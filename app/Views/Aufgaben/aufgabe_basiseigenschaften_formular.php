<div class="form-floating mb-2">
    <input type="text" class="form-control eingabe" data-eingabe="titel" placeholder="<?= EIGENSCHAFTEN['aufgaben']['titel']['beschriftung']; ?>" />
    <label><?= EIGENSCHAFTEN['aufgaben']['titel']['beschriftung']; ?></label>
</div>

<div class="form-floating mb-2">
    <input type="text" class="form-control eingabe" data-eingabe="bemerkung" placeholder="<?= EIGENSCHAFTEN['aufgaben']['bemerkung']['beschriftung']; ?>" />
    <label><?= EIGENSCHAFTEN['aufgaben']['bemerkung']['beschriftung']; ?></label>
</div>

<div class="input-group mb-2">
    <div class="form-floating">
        <select class="form-select eingabe" data-eingabe="zugeordnete_liste">
        <?php foreach ( VORGEGEBENE_WERTE['aufgaben']['zugeordnete_liste'] as $zugeordnete_liste => $eigenschaften ): ?>
            <option value="<?= $zugeordnete_liste; ?>"><?= $eigenschaften['beschriftung']; ?></option>
        <?php endforeach; ?>
        </select>
        <label><?= EIGENSCHAFTEN['aufgaben']['zugeordnete_liste']['beschriftung']; ?></label>
    </div>
    <button type="button" class="btn btn_element_zuordnen auswahl_einfordern btn-outline-primary eingabe disabled" data-eingabe="zugeordnete_element_id" data-title="auswählen"><i class="bi bi-<?= SYMBOLE['auswaehlen']['bootstrap'] ?>"></i></button>
    <button type="button" class="btn btn_zugeordnetes_element_loeschen btn-outline-danger disabled"><i class="bi bi-<?= SYMBOLE['loeschen']['bootstrap'] ?>"></i></button>
</div>

<div class="mb-2">
<?= view( 'Templates/Liste/liste', array( 'liste' => array( 'id' => 'zugeordnetes_element' ) ) ); ?>
</div>