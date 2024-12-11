function Schnittstelle_AjaxInDieSchlange(AJAX) {
    // Manchmal ist das data-Objekt nicht notwendig, dann wird es als leeres Objekt definiert
    if (!isObject(AJAX.data)) AJAX.data = new Object();

    // Das Objekt für $.ajaxQueue wird erstellt
    AJAX.ajaxQueue = {
        ajax_id: AJAX.ajax_id,
        url: SITE_URL + AJAX.url,
        method: "post",
        data: AJAX.data,
        dataType: "json",
        beforeSend: function (ajax, ajaxQueue) {
            if (isObject(ajaxQueue) && "ajax_id" in ajaxQueue) Schnittstelle_AjaxRaus(AJAXSCHLANGE[Number(ajaxQueue.ajax_id)]);
        },
        success: function (antwort) {
            if (isObject(antwort) && "ajax_id" in antwort) {
                const AJAX = AJAXSCHLANGE[Number(antwort.ajax_id)];
                AJAX.antwort = antwort;
                Schnittstelle_AjaxReinErfolg(AJAX);
            }
        },
        error: function (xhr) {
            if (isObject(xhr) && "ajax_id" in xhr) {
                const AJAX = AJAXSCHLANGE[Number(xhr.ajax_id)];
                AJAX.fehler = xhr;
                Schnittstelle_AjaxReinFehler(AJAX);
            }
        },
        complete: function (ajax) {
            if (isObject(ajax) && "responseJSON" in ajax && isObject(ajax.responseJSON) && "ajax_id" in ajax.responseJSON)
                Schnittstelle_AjaxRein(AJAXSCHLANGE[Number(ajax.responseJSON.ajax_id)]);
        },
    };

    // $.ajaxQueue wird ausgeführt
    $.ajaxQueue(AJAX.ajaxQueue);
}
