<div class="btn-group" role="group">
    <button type="button" class="btn btn_aufgabe_mitglied_einplanen<?php
    if( auth()->user()->can( 'aufgaben.verwaltung' ) ) echo " auswahl_oeffnen"; else echo " bestaetigung_einfordern";
    ?> btn-sm" data-title="<?php
    if( auth()->user()->can( 'aufgaben.verwaltung' ) ) echo "Mitglied"; else echo "Mich";
    ?> für die Aufgabe einplanen"></button>
</div>
<div class="invisible" role="group">
    <button type="button" class="btn btn_aufgabe_mitglied_ausplanen bestaetigung_einfordern btn-sm btn-outline-danger" data-title="<?php if( auth()->user()->can( 'aufgaben.verwaltung' ) ) echo "Mitglied"; else echo "Mich"; ?> nicht mehr für die Aufgabe einplanen"><i class="bi bi-<?= SYMBOLE['loeschen']['bootstrap'] ?>"></i></button>
    <button type="button" class="btn btn_aufgabe_offen_erledigt_markieren bestaetigung_einfordern btn-sm" data-title="Aufgabe als offen/erledigt markieren"><i class="bi bi-<?= SYMBOLE['offen_erledigt_markieren']['bootstrap'] ?>"></i></button>
</div>
