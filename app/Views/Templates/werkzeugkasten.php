<div class="offcanvas offcanvas-bottom" data-bs-scroll="true" tabindex="-1" id="werkzeugkasten">
    <div class="row offcanvas-body p-0">
        <div class="col">
            <ul class="werkzeugkasten list-group list-group-flush" data-bs-dismiss="offcanvas"><?php foreach( $werkzeugkasten as $aktion => $werkzeug): ?>
                <li class="werkzeug list-group-item list-group-item-action text-<?php
                    if( array_key_exists( 'farbe', $werkzeug ) ) echo $werkzeug['farbe']; else echo 'primary'; ?>"
                    data-bs-toggle="modal" data-bs-target="<?= $werkzeug['modal_id']; ?>"
                    data-title="<?= $werkzeug['title']; ?>" data-aktion="<?= $aktion; ?>"
                    data-liste="<?= $werkzeug['liste']; ?>"<?php if( array_key_exists( 'weiterleiten', $werkzeug ) ) { ?> data-weiterleiten="<?= $werkzeug['weiterleiten']; ?>"<?php } ?>
                    role="button">
                    <i class="bi bi-<?= SYMBOLE[ $aktion ]['bootstrap']; ?> float-start me-2"></i>
                    <?= $werkzeug['title']; ?>
                </li>
            <?php endforeach; ?></ul>
        </div>
        <div class="col-auto opacity-50 bg-white me-2">
            <button class="btn btn-outline-secondary border-top-0 rounded-0 rounded-bottom h5" type="button" data-bs-dismiss="offcanvas"><i class="bi-<?= SYMBOLE[ 'werkzeuge' ]['bootstrap']; ?> h5"></i></button>
        </div>
    </div>
</div>

