<div class="btn-group sichtbar formular stretched-link-unwirksam" role="group">
    <button type="button" class="btn btn_rueckmeldung_machen btn-outline-primary btn-sm" data-werte='<?= json_encode( array( 'mitglied_id' => $mitglied_id ), JSON_UNESCAPED_UNICODE ); ?>'>ZUSAGEN</button>
</div>
<div class="unsichtbar invisible">
    <button type="button" class="btn btn_rueckmeldung_detaillieren formular_oeffnen btn-outline-primary btn-sm" data-liste="rueckmeldungen" data-title="Bemerkung machen"><i class="bi bi-<?= SYMBOLE['bemerkung']['bootstrap']; ?>"></i></button>
</div>

<?= view( 'Templates/modal', array( 'id' => 'rueckmeldungen_bemerkung', 'modal' =>
    view( 'Templates/Liste/formular', array( 'data' => array( 'liste' => 'rueckmeldungen' ), 'btn' => array( 'klasse_id' => 'btn_rueckmeldung_detaillieren' ), 'formular' =>
    view( 'Umfragen/rueckmeldung_bemerkung_formular' ) ) ) ) ); ?>