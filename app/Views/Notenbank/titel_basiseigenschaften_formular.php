<div class="formular"<?php if( isset($data) AND is_array($data) ) foreach( $data as $eigenschaft => $wert) { ?> data-<?= $eigenschaft ?>="<?= $wert ?>"<?php }?>>

    <div class="form-floating mb-2">
        <input type="text" class="form-control eigenschaft" data-eigenschaft="titel" placeholder="<?= EIGENSCHAFTEN['notenbank']['titel']['beschriftung']; ?>" />
        <label><?= EIGENSCHAFTEN['notenbank']['titel']['beschriftung']; ?></label>
    </div>

    <div class="form-floating mb-2">
        <input type="number" class="form-control eigenschaft" data-eigenschaft="titel_nr" placeholder="<?= EIGENSCHAFTEN['notenbank']['titel_nr']['beschriftung']; ?>" />
        <label><?= EIGENSCHAFTEN['notenbank']['titel_nr']['beschriftung']; ?></label>
    </div>

    <div class="form-floating mb-2">
        <select class="form-select eigenschaft" data-eigenschaft="kategorie">
        <?php foreach ( VORGEGEBENE_WERTE['notenbank']['kategorie'] as $kategorie => $eigenschaften ): ?>
            <option value="<?= $kategorie; ?>"><?= $eigenschaften['beschriftung']; ?></option>
        <?php endforeach; ?>
        </select>
        <label><?= EIGENSCHAFTEN['notenbank']['kategorie']['beschriftung']; ?></label>
    </div>

    <div class="d-grid"><button type="button" class="btn btn_titel_aktion btn-outline-success"><?php if( isset($btn_beschriftung) ) echo $btn_beschriftung; else echo 'Speichern'; ?></button></div>

</div>