function Mitglieder_EinmalLinkErstellen(formular_oeffnen, bestaetigung_einfordern, dom, data, title, mitglied_id) {
    if (typeof mitglied_id !== "undefined") mitglied_id = Number(mitglied_id);

    if (bestaetigung_einfordern)
        Schnittstelle_DomBestaetigungEinfordern(
            "Willst du " + Liste_ElementBeschriftungZurueck(mitglied_id, "mitglieder") + " wirklich einen Einmal-Link per Email zuschicken?",
            title,
            "btn_mitglied_einmal_link_email",
            { liste: "mitglieder", element_id: mitglied_id }
        );
    else if (formular_oeffnen)
        Schnittstelle_DomModalOeffnen(
            Liste_ElementFormularInitialisiertZurueck("einmal_link_anzeigen", "mitglieder", {
                title: title,
                element_id: mitglied_id,
            })
        );
    else {
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
                if ("dom" in AJAX && "$bestaetigung" in AJAX.dom && AJAX.dom.$bestaetigung.exists())
                    Schnittstelle_DomModalSchliessen(AJAX.dom.$bestaetigung);
                if (AJAX.data.email)
                    Schnittstelle_DomToastFeuern(
                        "Einmal-Link für " +
                            Liste_ElementBeschriftungZurueck(AJAX.data.id, "mitglieder") +
                            " wurde erfolgreich per Email zugeschickt."
                    );
                else {
                    if ("dom" in AJAX && "$einmal_link" in AJAX.dom && AJAX.dom.$einmal_link.exists())
                        AJAX.dom.$einmal_link.val(AJAX.antwort.einmal_link);
                    if ("dom" in AJAX && "$btn_dismiss" in AJAX.dom && AJAX.dom.$btn_dismiss.exists())
                        AJAX.dom.$btn_dismiss
                            .attr("data-beschriftung", AJAX.dom.$btn_dismiss.text())
                            .removeClass("btn-outline-danger")
                            .addClass("btn-outline-primary")
                            .text("Schließen");
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
