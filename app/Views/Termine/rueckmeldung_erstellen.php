<div class="formular row g-0 stretched-link-unwirksam">
        <div class="col-6 btn-group" role="group">
                <button type="button" class="btn_rueckmeldung_detaillieren btn btn-outline-success btn-sm w-25 rounded-end rounded-pill invisible" data-element="rueckmeldung" data-aktion="aendern" data-bs-toggle="modal" data-bs-target="#rueckmeldung_detaillieren_Modal"><i class="bi bi-<?= SYMBOLE['bemerkung']['bootstrap']; ?>"></i></button>
                <button type="button" class="btn_element_erstellen zusagen btn btn-outline-success btn-sm w-100 rounded-end rounded-pill" data-element="rueckmeldung" data-aktion="erstellen" data-werte='<?= json_encode( array( 'mitglied_id' => ICH['id'], 'status' => 1, 'bemerkung' => '' ), JSON_UNESCAPED_UNICODE ); ?>'>ZUSAGEN</button>
        </div>
        <div class="col-6 btn-group" role="group">
                <button type="button" class="btn_element_erstellen absagen btn btn-outline-danger btn-sm w-100 rounded-start rounded-pill" data-element="rueckmeldung" data-aktion="erstellen" data-werte='<?= json_encode( array( 'mitglied_id' => ICH['id'], 'status' => 0, 'bemerkung' => '' ), JSON_UNESCAPED_UNICODE ); ?>'>ABSAGEN</button>
                <button type="button" class="btn_rueckmeldung_detaillieren btn btn-outline-danger btn-sm w-25 rounded-start rounded-pill invisible" data-element="rueckmeldung" data-aktion="aendern" data-bs-toggle="modal" data-bs-target="#rueckmeldung_detaillieren_Modal"><i class="bi bi-<?= SYMBOLE['bemerkung']['bootstrap']; ?>"></i></button>
        </div>
</div>

