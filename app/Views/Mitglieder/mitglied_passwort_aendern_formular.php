<div class="formular"<?php if( isset($data) AND is_array($data) ) foreach( $data as $eigenschaft => $wert) { ?> data-<?= $eigenschaft ?>="<?= $wert ?>"<?php }?>>

    <div class="input-group mb-2">
        <div class="form-floating">
            <input type="password" class="form-control eigenschaft" data-eigenschaft="passwort_alt" placeholder="Altes Passwort" />
            <label>Altes Passwort</label>
        </div>
        <span class="input-group-text text-primary btn_passwort_anzeigen" role="button"><i class="bi bi-<?= SYMBOLE['unsichtbar']['bootstrap']; ?>"></i></span>
    </div>

    <div class="input-group mb-2">
        <div class="form-floating">
            <input type="password" class="form-control eigenschaft" data-eigenschaft="passwort_neu" placeholder="Neues Passwort" />
            <label>Neues Passwort</label>
        </div>
        <span class="input-group-text text-primary btn_passwort_anzeigen" role="button"><i class="bi bi-<?= SYMBOLE['unsichtbar']['bootstrap']; ?>"></i></span>
    </div>

    <div class="input-group mb-2">
        <div class="form-floating">
            <input type="password" class="form-control eigenschaft" data-eigenschaft="passwort_neu2" placeholder="Neues Passwort (Wiederholung)" />
            <label>Neues Passwort (Wiederholung)</label>
        </div>
        <span class="input-group-text text-primary btn_passwort_anzeigen" role="button"><i class="bi bi-<?= SYMBOLE['unsichtbar']['bootstrap']; ?>"></i></span>
    </div>

    <div class="d-grid"><button type="button" class="btn btn_mitglied_passwort_aendern btn-outline-success"><?php if( isset($btn_beschriftung) ) echo $btn_beschriftung; else echo 'Speichern'; ?></button></div>

</div>