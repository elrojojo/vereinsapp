function Schnittstelle_AjaxReinFehler(AJAX) {
    console.log("FEHLER " + AJAX.label + ": " + AJAX.fehler.status + " " + AJAX.fehler.statusText);

    // Output in die Konsole zu Testzwecken
    console.log(AJAX.label, G.AJAX);
}
