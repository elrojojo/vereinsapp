function Schnittstelle_AjaxRein(AJAX) {
    // Aktion direkt nach dem Empfangen wird durchgeführt
    if (typeof AJAX.rein_aktion === "function") AJAX.rein_aktion(AJAX);

    // Falls Schleife aktiv ist, dann wird der nächste Durchlauf nach einer bestimmten Zeit gestartet
    if ("schleife" in AJAX && "schalter" in AJAX.schleife && "event" in AJAX.schleife && AJAX.schleife.schalter)
        setTimeout(function () {
            $(document).trigger(AJAX.schleife.event, [true, AJAX.liste]);
        }, AJAX_REFRESH_INTERVALL * 1000);
}
