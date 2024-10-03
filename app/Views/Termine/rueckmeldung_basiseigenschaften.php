<div class="rueckmeldung_eingeladen row g-0 stretched-link-unwirksam invisible">
    <div class="formular col-6 btn-group" role="group">
        <button type="button" class="btn_rueckmeldung_detaillieren formular_oeffnen btn btn-outline-success btn-sm w-25 rounded-end rounded-pill invisible" data-liste="rueckmeldungen" data-title="Bemerkung machen"><i class="bi bi-<?= SYMBOLE['bemerkung']['bootstrap']; ?>"></i></button>
        <button type="button" class="btn zusagen btn-outline-success btn-sm w-100 rounded-end rounded-pill" data-werte='<?= json_encode( array( 'mitglied_id' => $mitglied_id ), JSON_UNESCAPED_UNICODE ); ?>'>ZUSAGEN</button>
    </div>
    <div class="formular col-6 btn-group" role="group">
        <button type="button" class="btn absagen btn-outline-danger btn-sm w-100 rounded-start rounded-pill" data-werte='<?= json_encode( array( 'mitglied_id' => $mitglied_id ), JSON_UNESCAPED_UNICODE ); ?>'>ABSAGEN</button>
        <button type="button" class="btn_rueckmeldung_detaillieren formular_oeffnen btn btn-outline-danger btn-sm w-25 rounded-start rounded-pill invisible" data-liste="rueckmeldungen" data-title="Bemerkung machen"><i class="bi bi-<?= SYMBOLE['bemerkung']['bootstrap']; ?>"></i></button>
    </div>
</div>
<div class="rueckmeldung_nicht_eingeladen invisible text-secondary text-center small">Du bist nicht eingeladen und kannst deshalb keine Rückmeldung geben.</div>

<div class="blanko_modals" data-liste="rueckmeldungen">
<?= view( 'Templates/modal', array( 'modal_id' => 'bemerkung', 'modal' =>
    view( 'Templates/formular', array( 'data' => array( 'liste' => 'rueckmeldungen' ), 'btn' => array( 'klasse_id' => 'btn_rueckmeldung_detaillieren' ), 'formular' =>
    view( 'Termine/rueckmeldung_bemerkung_formular' ) ) ) ) ); ?>
</div>