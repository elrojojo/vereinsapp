function Mitglieder_EinmalLinkErstellen($btn) {
    const element_id = Number($btn.attr("data-element_id"));

    if (!$btn.hasClass("btn_bestaetigen") && $btn.hasClass("btn_mitglied_einmal_link_email")) {
        const data = { liste: "mitglieder", element_id: element_id, werte: JSON.stringify({ email: true }) };
        Schnittstelle_DomBestaetigungEinfordern(
            "Willst du " + Liste_ElementBeschriftungZurueck(data.element_id, "mitglieder") + " wirklich einen Einmal-Link per Email zuschicken?",
            $btn.attr("data-title"),
            "btn_mitglied_einmal_link_email",
            data
        );
    } else {
        const AJAX_DATA = new Object();
        AJAX_DATA.id = element_id;

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
                if (AJAX.data.email) {
                    Schnittstelle_EventVariableUpdLocalstorage("mitglieder", [
                        Schnittstelle_EventLocalstorageUpdVariable,
                        Schnittstelle_EventVariableUpdDom,
                    ]);

                    AJAX.$btn.closest(".bestaetigung").modal("hide").remove();
                    Schnittstelle_DomToastFeuern(
                        "Einmal-Link für " +
                            Liste_ElementBeschriftungZurueck(AJAX.data.id, "mitglieder") +
                            " wurde erfolgreich per Email zugeschickt."
                    );
                } else {
                    const $formular = AJAX.$btn.closest(".formular");
                    const $btn_dismiss = $formular.find(".btn[data-bs-dismiss]");
                    const btn_dismiss_beschriftung = $btn_dismiss.text();

                    $formular.find(".einmal_link").val(AJAX.antwort.einmal_link);
                    // $formular.find(".btn_mitglied_einmal_link_anzeigen").addClass("invisible");
                    $btn_dismiss.attr("data-beschriftung", btn_dismiss_beschriftung);
                    $btn_dismiss.removeClass("btn-outline-danger").addClass("btn-outline-primary").text("Schließen");

                    Schnittstelle_EventVariableUpdLocalstorage("mitglieder", [
                        Schnittstelle_EventLocalstorageUpdVariable,
                        Schnittstelle_EventVariableUpdDom,
                    ]);
                }
            },
            rein_validation_neg_aktion: function (AJAX) {
                if (AJAX.data.email)
                    Schnittstelle_DomToastFeuern(
                        "Einmal-Link für " +
                            Liste_ElementBeschriftungZurueck(AJAX.data.id, "mitglieder") +
                            " konnte nicht per Email zugeschickt werden.",
                        "danger"
                    );
                else
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
}
