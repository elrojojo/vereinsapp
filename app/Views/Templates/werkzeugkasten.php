<?= $this->section('werkzeugkasten') ?><?php if( isset($werkzeugkasten) ): ?>

<div class="fixed-bottom opacity-50 bg-white">
  <button class="btn btn-outline-secondary border-bottom-0 rounded-0 rounded-top float-end me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#werkzeugkasten" aria-controls="werkzeugkasten"><i class="bi-<?= SYMBOLE[ 'werkzeuge' ]['bootstrap']; ?> h5"></i></button>
</div>

<div class="offcanvas offcanvas-bottom" data-bs-scroll="true" tabindex="-1" id="werkzeugkasten" aria-labelledby="werkzeugkasten_Label">
  <div class="row offcanvas-body p-0"><div class="col"><ul class="werkzeugkasten list-group list-group-flush" data-bs-dismiss="offcanvas"><?php foreach( $werkzeugkasten as $aktion => $werkzeug): ?>
    <li class="werkzeug list-group-item list-group-item-action text-<?php if( isset($werkzeug['farbe']) ) echo $werkzeug['farbe']; else echo 'primary'; ?>" data-bs-toggle="modal" data-bs-target="<?= $werkzeug['modal_id']; ?>" data-titel="<?= $werkzeug['beschriftung']; ?>" data-aktion="<?= $aktion; ?>"<?php if( array_key_exists( 'liste', $werkzeug ) ) { ?> data-liste="<?= $werkzeug['liste']; ?>"<?php } ?><?php if( array_key_exists( 'element_id', $werkzeug ) ) { ?> data-element_id="<?= $werkzeug['element_id']; ?>"<?php } ?> role="button">
      <i class="bi bi-<?= SYMBOLE[ $aktion ]['bootstrap']; ?> float-start me-2"></i>
      <?= $werkzeug['beschriftung']; ?>
    </li>
  <?php endforeach; ?>
  </ul></div>
  <div class="col-auto opacity-50 bg-white me-2">
    <button class="btn btn-outline-secondary border-top-0 rounded-0 rounded-bottom h5" type="button" data-bs-dismiss="offcanvas" aria-label="Close"><i class="bi-<?= SYMBOLE[ 'werkzeuge' ]['bootstrap']; ?> h5"></i></button>
  </div></div>
</div>

<?php endif; ?><?= $this->endSection() ?>
