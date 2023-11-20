function Event_SqlUpdLocalstorage(liste, schleife) {
    const neue_ajax_id = G.AJAX.length;
    G.AJAX[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        label: "SqlUpdLocalstorage " + liste,
        url: G.LISTEN[liste].controller + "/ajax_" + liste,
        // data: { hash: sha256(String(Schnittstelle_GibLocalstorageRaus(liste + "_tabelle"))), },
        liste: liste,
        rein_validation_pos_aktion: function (AJAX) {
            Schnittstelle_LocalstorageRein(AJAX.liste + "_tabelle", JSON.stringify(AJAX.antwort.tabelle));
        },
        rein_aktion: function (AJAX) {
            $(document).trigger("LOC_upd_VAR", [AJAX.liste]); // impliziert auch ein $(document).trigger( 'VAR_upd_DOM', [ liste ] );
        },
    };

    if (schleife) G.AJAX[neue_ajax_id].schleife = Event_SqlUpdLocalstorage;

    Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
}
