<div class="modal fade formular" id="mitglied_passwort_festlegen_modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <div class="modal-title h5" data-title="Mein Passwort festlegen"></div>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">Du kannst ein neues Passwort festlegen, weil du bspw. gerade einen Einmal-Link verwendet hast.</div>

            <div class="input-group mb-1">
                <div class="form-floating">
                <input type="password" class="form-control eigenschaft" data-eigenschaft="passwort_neu" placeholder="Neues Passwort" />
                <label>Neues Passwort</label>
                </div>
                <span class="input-group-text text-primary passwort_anzeigen" role="button"><i class="bi bi-<?= SYMBOLE['unsichtbar']['bootstrap']; ?>"></i></span>
            </div>

            <div class="input-group mb-1">
                <div class="form-floating">
                <input type="password" class="form-control eigenschaft" data-eigenschaft="passwort_neu2" placeholder="Neues Passwort (Wiederholung)" />
                <label>Neues Passwort (Wiederholung)</label>
                </div>
                <span class="input-group-text text-primary passwort_anzeigen" role="button"><i class="bi bi-<?= SYMBOLE['unsichtbar']['bootstrap']; ?>"></i></span>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Abbrechen</button>
            <button type="button" class="btn btn_mitglied_passwort_festlegen btn-outline-success" data-element_id="<?= ICH['id']; ?>">Mein Passwort festlegen</button>
        </div>
        </div>
    </div>
</div>

