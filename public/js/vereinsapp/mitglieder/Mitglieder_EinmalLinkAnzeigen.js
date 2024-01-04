function Mitglieder_EinmalLinkAnzeigen($btn) {
    const liste = $btn.attr("data-liste");

    const neue_ajax_id = G.AJAX.length;
    G.AJAX[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        label: "mitglied_einmal_link_anzeigen",
        url: G.LISTEN[liste].controller + "/ajax_mitglied_einmal_link_anzeigen",
        data: { id: Number($btn.attr("data-element_id")) },
        liste: liste,
        $btn: $btn,
        raus_aktion: function (AJAX) {
            Schnittstelle_BtnWartenStart(AJAX.$btn);
        },
        rein_validation_pos_aktion: function (AJAX) {
            const $formular = AJAX.$btn.closest(".formular");
            const $btn_dismiss = $formular.find(".btn[data-bs-dismiss]");
            const btn_dismiss_beschriftung = $btn_dismiss.text();

            $formular.find(".einmal_link").val(AJAX.antwort.einmal_link);
            $formular.find(".btn_mitglied_einmal_link_anzeigen").addClass("invisible");
            $btn_dismiss.attr("data-beschriftung", btn_dismiss_beschriftung);
            $btn_dismiss.removeClass("btn-outline-danger").addClass("btn-outline-primary").text("Schließen");

            Schnittstelle_EventVariableUpdLocalstorage(AJAX.liste, [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);
        },
        rein_aktion: function (AJAX) {
            Schnittstelle_BtnWartenEnde(AJAX.$btn);
        },
    };

    Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
}
