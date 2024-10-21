<div>
    <button class="btn btn_aufgabe_zuweisen<?php
        if( auth()->user()->can( 'aufgaben.verwaltung' ) ) echo ' auswahl_oeffnen'; else echo ' bestaetigung_einfordern';
    ?> btn-outline-primary btn-sm" data-liste="aufgaben" data-title="Aufgabe zuweisen"></button>
</div>