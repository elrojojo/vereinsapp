<div class="modal fade formular" id="termin_anwesenheiten_modal" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title h5"></div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

      <?= view( 'Templates/Liste/liste', array( 'liste' => $liste['anwesenheiten_dokumentieren'] ) ); ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn_erfolgreich_abschliessen btn-outline-primary" data-bs-dismiss="modal">Schließen</button>
      </div>
    </div>
  </div>
</div>

