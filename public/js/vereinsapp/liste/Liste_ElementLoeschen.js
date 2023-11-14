function Liste_ElementLoeschen($btn, liste) {
    const element = $btn.attr("data-element");

    const neue_ajax_id = G.AJAX.length;
    G.AJAX[neue_ajax_id] = {
        id: element + "_loeschen",
        url: LISTEN[liste].controller + "/ajax_" + element + "_loeschen",
        data: { id: $btn.attr("data-element_id") },
        liste: liste,
        DOM: { $btn: $btn, btn_beschriftung: $btn.html() },
        raus_aktion: function (AJAX) {
            AJAX.DOM.$btn.html(STATUS_SPINNER_HTML).prop("disabled", true);
        },
        rein_validation_pos_aktion: function (AJAX) {
            delete LISTEN[AJAX.liste].tabelle[AJAX.data.id];
            $(document).trigger("VAR_upd_LOC", [AJAX.liste]); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR' );

            const $formular = AJAX.DOM.$btn.parents(".formular").first();
            $formular.modal("hide");
        },
        rein_aktion: function (AJAX) {
            AJAX.DOM.$btn.html(AJAX.DOM.btn_beschriftung).prop("disabled", false);
        },
    };

    Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
}
