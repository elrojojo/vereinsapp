function Schnittstelle_AjaxRaus(AJAXDATA) {
    if (typeof AJAXDATA.data === "undefined") AJAXDATA.data = {};
    AJAXDATA.data[CSRF_NAME] = G.CSRF_HASH;

    const AJAXQUEUE = {
        url: BASE_URL + AJAXDATA.url,
        method: "post",
        data: AJAXDATA.data,
        dataType: "json",
        beforeSend: AJAXDATA.vorher_aktion,
        success: function (antwort) {
            G.AJAX[AJAXDATA.id] = antwort;
            G.CSRF_HASH = antwort.csrf_hash;
            $("#csrf_hash").val(antwort.csrf_hash); // nur übergangsweise

            // WENN DIE VALIDATION FEHLSCHLÄGT
            if (typeof antwort.validation !== "undefined") {
                console.log("FEHLER " + AJAXDATA.id + ": validation -> " + JSON.stringify(antwort.validation));
                AJAXDATA.validation_negativ_aktion();
            }

            // WENN DIE VALIDATION ERFOLGREICH DURCHLÄUFT
            else {
                if (typeof antwort.info !== "undefined") console.log(JSON.stringify(antwort.info)); //console.log( 'ERFOLG '+element+' '+aktion );
                AJAXDATA.validation_positiv_aktion();
            }
        },
        error: function (xhr) {
            console.log("FEHLER " + AJAXDATA.id + ": " + xhr.status + " " + xhr.statusText);
        },
        complete: AJAXDATA.nachher_aktion,
    };

    $.ajaxQueue(AJAXQUEUE);
}
