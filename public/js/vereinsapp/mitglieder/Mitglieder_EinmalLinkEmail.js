function Mitglieder_EinmalLinkEmail($btn) {
    const element_id = Number($btn.attr("data-element_id"));

    if ($btn.hasClass("bestaetigung_einfordern"))
        Schnittstelle_DomBestaetigungEinfordern(
            "Willst du " + Liste_ElementBeschriftungZurueck(element_id, "mitglieder") + " wirklich einen Einmal-Link per Email zuschicken?",
            $btn.attr("data-title"),
            "btn_mitglied_einmal_link_email",
            { liste: "mitglieder", element_id: element_id, werte: JSON.stringify({ email: true }) }
        );
    else {
        Schnittstelle_BtnWartenStart($btn);

        const AJAX_DATA = new Object();
        AJAX_DATA.id = element_id;
        AJAX_DATA.email = true;

        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "mitglieder/ajax_mitglied_einmal_link_erstellen",
            data: AJAX_DATA,
            liste: "mitglieder",
            $btn: $btn,
            rein_validation_pos_aktion: function (AJAX) {
                Schnittstelle_EventVariableUpdLocalstorage("mitglieder", [
                    Schnittstelle_EventLocalstorageUpdVariable,
                    Schnittstelle_EventVariableUpdDom,
                ]);
                Schnittstelle_BtnWartenEnde(AJAX.$btn);
                Schnittstelle_DomModalSchliessen(AJAX.$btn.closest(".modal.bestaetigung"));
                Schnittstelle_DomToastFeuern(
                    "Einmal-Link für " + Liste_ElementBeschriftungZurueck(AJAX.data.id, "mitglieder") + " wurde erfolgreich per Email zugeschickt."
                );
            },
            rein_validation_neg_aktion: function (AJAX) {
                Schnittstelle_DomToastFeuern(
                    "Einmal-Link für " + Liste_ElementBeschriftungZurueck(AJAX.data.id, "mitglieder") + " konnte nicht per Email zugeschickt werden.",
                    "danger"
                );
            },
        };

        Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
    }
}
