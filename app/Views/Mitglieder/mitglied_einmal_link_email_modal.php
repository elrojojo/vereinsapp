<div class="modal fade formular" id="mitglied_einmal_link_email_modal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title h5"></div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Willst du <span class="beschriftung"></span> wirklich einen Einmal-Link per Email zuschicken?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Abbrechen</button>
        <button type="button" class="btn btn_erfolgreich_abschliessen btn-outline-success" data-werte='<?= json_encode( array( 'email' => TRUE ), JSON_UNESCAPED_UNICODE ); ?>'>Einmal-Link zuschicken</button>
      </div>
    </div>
  </div>
</div>

