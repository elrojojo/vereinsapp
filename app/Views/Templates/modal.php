<div class="blanko invisible<?php if( isset( $modal_autoload ) AND $modal_autoload ) echo ' modal_autoload'; ?> fade" id="<?= $modal_id ?>" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title h5"><?php if( isset( $modal_title ) ) echo $modal_title; ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

<?= $modal ?>

        <div class="d-grid"><button type="button" class="btn btn-outline-primary mt-3" data-bs-dismiss="modal">Zurück</button></div>
      </div>
    </div>
  </div>
</div>