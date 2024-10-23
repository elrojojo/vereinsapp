function Schnittstelle_AjaxReinErfolg(AJAX) {
    // CSRF-hash wird gespeichert
    CSRF[CSRF_NAME] = AJAX.antwort[CSRF_NAME];

    // Spezialfall login-view
    $('input[name="' + CSRF_NAME + '"]').val(CSRF[CSRF_NAME]);

    if (AJAX.warten_auf == AJAX.ajax_id) ReinErfolg(AJAX);
    else if (Array.isArray(AJAX.warten_auf)) {
        $.each(AJAX.warten_auf, function (prio, ajax_id) {
            const AJAX = AJAXSCHLANGE[Number(ajax_id)];
            ReinErfolg(AJAX);
        });
        ReinErfolg(AJAX);
    } else {
        Schnittstelle_AjaxStatusSetzen(AJAX, AJAX_ZUSTAND.WARTEND);
    }

    function ReinErfolg(AJAX) {
        // AJAX.data wird entsprechend den Einträgen in AJAX.data_original zurückgesetzt
        $.each(AJAX.data_original, function (eigenschaft, wert) {
            AJAX.data[eigenschaft] = wert;
            delete AJAX.data_original[eigenschaft];
        });

        // WENN DIE VALIDATION FEHLSCHLÄGT
        if ("validation" in AJAX.antwort) {
            if (typeof AJAX.rein_validation_neg_aktion === "function") AJAX.rein_validation_neg_aktion(AJAX);
        }

        // WENN DIE VALIDATION ERFOLGREICH DURCHLÄUFT
        else {
            if ("info" in AJAX.antwort) console.log("INFO", JSON.stringify(AJAX.antwort.info));

            if (typeof AJAX.rein_validation_pos_aktion === "function") AJAX.rein_validation_pos_aktion(AJAX);
        }

        Schnittstelle_AjaxStatusSetzen(AJAX, AJAX_ZUSTAND.FERTIG);
    }
}
