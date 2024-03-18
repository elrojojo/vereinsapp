<div class="formular invisible row g-0 stretched-link-unwirksam" data-formular="rueckmeldung">
        <div class="col-6 btn-group" role="group">
                <button type="button" class="btn_rueckmeldung_detaillieren btn btn-outline-success btn-sm w-25 rounded-end rounded-pill invisible" data-liste="rueckmeldungen" data-aktion="aendern" data-bs-toggle="modal" data-bs-target="#rueckmeldung_detaillieren_modal" data-title="Bemerkung machen"><i class="bi bi-<?= SYMBOLE['bemerkung']['bootstrap']; ?>"></i></button>
                <button type="button" class="btn_erfolgreich_abschliessen zusagen btn btn-outline-success btn-sm w-100 rounded-end rounded-pill" data-liste="rueckmeldungen" data-aktion="erstellen" data-werte='<?= json_encode( array( 'mitglied_id' => $mitglied_id ), JSON_UNESCAPED_UNICODE ); ?>'>ZUSAGEN</button>
        </div>
        <div class="col-6 btn-group" role="group">
                <button type="button" class="btn_erfolgreich_abschliessen absagen btn btn-outline-danger btn-sm w-100 rounded-start rounded-pill" data-liste="rueckmeldungen" data-aktion="erstellen" data-werte='<?= json_encode( array( 'mitglied_id' => $mitglied_id ), JSON_UNESCAPED_UNICODE ); ?>'>ABSAGEN</button>
                <button type="button" class="btn_rueckmeldung_detaillieren btn btn-outline-danger btn-sm w-25 rounded-start rounded-pill invisible" data-liste="rueckmeldungen" data-aktion="aendern" data-bs-toggle="modal" data-bs-target="#rueckmeldung_detaillieren_modal" data-title="Bemerkung machen"><i class="bi bi-<?= SYMBOLE['bemerkung']['bootstrap']; ?>"></i></button>
        </div>
</div>
<div class="formular_meine_rueckmeldung_nicht_eingeladen invisible text-secondary small">Du bist nicht eingeladen und kannst deshalb keine Rückmeldung geben.</div>

