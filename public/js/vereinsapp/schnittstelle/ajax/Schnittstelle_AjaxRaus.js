function Schnittstelle_AjaxRaus(AJAX) {
    // Aktion direkt vor dem Absenden wird durchgeführt
    if (typeof AJAX.raus_aktion === "function") AJAX.raus_aktion(AJAX);

    Schnittstelle_AjaxStatusSetzen(AJAX, AJAX_ZUSTAND.RAUS);
}
