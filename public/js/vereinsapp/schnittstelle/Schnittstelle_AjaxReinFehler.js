function Schnittstelle_AjaxReinFehler(AJAX) {
    console.log(AJAX.id, G.AJAX);
    console.log("FEHLER " + AJAX.id + ": " + AJAX.fehler.status + " " + AJAX.fehler.statusText);
}
