function Schnittstelle_AjaxReinErfolg(AJAX) {
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
