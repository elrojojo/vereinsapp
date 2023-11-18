function Liste_ElementLoeschen($btn, liste) {
    const element = $btn.attr("data-element");

    const neue_ajax_id = G.AJAX.length;
    G.AJAX[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        label: element + "_loeschen",
        url: LISTEN[liste].controller + "/ajax_" + element + "_loeschen",
        data: { id: $btn.attr("data-element_id") },
        liste: liste,
        $btn: $btn,
        raus_aktion: function (AJAX) {
            Schnittstelle_BtnWartenStart(AJAX.$btn);
        },
        rein_validation_pos_aktion: function (AJAX) {
            delete LISTEN[AJAX.liste].tabelle[AJAX.data.id];
            $(document).trigger("VAR_upd_LOC", [AJAX.liste]); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR' );

            const $formular = AJAX.$btn.parents(".formular").first();
            $formular.modal("hide");
        },
        rein_aktion: function (AJAX) {
            Schnittstelle_BtnWartenEnde(AJAX.$btn);
        },
    };

    Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
}
