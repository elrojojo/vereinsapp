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
            Schnittstelle_VariableLoeschen(AJAX.data.id, AJAX.liste);

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
