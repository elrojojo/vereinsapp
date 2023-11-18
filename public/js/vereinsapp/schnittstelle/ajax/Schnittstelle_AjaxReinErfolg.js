function Schnittstelle_AjaxReinErfolg(AJAX) {
    // CSRF-hash wird gespeichert
    G.CSRF[CSRF_NAME] = AJAX.antwort[CSRF_NAME];

    // Spezialfall login-view
    $('input[name="' + CSRF_NAME + '"]').val(G.CSRF[CSRF_NAME]);

    // WENN DIE VALIDATION FEHLSCHLÄGT
    if (typeof AJAX.antwort.validation !== "undefined") {
        console.log("FEHLER " + AJAX.label + ": validation -> " + JSON.stringify(AJAX.antwort.validation));

        if (typeof AJAX.rein_validation_neg_aktion === "function") AJAX.rein_validation_neg_aktion(AJAX);
    }

    // WENN DIE VALIDATION ERFOLGREICH DURCHLÄUFT
    else {
        if (typeof AJAX.antwort.info !== "undefined") console.log(JSON.stringify(AJAX.antwort.info));

        if (typeof AJAX.rein_validation_pos_aktion === "function") AJAX.rein_validation_pos_aktion(AJAX);
    }
}
