<div class="formular"<?php if( isset($data) AND is_array($data) ) foreach( $data as $eigenschaft => $wert) { ?> data-<?= $eigenschaft ?>="<?= $wert ?>"<?php }?>>

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

    <div class="d-grid mb-2"><button type="button" class="btn btn_filtern_formular_oeffnen btn-outline-primary eigenschaft" data-eigenschaft="filtern_mitglieder"
    data-liste="mitglieder" data-title="<?= EIGENSCHAFTEN['termine']['filtern_mitglieder']['beschriftung']; ?>">
        <i class="bi bi-<?= SYMBOLE['filtern_mitglieder']['bootstrap']; ?>"></i> <?= EIGENSCHAFTEN['termine']['filtern_mitglieder']['beschriftung']; ?>
    </button></div>

    <div class="d-grid"><button type="button" class="btn btn_termin_aktion btn-outline-success"><?php if( isset($btn_beschriftung) ) echo $btn_beschriftung; else echo 'Speichern'; ?></button></div>

</div>