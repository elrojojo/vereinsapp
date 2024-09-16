<li class="auswertung blanko invisible" style="list-style: none;">
    <div class="row g-0" data-bs-toggle="collapse" role="button">
        <div class="ergebnis_anzahl col-1 h5 float-start text-start" data-status=1></div>
        <div class="col-10 text-center">
            <span class="beschriftung"></span>
            <i class="bi bi-<?= SYMBOLE['collapse_oeffnen']['bootstrap']; ?> toggle_symbol text-primary ms-1" data-toggle_symbol="<?= SYMBOLE['collapse_schliessen']['bootstrap']; ?>"></i>
            <div class="progress-stacked">
                <div class="progress ergebnis_anzahl" role="progressbar" data-status=1><div class="progress-bar bg-success"></div></div>
                <div class="progress ergebnis_anzahl" role="progressbar" data-status=0><div class="progress-bar bg-transparent"></div></div>
                <div class="progress ergebnis_anzahl" role="progressbar" data-status=2><div class="progress-bar bg-danger"></div></div>
            </div>
        </div>
        <div class="ergebnis_anzahl col-1 h5 float-end text-end" data-status=2></div>
    </div>
    <div class="row g-0 collapse auswertung_collapse">
        <ul id="<?= $auswertungen['id']; ?>_ergebnis_1" class="ergebnis liste col-6 text-center text-success" data-liste="mitglieder" style="list-style-type: none;" data-status=1>
            <li class="blanko invisible"><span class="eigenschaft" data-eigenschaft="vorname"></span> <span class="eigenschaft" data-eigenschaft="nachname"></span><span class="zusatzsymbole"><span class="zusatzsymbol" data-zusatzsymbol="kommentar"></span></span></li>
        </ul>
        <ul id="<?= $auswertungen['id']; ?>_ergebnis_2" class="ergebnis liste col-6 text-center text-danger" data-liste="mitglieder" style="list-style-type: none;" data-status=2>
            <li class="blanko invisible"><span class="eigenschaft" data-eigenschaft="vorname"></span> <span class="eigenschaft" data-eigenschaft="nachname"></span><span class="zusatzsymbole"><span class="zusatzsymbol" data-zusatzsymbol="kommentar"></span></span></li>
        </ul>
        <div id="<?= $auswertungen['id']; ?>_ergebnis_0" class="ergebnis liste col-12 text-center text-secondary small" data-liste="mitglieder" data-status=0>
            <span class="blanko invisible"><span class="eigenschaft" data-eigenschaft="vorname"></span> <span class="eigenschaft" data-eigenschaft="nachname"></span><span class="spacer">, </span></span>
        </div>
    </div>
</li>

