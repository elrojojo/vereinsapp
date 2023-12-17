function Schnittstelle_AjaxFuerDieSchlangeVorbereiten(AJAX) {
    // Manchmal ist das data-Objekt nicht notwendig, dann wird es als leeres Objekt definiert
    if (!isObject(AJAX.data)) AJAX.data = new Object();

    // Das Objekt für $.ajaxQueue wird erstellt
    AJAX.ajaxQueue = {
        ajax_id: AJAX.ajax_id,
        url: BASE_URL + AJAX.url,
        method: "post",
        data: AJAX.data,
        dataType: "json",
        beforeSend: function (ajax, ajaxQueue) {
            const AJAX = G.AJAX[Number(ajaxQueue.ajax_id)];
            Schnittstelle_AjaxRaus(AJAX);
        },
        success: function (antwort) {
            const AJAX = G.AJAX[Number(antwort.ajax_id)];
            AJAX.antwort = antwort;
            Schnittstelle_AjaxReinErfolg(AJAX);
        },
        error: function (xhr) {
            const AJAX = G.AJAX[Number(xhr.ajax_id)];
            AJAX.fehler = xhr;
            Schnittstelle_AjaxReinFehler(AJAX);
        },
        complete: function (ajax) {
            const AJAX = G.AJAX[Number(ajax.responseJSON.ajax_id)];
            Schnittstelle_AjaxRein(AJAX);
        },
    };

    Schnittstelle_AjaxStatusSetzen(AJAX, AJAX_ZUSTAND.VORBEREITET);
}
