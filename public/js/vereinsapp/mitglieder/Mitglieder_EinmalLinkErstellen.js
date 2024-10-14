function Mitglieder_EinmalLinkErstellen(formular_oeffnen, bestaetigung_einfordern, dom, data, title, mitglied_id) {
    if (typeof mitglied_id !== "undefined") mitglied_id = Number(mitglied_id);

    if (bestaetigung_einfordern)
        Schnittstelle_DomBestaetigungEinfordern(
            "Willst du " + Liste_ElementBeschriftungZurueck(mitglied_id, "mitglieder") + " wirklich einen Einmal-Link per Email zuschicken?",
            title,
            "btn_mitglied_einmal_link_email",
            { liste: "mitglieder", element_id: mitglied_id }
        );
    else if (formular_oeffnen) {
        const $neues_modal = Schnittstelle_DomNeuesModalInitialisiertZurueck(title, "mitglieder_einmal_link_anzeigen");
        Liste_ElementFormularInitialisieren($neues_modal.find(".formular"), undefined, mitglied_id, "mitglieder");
        Schnittstelle_DomModalOeffnen($neues_modal);
    } else {
        Schnittstelle_BtnWartenStart(dom.$btn_ausloesend);

        const ajax_dom = dom;
        const ajax_data = data;
        ajax_data.id = mitglied_id;

        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "mitglieder/ajax_mitglied_einmal_link_erstellen",
            data: ajax_data,
            liste: "mitglieder",
            dom: ajax_dom,
            rein_validation_pos_aktion: function (AJAX) {
                Schnittstelle_EventVariableUpdLocalstorage("mitglieder", [
                    Schnittstelle_EventLocalstorageUpdVariable,
                    Schnittstelle_EventVariableUpdDom,
                ]);
                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if ("dom" in AJAX && "$modal" in AJAX.dom && AJAX.dom.$modal.exists()) Schnittstelle_DomModalSchliessen(AJAX.dom.$modal);
                if (AJAX.data.email)
                    Schnittstelle_DomToastFeuern(
                        "Einmal-Link für " +
                            Liste_ElementBeschriftungZurueck(AJAX.data.id, "mitglieder") +
                            " wurde erfolgreich per Email zugeschickt."
                    );
                else {
                    if ("dom" in AJAX && "$formular" in AJAX.dom && AJAX.dom.$formular.find(".einmal_link").exists())
                        AJAX.dom.$formular.find(".einmal_link").val(AJAX.antwort.einmal_link);
                    if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                        AJAX.dom.$btn_ausloesend.addClass("invisible");
                }
            },
            rein_validation_neg_aktion: function (AJAX) {
                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
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
        };

        Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
    }
}
