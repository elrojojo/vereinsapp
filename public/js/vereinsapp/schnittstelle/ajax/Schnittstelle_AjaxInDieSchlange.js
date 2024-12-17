function Schnittstelle_AjaxInDieSchlange(url, data, dom, rein_validation_pos_aktion, rein_validation_neg_aktion) {
    const neue_ajax_id = AJAXSCHLANGE.length;
    AJAXSCHLANGE[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        data: data,
        dom: dom,
        rein_validation_pos_aktion: rein_validation_pos_aktion,
        rein_validation_neg_aktion: rein_validation_neg_aktion,
    };

    const data_ajaxQueue = objektKopiertZurueck(data);
    if ("folgendes_event" in data_ajaxQueue) data_ajaxQueue.folgendes_event = undefined;

    // Das Objekt für $.ajaxQueue wird erstellt
    AJAXSCHLANGE[neue_ajax_id].ajaxQueue = {
        ajax_id: neue_ajax_id, // ToDo: benötigt für 'ajaxOpts.data.ajax_id = ajaxOpts.ajax_id'?
        url: SITE_URL + url,
        method: "post",
        data: data_ajaxQueue, // ToDo: Objekt kopieren?
        dataType: "json",
        beforeSend: function () {},
        success: function (antwort) {
            if (isObject(antwort) && "ajax_id" in antwort) {
                const AJAX = AJAXSCHLANGE[Number(antwort.ajax_id)];

                // antwort wird in der AJAXSCHLANGE gespeichert
                AJAX.antwort = antwort;

                // CSRF-hash wird gespeichert
                CSRF[CSRF_NAME] = AJAX.antwort[CSRF_NAME];

                // Spezialfall login-view
                $('input[name="' + CSRF_NAME + '"]').val(CSRF[CSRF_NAME]);

                if ("info" in AJAX.antwort) Schnittstelle_LogInDieKonsole("INFO", JSON.stringify(AJAX.antwort.info));

                // WENN DIE VALIDATION FEHLSCHLÄGT
                if ("validation" in AJAX.antwort) {
                    if (typeof AJAX.rein_validation_neg_aktion === "function") AJAX.rein_validation_neg_aktion(AJAX);
                }

                // WENN DIE VALIDATION ERFOLGREICH DURCHLÄUFT
                else {
                    if (typeof AJAX.rein_validation_pos_aktion === "function") AJAX.rein_validation_pos_aktion(AJAX);
                }
            }
        },
        error: function (xhr) {
            Schnittstelle_LogInDieKonsole("FEHLER", xhr.status, xhr.statusText, xhr);
        },
        complete: function () {},
    };

    // $.ajaxQueue wird ausgeführt // ToDo: AJAXSCHLANGE[neue_ajax_id].ajaxQueue-Objekt direkt als Argument übergeben
    $.ajaxQueue(AJAXSCHLANGE[neue_ajax_id].ajaxQueue);
}
