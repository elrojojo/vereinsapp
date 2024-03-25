function Mitglieder_EinmalLinkErstellen($btn) {
    const liste = $btn.attr("data-liste");
    const element_id = $btn.attr("data-element_id");
    const data_werte = $btn.attr("data-werte");

    if (!$btn.hasClass("btn_bestaetigen") && $btn.hasClass("btn_mitglied_einmal_link_email")) {
        const data = { liste: $btn.attr("data-liste"), element_id: $btn.attr("data-element_id"), werte: JSON.stringify({ email: true }) };
        if (typeof data_werte !== "undefined")
            $.each(JSON.parse(data_werte), function (eigenschaft, wert) {
                data[eigenschaft] = wert;
            });

        Schnittstelle_DomBestaetigungEinfordern(
            "Willst du " + Liste_ElementBeschriftungZurueck(data.element_id, data.liste) + " wirklich einen Einmal-Link per Email zuschicken?",
            $btn.attr("data-title"),
            "btn_mitglied_einmal_link_email",
            data
        );
    } else {
        const AJAX_DATA = new Object();
        if (typeof element_id !== "undefined") AJAX_DATA.id = Number(element_id);
        if (typeof data_werte !== "undefined")
            $.each(JSON.parse(data_werte), function (eigenschaft, wert) {
                AJAX_DATA[eigenschaft] = wert;
            });

        const neue_ajax_id = G.AJAX.length;
        G.AJAX[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            label: "mitglied_einmal_link_erstellen",
            url: G.LISTEN[liste].controller + "/ajax_mitglied_einmal_link_erstellen",
            data: AJAX_DATA,
            liste: liste,
            $btn: $btn,
            raus_aktion: function (AJAX) {
                Schnittstelle_BtnWartenStart(AJAX.$btn);
            },
            rein_validation_pos_aktion: function (AJAX) {
                if (AJAX.data.email) {
                    Schnittstelle_EventVariableUpdLocalstorage(AJAX.liste, [
                        Schnittstelle_EventLocalstorageUpdVariable,
                        Schnittstelle_EventVariableUpdDom,
                    ]);

                    AJAX.$btn.closest(".bestaetigung").modal("hide").remove();
                } else {
                    const $formular = AJAX.$btn.closest(".formular");
                    const $btn_dismiss = $formular.find(".btn[data-bs-dismiss]");
                    const btn_dismiss_beschriftung = $btn_dismiss.text();

                    $formular.find(".einmal_link").val(AJAX.antwort.einmal_link);
                    $formular.find(".btn_mitglied_einmal_link_anzeigen").addClass("invisible");
                    $btn_dismiss.attr("data-beschriftung", btn_dismiss_beschriftung);
                    $btn_dismiss.removeClass("btn-outline-danger").addClass("btn-outline-primary").text("Schließen");

                    Schnittstelle_EventVariableUpdLocalstorage(AJAX.liste, [
                        Schnittstelle_EventLocalstorageUpdVariable,
                        Schnittstelle_EventVariableUpdDom,
                    ]);
                }
            },
            rein_aktion: function (AJAX) {
                Schnittstelle_BtnWartenEnde(AJAX.$btn);
            },
        };

        Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
    }
}
