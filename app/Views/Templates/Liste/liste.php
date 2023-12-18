<?php
if( array_key_exists( 'werkzeugkasten_liste', $liste ) ) { ?><div class="werkzeugkasten h5 text-secondary text-end mb-1" data-liste_id="<?= $liste['id']; ?>">
    <?php foreach( $liste['werkzeugkasten_liste'] as $aktion => $werkzeug):
        ?><i class="werkzeug bi bi-<?= SYMBOLE[ $aktion ]['bootstrap']; ?> text-secondary ms-2" data-bs-toggle="modal" data-bs-target="<?= $werkzeug['modal_id']; ?>" data-aktion="<?= $aktion; ?>" data-liste="<?= $liste['liste']; ?>" role="button"></i>
    <?php endforeach; ?>
</div><?php } ?>
<ul id="<?= $liste['id']; ?>" class="liste list-group<?php
if( array_key_exists( 'beschriftung', $liste ) AND array_key_exists( 'h5', $liste['beschriftung'] ) AND $liste['beschriftung']['h5'] ) echo ' list-group-flush';
if( array_key_exists( 'sortable', $liste ) AND $liste['sortable'] ) echo ' sortable';
?> mb-1" data-liste="<?= $liste['liste']; ?>"<?php
if( array_key_exists( 'filtern', $liste ) ) { ?> data-filtern='<?= json_encode( $liste['filtern'], JSON_UNESCAPED_UNICODE ); ?>'<?php }
if( array_key_exists( 'sortieren', $liste ) ) { ?> data-sortieren='<?= json_encode( $liste['sortieren'], JSON_UNESCAPED_UNICODE ); ?>'<?php }
?>>

    <li class="blanko invisible text-body list-group-item<?php
    if( array_key_exists( 'beschriftung', $liste ) AND array_key_exists( 'h5', $liste['beschriftung'] ) AND $liste['beschriftung']['h5'] ) echo ' list-group-liste_h5';
    if( array_key_exists( 'modal', $liste ) OR array_key_exists( 'link', $liste ) ) { ?> list-group-item-action<?php } ?>"<?php
    if( array_key_exists( 'modal', $liste ) OR array_key_exists( 'link', $liste ) ) { ?> role="button"<?php } ?>>

        <div <?php if( array_key_exists( 'beschriftung', $liste ) AND array_key_exists( 'h5', $liste['beschriftung'] ) AND $liste['beschriftung']['h5'] ) echo 'class="h5"'; ?>>
            
            <?php if( array_key_exists( 'beschriftung', $liste ) ) { ?><span class="beschriftung"><?= $liste['beschriftung']['beschriftung']; ?></span><?php } ?>

            <?php if( array_key_exists( 'werkzeugkasten_element', $liste ) ) { ?><i class="bi bi-three-dots-vertical text-primary float-end stretched-link-unwirksam" role="button" data-bs-toggle="collapse" data-bs-target="#werkzeugkasten_element_"></i><?php } ?>

            <?php if( array_key_exists( 'sortable', $liste ) AND $liste['sortable'] ) { ?><i class="bi bi-<?= SYMBOLE['sortable']['bootstrap']; ?> text-primary float-end ms-1 stretched-link-unwirksam sortable_handle" role="button"></i><?php } ?>

            <?php if( array_key_exists( 'link', $liste ) ) { ?><a href="<?= $liste['link']; ?>" class="stretched-link"><?php }
            elseif( array_key_exists( 'modal', $liste ) ) { ?><span class="stretched-link" data-bs-toggle="modal"<?php if( array_key_exists( 'target', $liste['modal'] ) ) { ?> data-bs-target="<?= $liste['modal']['target']; ?>"<?php } ?><?php if( array_key_exists( 'aktion', $liste['modal'] ) ) { ?> data-aktion="<?= $liste['modal']['aktion']; ?>"<?php } ?>><?php } ?>
            <?php if( array_key_exists( 'symbol', $liste ) AND array_key_exists( 'symbol', $liste['symbol'] ) ) { ?><i class="bi bi-<?= $liste['symbol']['symbol']; ?> text-<?php if( array_key_exists( 'farbe', $liste['symbol'] ) ) echo $liste['symbol']['farbe']; else echo 'primary' ?> float-end ms-1 symbol"></i><?php } ?>
            <?php if( array_key_exists( 'link', $liste ) ) { ?></a><?php }
            elseif( array_key_exists( 'modal', $liste ) ) { ?></span><?php } ?>

            <?php if( array_key_exists( 'zusatzsymbole', $liste ) ) { ?><div class="float-end zusatzsymbole"><?= $liste['zusatzsymbole']; ?></div><?php } ?>

        </div>

        <?php if( array_key_exists( 'vorschau', $liste ) ) { ?><div class="text-secondary vorschau<?php
        if( array_key_exists( 'klein', $liste['vorschau'] ) AND $liste['vorschau']['klein'] ) echo ' small';
        if( array_key_exists( 'abschneiden', $liste['vorschau'] ) AND $liste['vorschau']['abschneiden'] ) echo ' text-truncate';
        if( array_key_exists( 'zentriert', $liste['vorschau'] ) AND $liste['vorschau']['zentriert'] ) echo ' text-center'; ?>">
            <?php if( array_key_exists( 'beschriftung', $liste['vorschau'] ) ) echo $liste['vorschau']['beschriftung']; ?>
        </div><?php } ?>

        <?php if( array_key_exists( 'werkzeugkasten_element', $liste ) ) { ?><div class="collapse <?php if( array_key_exists( 'beschriftung', $liste ) AND array_key_exists( 'h5', $liste['beschriftung'] ) AND $liste['beschriftung']['h5'] ) { ?>h5 <?php } ?>stretched-link-unwirksam" id="werkzeugkasten_element_"><span data-bs-toggle="collapse" data-bs-target="#werkzeugkasten_">
            <?php foreach( $liste['werkzeugkasten_element'] as $aktion => $werkzeug):
            ?><i class="bi bi-<?= SYMBOLE[ $aktion ]['bootstrap']; ?> text-<?php if( array_key_exists( 'farbe', $werkzeug ) ) echo $werkzeug['farbe']; else echo 'primary'; ?> float-end ms-2" data-bs-toggle="modal" data-bs-target="<?= $werkzeug['modal_id']; ?>" data-aktion="<?= $aktion; ?>" data-liste="<?= $liste['liste']; ?>" role="button"></i>
            <?php endforeach; ?>
        </span></div><?php } ?>

    </li>

</ul>

