function Liste_ElementLoeschen($btn, liste) {
    const element = $btn.attr("data-element");

    const neue_ajax_id = G.AJAX.length;
    G.AJAX[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        label: element + "_loeschen",
        url: G.LISTEN[liste].controller + "/ajax_" + element + "_loeschen",
        data: { id: $btn.attr("data-element_id") },
        liste: liste,
        $btn: $btn,
        warten_auf: neue_ajax_id,
        raus_aktion: function (AJAX) {
            Schnittstelle_BtnWartenStart(AJAX.$btn);
        },
        rein_validation_pos_aktion: function (AJAX) {
            delete G.LISTEN[AJAX.liste].tabelle[AJAX.data.id];

            if ("verlinkte_listen" in G.LISTEN[AJAX.liste])
                $.each(G.LISTEN[liste].verlinkte_listen, function (prio, verlinkte_liste) {
                    $.each(G.LISTEN[verlinkte_liste].tabelle, function () {
                        const element = this;
                        if (
                            "id" in element &&
                            G.LISTEN[AJAX.liste].element + "_id" in element &&
                            element[G.LISTEN[AJAX.liste].element + "_id"] == AJAX.data.id
                        )
                            delete G.LISTEN[verlinkte_liste].tabelle[element.id];
                    });
                });

            Schnittstelle_EventVariableUpdLocalstorage(AJAX.liste, [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);

            const $formular = AJAX.$btn.closest(".formular");
            $formular.modal("hide");
        },
        rein_aktion: function (AJAX) {
            Schnittstelle_BtnWartenEnde(AJAX.$btn);
        },
    };

    Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
}
