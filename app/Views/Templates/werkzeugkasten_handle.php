<div class="fixed-bottom">
    <button class="btn btn-outline-secondary border-bottom-0 rounded-0 rounded-top float-end me-2 opacity-50" data-bs-toggle="offcanvas" data-bs-target="#werkzeugkasten"<?php
    if( isset( $liste ) ) { ?> data-liste = "<?= $liste; ?>"<?php }
    if( isset( $element_id ) ) { ?> data-element_id = "<?= $element_id; ?>"<?php }
    ?> type="button">
        <i class="bi-<?= SYMBOLE[ 'werkzeuge' ]['bootstrap']; ?> h5"></i>
    </button>
</div>

