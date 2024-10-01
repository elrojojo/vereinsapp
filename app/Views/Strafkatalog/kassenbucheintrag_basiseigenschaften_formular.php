<div class="formular"<?php if( isset($data) AND is_array($data) ) foreach( $data as $eigenschaft => $wert) { ?> data-<?= $eigenschaft ?>="<?= $wert ?>"<?php }?>>

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

    <div class="d-grid"><button type="button" class="btn btn_kassenbucheintrag_aktion btn-outline-success"><?php if( isset($btn_beschriftung) ) echo $btn_beschriftung; else echo 'Speichern'; ?></button></div>

</div>