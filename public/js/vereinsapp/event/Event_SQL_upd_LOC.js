// LOC VOM SERVER AKTUALISIEREN
$(document).on("Event_SQL_upd_LOC", async function (event, schleife, liste) {
    if (typeof schleife === "undefined") schleife = false;
    const neue_ajax_id = G.AJAX.length;

    G.AJAX[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        label: "SQL_upd_LOC_" + liste,
        url: LISTEN[liste].controller + "/ajax_" + liste,
        // data: { hash: sha256(String(Schnittstelle_GibLocalstorageRaus(liste + "_tabelle"))), },
        liste: liste,
        schleife: { schalter: schleife, event: "Event_SQL_upd_LOC" },
        rein_validation_pos_aktion: function (AJAX) {
            Schnittstelle_LocalstorageRein(AJAX.liste + "_tabelle", JSON.stringify(AJAX.antwort.tabelle));
        },
        rein_aktion: function (AJAX) {
            $(document).trigger("LOC_upd_VAR", [AJAX.liste]); // impliziert auch ein $(document).trigger( 'VAR_upd_DOM', [ liste ] );
        },
    };

    Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
});
