function Schnittstelle_AjaxReinErfolg(AJAX) {
    console.log(AJAX.id, G.AJAX);

    // CSRF-hash wird gespeichert
    G.CSRF[CSRF_NAME] = AJAX.antwort[CSRF_NAME];

    // Spezialfall login-view
    $('input[name="' + CSRF_NAME + '"]').val(G.CSRF[CSRF_NAME]);

    // WENN DIE VALIDATION FEHLSCHLÄGT
    if (typeof AJAX.antwort.validation !== "undefined") {
        console.log("FEHLER " + AJAX.id + ": validation -> " + JSON.stringify(AJAX.antwort.validation));
        AJAX.validation_negativ_aktion(AJAX);
    }

    // WENN DIE VALIDATION ERFOLGREICH DURCHLÄUFT
    else {
        if (typeof AJAX.antwort.info !== "undefined") console.log(JSON.stringify(AJAX.antwort.info));
        AJAX.validation_positiv_aktion(AJAX);
    }
}
