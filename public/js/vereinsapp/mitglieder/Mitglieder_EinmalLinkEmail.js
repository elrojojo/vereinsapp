function Mitglieder_EinmalLinkEmail($btn) {
    const liste = $btn.attr("data-liste");

    const neue_ajax_id = G.AJAX.length;
    G.AJAX[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        label: "mitglied_einmal_link_email",
        url: G.LISTEN[liste].controller + "/ajax_mitglied_einmal_link_email",
        data: { id: Number($btn.attr("data-element_id")) },
        liste: liste,
        $btn: $btn,
        raus_aktion: function (AJAX) {
            Schnittstelle_BtnWartenStart(AJAX.$btn);
        },
        rein_validation_pos_aktion: function (AJAX) {
            /* todo */
            console.log("link zugeschickt.");

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
