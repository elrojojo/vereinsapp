function Schnittstelle_EventSqlUpdLocalstorage(liste, schleife, naechste_aktionen) {
    if (!Array.isArray(naechste_aktionen)) naechste_aktionen = new Array();

    // AJAX wird vorbereitet
    const neue_ajax_id = G.AJAX.length;
    G.AJAX[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        label: "SqlUpdLocalstorage " + liste,
        url: G.LISTEN[liste].controller + "/ajax_" + liste,
        // data: { hash: sha256(String(Schnittstelle_LocalstorageRausZurueck(liste + "_tabelle"))), },
        liste: liste,
        naechste_aktionen: naechste_aktionen,
        rein_validation_pos_aktion: function (AJAX) {
            Schnittstelle_LocalstorageRein(AJAX.liste + "_tabelle", JSON.stringify(AJAX.antwort.tabelle));
            Schnittstelle_NaechsteAktion(liste, AJAX.naechste_aktionen);
        },
    };

    // Falls die Funktion ein weiteres Mal durchgeführt werden soll ("Schleife"), dann wird die Funktion entsprechend übergeben
    if (schleife) G.AJAX[neue_ajax_id].schleife = Schnittstelle_EventSqlUpdLocalstorage;

    // AJAX wird in die Schlange mitaufgenommen
    Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
}
