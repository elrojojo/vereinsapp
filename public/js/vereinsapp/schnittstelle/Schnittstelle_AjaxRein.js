function Schnittstelle_AjaxRein(AJAX) {
    // Output in die Konsole zu Testzwecken
    console.log(AJAX.id, G.AJAX);

    // Aktion direkt nach dem Empfangen wird durchgeführt
    if (typeof AJAX.rein_aktion === "function") AJAX.rein_aktion(AJAX);
}
