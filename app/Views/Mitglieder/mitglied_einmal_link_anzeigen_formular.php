<div class="formular"<?php if( isset($data) AND is_array($data) ) foreach( $data as $eigenschaft => $wert) { ?> data-<?= $eigenschaft ?>="<?= $wert ?>"<?php }?>>

    <div class="mb-2">Willst du für <span class="beschriftung"></span> wirklich einen Einmal-Link erstellen und anzeigen?</div>
    <div class="input-group mb-2">
        <div class="form-floating">
            <input type="text" class="form-control einmal_link" readonly />
            <label>Einmal-Link</label>
        </div>
        <span class="input-group-text text-primary btn_inhalt_kopieren" data-clipboard-target=".einmal_link" role="button"><i class="bi bi-<?= SYMBOLE['duplizieren']['bootstrap']; ?>"></i></span>
    </div>

    <div class="d-grid"><button type="button" class="btn btn_mitglied_einmal_link_anzeigen btn-outline-success"><?php if( isset($btn_beschriftung) ) echo $btn_beschriftung; else echo 'Speichern'; ?></button></div>
    <div class="d-grid"><button type="button" class="btn btn-outline-primary invisible" data-bs-dismiss="modal">Schließen</button></div>

</div>