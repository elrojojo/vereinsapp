<ul id="<?= $liste['id']; ?>" class="liste check_liste list-group<?php
if( array_key_exists( 'sortable', $liste ) AND $liste['sortable'] ) echo ' sortable';
?> mb-1"<?php
if( array_key_exists( 'liste', $liste ) ) { ?> data-liste="<?= $liste['liste']; ?>"<?php } ?>
data-check_liste="<?= $check_liste['check_liste']; ?>" data-aktion="<?= $check_liste['aktion']; ?>"
data-gegen_element="<?= $check_liste['gegen_element']; ?>" data-gegen_element_id="<?= $check_liste['gegen_element_id']; ?>"<?php
if( array_key_exists( 'filtern', $liste ) ) { ?> data-filtern='<?= json_encode( $liste['filtern'], JSON_UNESCAPED_UNICODE ); ?>'<?php }
if( array_key_exists( 'sortieren', $liste ) ) { ?> data-sortieren='<?= json_encode( $liste['sortieren'], JSON_UNESCAPED_UNICODE ); ?>'<?php }
?>>
    <li class="blanko invisible text-body list-group-item d-grid">
        <div class="form-check form-switch">
            <label class="form-check-label d-block">
                <input class="form-check-input float-start me-3 check" type="checkbox" role="switch" name="<?= $check_liste['id']; ?>" />
                <?php if( array_key_exists( 'beschriftung', $liste ) ) { ?><span class="beschriftung"><?= $liste['beschriftung']['beschriftung']; ?></span><?php } ?>
                <?php if( array_key_exists( 'sortable', $liste ) AND $liste['sortable'] ) { ?><i class="bi bi-<?= SYMBOLE['sortable']['bootstrap']; ?> text-primary float-end ms-1 stretched-link-unwirksam sortable_handle" role="button"></i><?php } ?>
                <?php if( array_key_exists( 'zusatzsymbole', $liste ) ) { ?><div class="float-end zusatzsymbole"><?= $liste['zusatzsymbole']; ?></div><?php } ?>
            </label>
        </div>
    </li>
</ul>

