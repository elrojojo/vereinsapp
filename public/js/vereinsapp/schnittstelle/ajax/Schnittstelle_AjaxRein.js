function Schnittstelle_AjaxRein(AJAX) {
    // Aktion direkt nach dem Empfangen wird durchgeführt
    if (typeof AJAX.rein_aktion === "function") AJAX.rein_aktion(AJAX);

    // Falls Schleife aktiv ist, dann wird der nächste Durchlauf nach AJAX_REFRESH_INTERVALL Sekunden gestartet
    if (typeof AJAX.schleife === "function") setTimeout(AJAX.schleife, AJAX_REFRESH_INTERVALL * 1000, AJAX.liste, true, AJAX.naechste_aktionen);
}
