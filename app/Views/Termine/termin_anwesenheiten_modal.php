<div class="modal fade formular" id="termin_anwesenheiten_Modal" tabindex="-1" aria-labelledby="termin_anwesenheiten_Modal_Label" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title h5" id="termin_anwesenheiten_Modal_Label"></div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <?= view( 'Templates/Liste/checkliste', array( 'liste' => $liste, 'checkliste' => $checkliste ) ); ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Schließen</button>
      </div>
    </div>
  </div>
</div>

