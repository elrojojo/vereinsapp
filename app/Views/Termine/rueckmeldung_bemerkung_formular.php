<div class="formular" data-liste="rueckmeldungen"<?php if( isset($data) AND is_array($data) ) foreach( $data as $eigenschaft => $wert) { ?> data-<?= $eigenschaft ?>="<?= $wert ?>"<?php }?>>

    <div class="form-floating mb-2">
        <input type="text" class="form-control eigenschaft" data-eigenschaft="bemerkung" placeholder="<?= EIGENSCHAFTEN['rueckmeldungen']['bemerkung']['beschriftung']; ?>" />
        <label><?= EIGENSCHAFTEN['rueckmeldungen']['bemerkung']['beschriftung']; ?></label>
    </div>

    <div class="d-grid"><button type="button" class="btn btn_rueckmeldung_detaillieren btn-outline-success"><?php if( isset($btn_beschriftung) ) echo $btn_beschriftung; else echo 'Speichern'; ?></button></div>

</div>