function Schnittstelle_AjaxFuerDieSchlangeVorbereiten(AJAX) {
    // Manchmal ist das data-Objekt nicht notwendig, dann wird es als leeres Objekt definiert
    if (typeof AJAX.data === "undefined") AJAX.data = {};

    // Das Objekt für $.ajaxQueue wird erstellt
    AJAX.ajaxQueue = {
        url: BASE_URL + AJAX.url,
        method: "post",
        data: AJAX.data,
        dataType: "json",
        beforeSend: Schnittstelle_AjaxRaus(AJAX),
        success: function (antwort) {
            AJAX.antwort = antwort;
            Schnittstelle_AjaxReinErfolg(AJAX);
        },
        error: function (xhr) {
            AJAX.fehler = xhr;
            Schnittstelle_AjaxReinFehler(AJAX);
        },
        complete: Schnittstelle_AjaxRein(AJAX),
    };
}
