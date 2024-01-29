function Schnittstelle_AjaxInDieSchlange(AJAX) {
    // Manchmal ist das data-Objekt nicht notwendig, dann wird es als leeres Objekt definiert
    if (!isObject(AJAX.data)) AJAX.data = new Object();
    if (!("warten_auf" in AJAX)) AJAX.warten_auf = AJAX.ajax_id;

    // Das Objekt für $.ajaxQueue wird erstellt
    AJAX.ajaxQueue = {
        ajax_id: AJAX.ajax_id,
        url: BASE_URL + AJAX.url,
        method: "post",
        data: AJAX.data,
        dataType: "json",
        beforeSend: function (ajax, ajaxQueue) {
            if (isObject(ajaxQueue) && "ajax_id" in ajaxQueue) {
                const AJAX = G.AJAX[Number(ajaxQueue.ajax_id)];
                Schnittstelle_AjaxRaus(AJAX);
            }
        },
        success: function (antwort) {
            if (isObject(antwort) && "ajax_id" in antwort) {
                const AJAX = G.AJAX[Number(antwort.ajax_id)];
                AJAX.antwort = antwort;
                Schnittstelle_AjaxReinErfolg(AJAX);
            }
        },
        error: function (xhr) {
            if (isObject(xhr) && "ajax_id" in xhr) {
                const AJAX = G.AJAX[Number(xhr.ajax_id)];
                AJAX.fehler = xhr;
                Schnittstelle_AjaxReinFehler(AJAX);
            }
        },
        complete: function (ajax) {
            if (isObject(ajax) && "responseJSON" in ajax && isObject(ajax.responseJSON) && "ajax_id" in ajax.responseJSON) {
                const AJAX = G.AJAX[Number(ajax.responseJSON.ajax_id)];
                Schnittstelle_AjaxRein(AJAX);
            }
        },
    };

    Schnittstelle_AjaxStatusSetzen(AJAX, AJAX_ZUSTAND.VORBEREITET);

    // $.ajaxQueue wird ausgeführt
    $.ajaxQueue(AJAX.ajaxQueue);
}
