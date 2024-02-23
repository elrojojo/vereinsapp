<li class="auswertung<?php
if( isset( $zusammenfassung ) ) echo " zusammenfassung"; else echo " blanko invisible"; ?>"<?php
if( isset( $zusammenfassung ) ) { ?> data-instanz="<?= $zusammenfassung['instanz']; ?>"<?php } ?>
style="list-style: none;">
    <div class="row g-0"<?php
    if( !isset( $zusammenfassung ) ) { ?>data-bs-toggle="collapse" role="button"<?php } ?>>
        <div class="ergebnis_anzahl col-1 h5 float-start text-start" data-status=1></div>
        <div class="col-10 text-center">
            <span class="beschriftung"><?php if( isset( $zusammenfassung ) AND array_key_exists( 'beschriftung', $zusammenfassung ) ) echo $zusammenfassung['beschriftung']; ?></span>
        <?php if( !isset( $zusammenfassung ) ) { ?><i class="bi bi-<?= SYMBOLE['collapse_oeffnen']['bootstrap']; ?> toggle_symbol text-primary ms-1" data-toggle_symbol="<?= SYMBOLE['collapse_schliessen']['bootstrap']; ?>"></i><?php }
            if( !isset( $zusammenfassung ) OR array_key_exists( 'progress', $zusammenfassung ) ) { ?><div class="progress">
                <div class="ergebnis_anzahl progress-bar bg-success" data-status=1 role="progressbar"></div>
                <div class="ergebnis_anzahl progress-bar bg-transparent" data-status=0 role="progressbar"></div>
                <div class="ergebnis_anzahl progress-bar bg-danger" data-status=2 role="progressbar"></div>
            </div><?php } ?>
        </div>
        <div class="ergebnis_anzahl col-1 h5 float-end text-end" data-status=2></div>
    </div><?php
    if( !isset( $zusammenfassung ) ) { ?><div class="row g-0 collapse">
        <ul id="ergebnis_1" class="ergebnis liste col-6 text-center text-success" data-liste="mitglieder" style="list-style-type: none;" data-status=1>
            <li class="blanko invisible"><span class="eigenschaft" data-eigenschaft="vorname"></span> <span class="eigenschaft" data-eigenschaft="nachname"></span><span class="zusatzsymbole"><span class="zusatzsymbol" data-zusatzsymbol="kommentar"></span></span></li>
        </ul>
        <ul id="ergebnis_2" class="ergebnis liste col-6 text-center text-danger" data-liste="mitglieder" style="list-style-type: none;" data-status=2>
            <li class="blanko invisible"><span class="eigenschaft" data-eigenschaft="vorname"></span> <span class="eigenschaft" data-eigenschaft="nachname"></span><span class="zusatzsymbole"><span class="zusatzsymbol" data-zusatzsymbol="kommentar"></span></span></li>
        </ul>
        <div id="ergebnis_0" class="ergebnis liste col-12 text-center text-secondary small" data-liste="mitglieder" data-status=0>
            <span class="blanko invisible"><span class="eigenschaft" data-eigenschaft="vorname"></span> <span class="eigenschaft" data-eigenschaft="nachname"></span><span class="spacer">, </span></span>
        </div>
    </div><?php } ?>
</li>

