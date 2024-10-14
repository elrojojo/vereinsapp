<ul id="<?= $verzeichnis['id']; ?>" class="verzeichnis list-group<?php
?> mb-1" data-liste="<?= $verzeichnis['liste']; ?>"<?php
if( array_key_exists( 'filtern', $verzeichnis ) ) { ?> data-filtern='<?= json_encode( $verzeichnis['filtern'], JSON_UNESCAPED_UNICODE ); ?>'<?php }
if( array_key_exists( 'sortieren', $verzeichnis ) ) { ?> data-sortieren='<?= json_encode( $verzeichnis['sortieren'], JSON_UNESCAPED_UNICODE ); ?>'<?php }
?> data-element_id="<?= $verzeichnis['element_id']; ?>">

    <li class="blanko unterverzeichnis invisible text-body list-group-item p-0">

        <div class="card border-0">
            <div class="card-header border-0 bg-transparent text-truncate" data-bs-toggle="collapse" role="button"><i class="bi bi-<?= SYMBOLE["verzeichnis"]["bootstrap"]; ?> toggle_symbol text-primary me-1" data-toggle_symbol="<?= SYMBOLE['verzeichnis_geoeffnet']['bootstrap']; ?>"></i></span><span class="beschriftung"></span></div>
            <ul class="list-group verzeichnis p-1 pt-0 collapse verzeichnis_collapse">

                <li class="blanko datei invisible text-body list-group-item<?php
                    if( array_key_exists( 'link', $verzeichnis ) AND $verzeichnis['link'] ) { ?> list-group-item-action<?php } ?>"<?php
                    if( array_key_exists( 'link', $verzeichnis ) AND $verzeichnis['link'] ) { ?> role="button"<?php } ?>>
                            
                    <span class="zusatzsymbol" data-zusatzsymbol="datei"></span><span class="beschriftung"></span><span class="audio"></span>
                    
                    <?php if( array_key_exists( 'link', $verzeichnis ) AND $verzeichnis['link'] ) { ?><a class="btn_verzeichnis_oeffnen stretched-link" target="_blank"></a><?php } ?>

                    <?php if( array_key_exists( 'vorschau', $verzeichnis ) ) { ?><div class="vorschau small text-truncate text-secondary">
                        <?php if( array_key_exists( 'beschriftung', $verzeichnis['vorschau'] ) ) echo $verzeichnis['vorschau']['beschriftung']; ?>
                    </div><?php } ?>

                </li>

            </ul>
        </div>

    </li>

</ul>
