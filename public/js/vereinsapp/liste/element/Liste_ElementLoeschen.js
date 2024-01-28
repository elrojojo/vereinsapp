function Liste_ElementLoeschen($btn) {
    const liste = $btn.attr("data-liste");
    const element = G.LISTEN[liste].element;

    const neue_ajax_id = G.AJAX.length;
    G.AJAX[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        label: element + "_loeschen",
        url: G.LISTEN[liste].controller + "/ajax_" + element + "_loeschen",
        data: { id: Number($btn.attr("data-element_id")) },
        liste: liste,
        $btn: $btn,
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

            Schnittstelle_EventVariableUpdLocalstorage(AJAX.liste);

            const weiterleiten = AJAX.$btn.attr("data-weiterleiten");
            if (typeof weiterleiten !== "undefined") $(location).attr("href", BASE_URL + AJAX.liste);
            else {
                Schnittstelle_EventLocalstorageUpdVariable(AJAX.liste, [Schnittstelle_EventVariableUpdDom]);
                const $formular = AJAX.$btn.closest(".formular");
                $formular.modal("hide");
            }
        },
        rein_aktion: function (AJAX) {
            Schnittstelle_BtnWartenEnde(AJAX.$btn);
        },
    };

    Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
}
