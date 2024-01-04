function Mitglieder_EinmalLinkEmail($btn) {
    const liste = $btn.attr("data-liste");
    const element = G.LISTEN[liste].element;

    const neue_ajax_id = G.AJAX.length;
    G.AJAX[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        label: element + "_einmal_link_email",
        url: G.LISTEN[liste].controller + "/ajax_" + element + "_einmal_link_email",
        data: { id: Number($btn.attr("data-element_id")), email: $btn.attr("data-email") },
        liste: liste,
        $btn: $btn,
        raus_aktion: function (AJAX) {
            Schnittstelle_BtnWartenStart(AJAX.$btn);
        },
        rein_validation_pos_aktion: function (AJAX) {
            /* todo */
            console.log("link verschickt.");

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
