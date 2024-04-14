function Mitglieder_EinmalLinkEmail($btn) {
    const element_id = Number($btn.attr("data-element_id"));

    if ($btn.hasClass("bestaetigung_einfordern"))
        Schnittstelle_DomBestaetigungEinfordern(
            "Willst du " + Liste_ElementBeschriftungZurueck(element_id, "mitglieder") + " wirklich einen Einmal-Link per Email zuschicken?",
            $btn.attr("data-title"),
            "mitglied_einmal_link_email",
            { liste: "mitglieder", element_id: element_id, werte: JSON.stringify({ email: true }) }
        );
    else {
        const AJAX_DATA = new Object();
        AJAX_DATA.id = element_id;
        AJAX_DATA.email = true;

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
                Schnittstelle_EventVariableUpdLocalstorage("mitglieder", [
                    Schnittstelle_EventLocalstorageUpdVariable,
                    Schnittstelle_EventVariableUpdDom,
                ]);
                $("#mitglied_einmal_link_email_bestaetigung").modal("hide").remove();
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
            rein_aktion: function (AJAX) {
                Schnittstelle_BtnWartenEnde(AJAX.$btn);
            },
        };

        Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
    }
}
