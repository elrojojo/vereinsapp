function Liste_ElementLoeschen(bestaetigung_einfordern, dom, data, title, element_id, liste) {
    if (typeof element_id !== "undefined") element_id = Number(element_id);

    if (bestaetigung_einfordern)
        Schnittstelle_DomBestaetigungEinfordern(
            "Willst du wirklich " + Liste_ElementBeschriftungZurueck(element_id, liste) + " löschen?",
            title,
            "btn_" + LISTEN[liste].element + "_loeschen",
            { liste: liste, element_id: element_id, weiterleiten: data.weiterleiten },
            "danger"
        );
    else {
        if (typeof dom.$btn_ausloesend !== "undefined" && !dom.$btn_ausloesend.hasClass("element")) Schnittstelle_BtnWartenStart(dom.$btn_ausloesend);

        const ajax_dom = dom;
        const ajax_data = data;
        ajax_data.id = element_id;

        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: LISTEN[liste].controller + "/ajax_" + LISTEN[liste].element + "_loeschen",
            data: ajax_data,
            liste: liste,
            dom: ajax_dom,
            rein_validation_pos_aktion: function (AJAX) {
                // Beschriftung speichern, bevor Element gelöscht wird
                const beschriftung = Liste_ElementBeschriftungZurueck(AJAX.data.id, AJAX.liste);

                Schnittstelle_VariableLoeschen(AJAX.data.id, AJAX.liste);

                Schnittstelle_EventVariableUpdLocalstorage(AJAX.liste);

                const weiterleiten = AJAX.data.weiterleiten;
                if (typeof weiterleiten !== "undefined") $(location).attr("href", SITE_URL + weiterleiten);
                else {
                    Schnittstelle_EventLocalstorageUpdVariable(AJAX.liste, [Schnittstelle_EventVariableUpdDom]);
                    if (
                        "dom" in AJAX &&
                        "$btn_ausloesend" in AJAX.dom &&
                        AJAX.dom.$btn_ausloesend.exists() &&
                        !dom.$btn_ausloesend.hasClass("element")
                    )
                        Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                    if ("dom" in AJAX && "$modal" in AJAX.dom && AJAX.dom.$modal.exists()) Schnittstelle_DomModalSchliessen(AJAX.dom.$modal);
                    Schnittstelle_DomToastFeuern(beschriftung + " wurde erfolgreich gelöscht.");
                }
            },
            rein_validation_neg_aktion: function (AJAX) {
                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists() && !dom.$btn_ausloesend.hasClass("element"))
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                Schnittstelle_DomToastFeuern(Liste_ElementBeschriftungZurueck(AJAX.data.id, AJAX.liste) + " konnte nicht gelöscht werden.", "danger");
            },
        };

        Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
    }
}
