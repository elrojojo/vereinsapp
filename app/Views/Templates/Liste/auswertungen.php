<ul id="<?= $auswertungen['id']; ?>" class="auswertungen text-center<?php
if( array_key_exists( 'sortable', $auswertungen ) AND $auswertungen['sortable'] ) echo ' sortable';
?> mb-1" data-auswertungen="<?= $auswertungen['auswertungen']; ?>" data-status_auswahl='<?= json_encode( $auswertungen['status_auswahl'], JSON_UNESCAPED_UNICODE ); ?>'<?php
if( array_key_exists( 'liste', $auswertungen ) ) { ?> data-liste='<?= json_encode( $auswertungen['liste'], JSON_UNESCAPED_UNICODE ); ?>'<?php }
if( array_key_exists( 'gegen_liste', $auswertungen ) ) { ?> data-gegen_liste='<?= json_encode( $auswertungen['gegen_liste'], JSON_UNESCAPED_UNICODE ); ?>'<?php }
?> style="list-style-type: none; padding:0px;">

    <li class="auswertung blanko invisible">
        <div class="row g-0" data-bs-toggle="collapse" role="button">
            <div class="ergebnis_anzahl col-1 h5 float-start text-start" data-status=1></div>
            <div class="col-10 text-center">
                <span class="beschriftung"></span>
                <i class="bi bi-<?= SYMBOLE['collapse']['bootstrap']; ?> text-primary ms-1 collapse-toggle"></i>
                <?php if( array_key_exists( 'sortable', $auswertungen ) AND $auswertungen['sortable'] ) { ?><i class="bi bi-<?= SYMBOLE['sortable']['bootstrap']; ?> text-primary ms-1 sortable_handle" role="button"></i><?php } ?>
                <div class="progress">
                    <div class="ergebnis_anzahl progress-bar bg-success" data-status=1 role="progressbar"></div>
                    <div class="ergebnis_neutral_anzahl progress-bar bg-transparent" role="progressbar"></div>
                    <div class="ergebnis_anzahl progress-bar bg-danger" data-status=0 role="progressbar"></div>
                </div>
            </div>
            <div class="ergebnis_anzahl col-1 h5 float-end text-end" data-status=0></div>
        </div>
        <div class="row g-0 collapse">
            <ul id="ergebnis_1" class="ergebnis liste col-6 text-center text-success" data-liste="mitglieder" style="list-style-type: none;" data-status=1>
                <li class="blanko invisible"><span class="eigenschaft" data-eigenschaft="vorname"></span> <span class="eigenschaft" data-eigenschaft="nachname"></span><span class="zusatzsymbole"><span class="zusatzsymbol" data-zusatzsymbol="kommentar"></span></span></li>
            </ul>
            <ul id="ergebnis_0" class="ergebnis liste col-6 text-center text-danger" data-liste="mitglieder" style="list-style-type: none;" data-status=0>
                <li class="blanko invisible"><span class="eigenschaft" data-eigenschaft="vorname"></span> <span class="eigenschaft" data-eigenschaft="nachname"></span><span class="zusatzsymbole"><span class="zusatzsymbol" data-zusatzsymbol="kommentar"></span></span></li>
            </ul>
            <div id="ergebnis_neutral" class="ergebnis_neutral liste col-12 text-center text-secondary small" data-liste="mitglieder">
                <span class="blanko invisible"><span class="eigenschaft" data-eigenschaft="vorname"></span> <span class="eigenschaft" data-eigenschaft="nachname"></span><span class="spacer">, </span></span>
            </div>
        </div>
    </li>

</ul>

