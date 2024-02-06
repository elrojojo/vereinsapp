<ul class="breadcrumb verzeichnis_pfad" data-verzeichnis_instanz="<?= $verzeichnis['id']; ?>" style="--bs-breadcrumb-divider: '>';">

    <li class="breadcrumb-item blanko invisible text-primary" data-liste="<?= $verzeichnis['liste']; ?>" data-verzeichnis_instanz="<?= $verzeichnis['id']; ?>" role="button"></li>

</ul>

<ul id="<?= $verzeichnis['id']; ?>" class="verzeichnis list-group mb-1" data-liste="<?= $verzeichnis['liste']; ?>"<?php
if( array_key_exists( 'filtern', $verzeichnis ) ) { ?> data-filtern='<?= json_encode( $verzeichnis['filtern'], JSON_UNESCAPED_UNICODE ); ?>'<?php }
if( array_key_exists( 'sortieren', $verzeichnis ) ) { ?> data-sortieren='<?= json_encode( $verzeichnis['sortieren'], JSON_UNESCAPED_UNICODE ); ?>'<?php }
?> data-element_id="<?= $verzeichnis['element_id']; ?>">

    <li class="blanko invisible text-body list-group-item<?php
    if( array_key_exists( 'link', $verzeichnis ) AND $verzeichnis['link'] ) { ?> list-group-item-action<?php } ?>"<?php
    if( array_key_exists( 'link', $verzeichnis ) AND $verzeichnis['link'] ) { ?> role="button"<?php } ?>>
            
        <span class="beschriftung"></span>

        <?php if( array_key_exists( 'link', $verzeichnis ) AND $verzeichnis['link'] ) { ?><a class="btn_verzeichnis_oeffnen stretched-link"><?php } ?>
        <?php if( array_key_exists( 'symbol', $verzeichnis ) ) { ?><i class="bi text-primary float-start me-1 symbol"></i><?php } ?>
        <?php if( array_key_exists( 'link', $verzeichnis ) AND $verzeichnis['link'] ) { ?></a><?php } ?>

        <?php if( array_key_exists( 'zusatzsymbole', $verzeichnis ) ) { ?><div class="float-end zusatzsymbole"><?= $verzeichnis['zusatzsymbole']; ?></div><?php } ?>

        <?php if( array_key_exists( 'vorschau', $verzeichnis ) ) { ?><div class="text-secondary vorschau small<?php
        if( array_key_exists( 'abschneiden', $verzeichnis['vorschau'] ) AND $verzeichnis['vorschau']['abschneiden'] ) echo ' text-truncate'; ?>">
            <?php if( array_key_exists( 'beschriftung', $verzeichnis['vorschau'] ) ) echo $verzeichnis['vorschau']['beschriftung']; ?>
        </div><?php } ?>

    </li>

</ul>
