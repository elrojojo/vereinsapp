function Schnittstelle_AjaxReinFehler(AJAX) {
    Schnittstelle_AjaxStatusSetzen(AJAX, AJAX_ZUSTAND.REIN_FEHLER);

    Schnittstelle_LogInDieKonsole("FEHLER", AJAX.fehler.status, AJAX.fehler.statusText, AJAXSCHLANGE);

    Schnittstelle_AjaxStatusSetzen(AJAX, AJAX_ZUSTAND.FERTIG);
}
