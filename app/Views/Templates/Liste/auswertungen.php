<ul id="<?= $auswertungen['id']; ?>" class="auswertungen text-center<?php
if( array_key_exists( 'sortable', $auswertungen ) AND $auswertungen['sortable'] ) echo ' sortable';
?> mb-1" data-auswertungen="<?= $auswertungen['auswertungen']; ?>"<?php
if( array_key_exists( 'filtern', $auswertungen ) ) { ?> data-filtern='<?= json_encode( $auswertungen['filtern'], JSON_UNESCAPED_UNICODE ); ?>'<?php }
if( array_key_exists( 'cluster', $auswertungen ) ) { ?> data-cluster='<?= json_encode( $auswertungen['cluster'], JSON_UNESCAPED_UNICODE ); ?>'<?php }
?> style="list-style-type: none; padding:0px;">

    <li class="auswertung blanko invisible">
        <div class="row g-0" data-bs-toggle="collapse" role="button">
            <div class="ergebnis col-1 h5 float-start text-start" data-ergebnis="positiv_anzahl"></div>
            <div class="col-10 text-center">
                <span class="beschriftung"></span>
                <i class="bi bi-<?= SYMBOLE['collapse']['bootstrap']; ?> text-primary ms-1 collapse-toggle"></i>
                <?php if( array_key_exists( 'sortable', $auswertungen ) AND $auswertungen['sortable'] ) { ?><i class="bi bi-<?= SYMBOLE['sortable']['bootstrap']; ?> text-primary ms-1 sortable_handle" role="button"></i><?php } ?>
                <div class="progress">
                    <div class="ergebnis progress-bar bg-success" data-ergebnis="positiv_anzahl" role="progressbar"></div>
                    <div class="ergebnis progress-bar bg-transparent" data-ergebnis="neutral_anzahl" role="progressbar"></div>
                    <div class="ergebnis progress-bar bg-danger" data-ergebnis="negativ_anzahl" role="progressbar"></div>
                </div>
            </div>
            <div class="ergebnis col-1 h5 float-end text-end" data-ergebnis="negativ_anzahl"></div>
        </div><div class="row g-0 collapse">
            <ul id="ergebnis_positiv" class="ergebnis liste col-6 text-center text-success" style="list-style-type: none;" data-ergebnis="positiv" data-liste="mitglieder" >
                <li class="blanko invisible" data-liste="mitglieder"><span class="eigenschaft" data-eigenschaft="vorname"></span> <span class="eigenschaft" data-eigenschaft="nachname"></span><span class="zusatzsymbole"><span class="zusatzsymbol" data-zusatzsymbol="kommentar"></span></span></li>
            </ul>
            <ul id="ergebnis_negativ" class="ergebnis liste col-6 text-center text-danger" style="list-style-type: none;" data-ergebnis="negativ" data-liste="mitglieder">
                <li class="blanko invisible" data-liste="mitglieder"><span class="eigenschaft" data-eigenschaft="vorname"></span> <span class="eigenschaft" data-eigenschaft="nachname"></span><span class="zusatzsymbole"><span class="zusatzsymbol" data-zusatzsymbol="kommentar"></span></span></li>
            </ul>
            <div id="ergebnis_neutral" class="ergebnis liste col-12 text-center text-secondary small" data-ergebnis="neutral" data-liste="mitglieder">
                <span class="blanko invisible" data-liste="mitglieder"><span class="eigenschaft" data-eigenschaft="vorname"></span> <span class="eigenschaft" data-eigenschaft="nachname"></span><span class="spacer">, </span></span>
            </div>
        </div>
    </li>

</ul>

