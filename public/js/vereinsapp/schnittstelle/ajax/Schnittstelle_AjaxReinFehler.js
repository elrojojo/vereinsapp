function Schnittstelle_AjaxReinFehler(AJAX) {
    Schnittstelle_AjaxStatusSetzen(AJAX, AJAX_ZUSTAND.REIN_FEHLER);

    console.log("FEHLER", AJAX.label, AJAX.fehler.status, AJAX.fehler.statusText, G.AJAX);

    Schnittstelle_AjaxStatusSetzen(AJAX, AJAX_ZUSTAND.FERTIG);
}
