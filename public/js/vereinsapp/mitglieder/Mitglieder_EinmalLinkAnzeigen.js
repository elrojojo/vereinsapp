function Mitglieder_EinmalLinkAnzeigen($btn) {
    const AJAX_DATA = new Object();
    AJAX_DATA.id = Number($btn.attr("data-element_id"));

    const neue_ajax_id = G.AJAX.length;
    G.AJAX[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        url: "mitglieder/ajax_mitglied_einmal_link_erstellen",
        data: AJAX_DATA,
        liste: "mitglieder",
        $btn: $btn,
        raus_aktion: function (AJAX) {
            Schnittstelle_BtnWartenStart(AJAX.$btn);
        },
        rein_validation_pos_aktion: function (AJAX) {
            const $formular = AJAX.$btn.closest(".formular");
            const $btn_dismiss = $formular.find(".btn[data-bs-dismiss]");

            $formular.find(".einmal_link").val(AJAX.antwort.einmal_link);
            $btn_dismiss.attr("data-beschriftung", $btn_dismiss.text());
            $btn_dismiss.removeClass("btn-outline-danger").addClass("btn-outline-primary").text("Schließen");

            Schnittstelle_EventVariableUpdLocalstorage("mitglieder", [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);
        },
        rein_validation_neg_aktion: function (AJAX) {
            Schnittstelle_DomToastFeuern(
                "Einmal-Link für " + Liste_ElementBeschriftungZurueck(AJAX.data.id, "mitglieder") + " konnte nicht erstellt werden.",
                "danger"
            );
        },
        rein_aktion: function (AJAX) {
            Schnittstelle_BtnWartenEnde(AJAX.$btn);
        },
    };

    Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
}
