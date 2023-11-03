function Schnittstelle_AjaxReinFehler(AJAX) {
    console.log("FEHLER " + AJAX.id + ": " + AJAX.fehler.status + " " + AJAX.fehler.statusText);

    // Output in die Konsole zu Testzwecken
    console.log(AJAX.id, G.AJAX);
}
