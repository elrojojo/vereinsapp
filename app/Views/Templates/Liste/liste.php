<?php if( array_key_exists( 'werkzeugkasten', $liste ) ) { ?><div class="werkzeugkasten h5 text-end">
    <?php if( array_key_exists( 'checkliste', $liste ) AND array_key_exists( 'werkzeugkasten', $liste['checkliste'] ) ) foreach( $liste['checkliste']['werkzeugkasten'] as $aktion => $werkzeug):
        ?><button class="btn btn_<?= $aktion; ?> werkzeug text-primary" data-title="<?= $werkzeug['title']; ?>" data-aktion="<?= $aktion; ?>" data-liste="<?= $liste['liste']; ?>" data-instanz="<?= $liste['id']; ?>"><i class=" bi bi-<?= SYMBOLE[ $aktion ]['bootstrap']; ?>"></i></button>
    <?php endforeach; ?>
    <?php foreach( $liste['werkzeugkasten'] as $aktion => $werkzeug):
        ?><button class="btn werkzeug text-primary" data-bs-toggle="modal" data-bs-target="<?= $werkzeug['modal_id']; ?>" data-title="<?= $werkzeug['title']; ?>" data-aktion="<?= $aktion; ?>" data-liste="<?= $liste['liste']; ?>" data-instanz="<?= $liste['id']; ?>"><i class=" bi bi-<?= SYMBOLE[ $aktion ]['bootstrap']; ?>"></i></button>
    <?php endforeach; ?>
</div><?php } ?>
<?php if( array_key_exists( 'listenstatistik', $liste ) AND $liste['listenstatistik'] ) { ?><div class="text-secondary text-end small mb-1">
    <span class="listenstatistik" data-instanz="<?= $liste['id']; ?>" data-listenstatistik="gefunden"></span> Element(e) gefunden<?php if( array_key_exists( 'checkliste', $liste ) ) { ?> / <span class="listenstatistik" data-instanz="<?= $liste['id']; ?>" data-listenstatistik="angewaehlt"></span> Element(e) angewählt<?php }?>
</div><?php } ?>
<ul id="<?= $liste['id']; ?>" class="liste list-group<?php
if( array_key_exists( 'checkliste', $liste ) ) echo ' checkliste';
if( array_key_exists( 'beschriftung', $liste ) AND array_key_exists( 'h5', $liste['beschriftung'] ) AND $liste['beschriftung']['h5'] ) echo ' list-group-flush';
if( array_key_exists( 'sortable', $liste ) AND $liste['sortable'] ) echo ' sortable';
?> mb-1" data-liste="<?= $liste['liste']; ?>"<?php
if( array_key_exists( 'checkliste', $liste ) ) { ?>data-checkliste="<?= $liste['checkliste']['checkliste']; ?>" data-aktion="<?= $liste['checkliste']['aktion']; ?>" data-gegen_liste="<?= $liste['checkliste']['gegen_liste']; ?>"<?php
if( array_key_exists( 'gegen_element_id', $liste['checkliste']) ) { ?> data-gegen_element_id="<?= $liste['checkliste']['gegen_element_id']; ?>"<?php }
if( array_key_exists( 'bedingte_formatierung', $liste['checkliste'] ) ) { ?> data-bedingte_formatierung='<?= json_encode( $liste['checkliste']['bedingte_formatierung'], JSON_UNESCAPED_UNICODE ); ?>'<?php }
if( array_key_exists( 'elemente_disabled', $liste['checkliste'] ) ) { ?> data-elemente_disabled='<?= json_encode( $liste['checkliste']['elemente_disabled'], JSON_UNESCAPED_UNICODE ); ?>'<?php } }
if( array_key_exists( 'filtern', $liste ) ) { ?> data-filtern='<?= json_encode( $liste['filtern'], JSON_UNESCAPED_UNICODE ); ?>'<?php }
if( array_key_exists( 'sortieren', $liste ) ) { ?> data-sortieren='<?= json_encode( $liste['sortieren'], JSON_UNESCAPED_UNICODE ); ?>'<?php }
?>>

    <li class="blanko invisible text-body list-group-item<?php
    if( array_key_exists( 'beschriftung', $liste ) AND array_key_exists( 'h5', $liste['beschriftung'] ) AND $liste['beschriftung']['h5'] ) echo ' list-group-liste_h5';
    if( array_key_exists( 'checkliste', $liste ) ) echo ' d-grid';
    if( array_key_exists( 'modal', $liste ) OR ( array_key_exists( 'link', $liste ) AND $liste['link'] ) ) { ?> list-group-item-action<?php } ?>"<?php
    if( array_key_exists( 'modal', $liste ) OR ( array_key_exists( 'link', $liste ) AND $liste['link'] ) ) { ?> role="button"<?php } ?>>

        <div <?php if( array_key_exists( 'beschriftung', $liste ) AND array_key_exists( 'h5', $liste['beschriftung'] ) AND $liste['beschriftung']['h5'] ) echo 'class="h5"'; ?>>
            
        <?php if( array_key_exists( 'checkliste', $liste ) ) { ?><div class="form-check form-switch">
            <label class="form-check-label d-block">
                <input class="form-check-input float-start me-3 check" type="checkbox" name="<?= $liste['checkliste']['checkliste']; ?>" role="switch" />
        <?php } ?>
            <?php if( array_key_exists( 'beschriftung', $liste ) ) { ?><span class="beschriftung"><?= $liste['beschriftung']['beschriftung']; ?></span><?php } ?>

            <?php if( array_key_exists( 'werkzeugkasten_handle', $liste ) AND $liste['werkzeugkasten_handle'] ) { ?><i class="bi bi-<?= SYMBOLE['werkzeuge']['bootstrap']; ?> text-primary float-end ms-2 stretched-link-unwirksam" data-bs-toggle="offcanvas" data-bs-target="#werkzeugkasten" data-liste="<?= $liste['liste']; ?>" role="button"></i><?php } ?>

            <?php if( array_key_exists( 'sortable', $liste ) AND $liste['sortable'] ) { ?><i class="bi bi-<?= SYMBOLE['sortable']['bootstrap']; ?> text-primary float-end ms-2 stretched-link-unwirksam sortable_handle" role="button"></i><?php } ?>

            <?php if( array_key_exists( 'link', $liste ) AND $liste['link'] ) { ?><a class="stretched-link"><?php }
            elseif( array_key_exists( 'modal', $liste ) ) { ?><span class="stretched-link" data-bs-toggle="modal" data-bs-target="<?= $liste['modal']['target']; ?>" data-aktion="<?= $liste['modal']['aktion']; ?>" data-liste="<?= $liste['liste']; ?>"><?php } ?>
            <?php if( array_key_exists( 'symbol', $liste ) AND array_key_exists( 'symbol', $liste['symbol'] ) ) { ?><i class="bi bi-<?= $liste['symbol']['symbol']; ?> text-<?php if( array_key_exists( 'farbe', $liste['symbol'] ) ) echo $liste['symbol']['farbe']; else echo 'primary' ?> float-end ms-2 symbol"></i><?php } ?>
            <?php if( array_key_exists( 'link', $liste ) AND $liste['link'] ) { ?></a><?php }
            elseif( array_key_exists( 'modal', $liste ) ) { ?></span><?php } ?>

            <?php if( array_key_exists( 'zusatzsymbole', $liste ) ) { ?><div class="float-end zusatzsymbole"><?= $liste['zusatzsymbole']; ?></div><?php } ?>

        <?php if( array_key_exists( 'checkliste', $liste ) ) { ?></label>
        </div>
        <?php } ?>
        </div>

        <?php if( array_key_exists( 'vorschau', $liste ) ) { ?><div class="text-secondary vorschau<?php
        if( array_key_exists( 'klein', $liste['vorschau'] ) AND $liste['vorschau']['klein'] ) echo ' small';
        if( array_key_exists( 'abschneiden', $liste['vorschau'] ) AND $liste['vorschau']['abschneiden'] ) echo ' text-truncate';
        if( array_key_exists( 'zentriert', $liste['vorschau'] ) AND $liste['vorschau']['zentriert'] ) echo ' text-center'; ?>">
            <?php if( array_key_exists( 'beschriftung', $liste['vorschau'] ) ) echo $liste['vorschau']['beschriftung']; ?>
        </div><?php } ?>

    </li>

</ul>

