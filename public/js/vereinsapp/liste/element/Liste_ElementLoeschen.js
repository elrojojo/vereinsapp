function Liste_ElementLoeschen(bestaetigung_einfordern, weiterleiten, title, $btn_ausloesend, $bestaetigung, element_id, liste) {
    if (bestaetigung_einfordern)
        Schnittstelle_DomBestaetigungEinfordern(
            "Willst du " + Liste_ElementBeschriftungZurueck(element_id, liste) + " wirklich löschen?",
            title,
            "btn_" + LISTEN[liste].element + "_loeschen",
            { liste: liste, element_id: element_id, weiterleiten: weiterleiten },
            "danger"
        );
    else {
        if (typeof $btn_ausloesend !== "undefined") Schnittstelle_BtnWartenStart($btn_ausloesend);

        const AJAX_DATA = new Object();
        AJAX_DATA.id = element_id;
        AJAX_DATA.weiterleiten = weiterleiten;

        const ajax_dom = new Object();
        ajax_dom.$btn_ausloesend = $btn_ausloesend;
        ajax_dom.$bestaetigung = $bestaetigung;

        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: LISTEN[liste].controller + "/ajax_" + LISTEN[liste].element + "_loeschen",
            data: AJAX_DATA,
            liste: liste,
            dom: ajax_dom,
            rein_validation_pos_aktion: function (AJAX) {
                // Beschriftung speichern, bevor Element gelöscht wird
                const beschriftung = Liste_ElementBeschriftungZurueck(AJAX.data.id, AJAX.liste);

                Schnittstelle_VariableLoeschen(AJAX.data.id, AJAX.liste);

                Schnittstelle_EventVariableUpdLocalstorage(AJAX.liste);

                const weiterleiten = AJAX.data.weiterleiten;
                if (typeof weiterleiten !== "undefined") $(location).attr("href", BASE_URL + weiterleiten);
                else {
                    Schnittstelle_EventLocalstorageUpdVariable(AJAX.liste, [Schnittstelle_EventVariableUpdDom]);
                    if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                        Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                    if ("dom" in AJAX && "$bestaetigung" in AJAX.dom && AJAX.dom.$bestaetigung.exists())
                        Schnittstelle_DomModalSchliessen(AJAX.dom.$bestaetigung);
                    Schnittstelle_DomToastFeuern(beschriftung + " wurde erfolgreich gelöscht.");
                }
            },
            rein_validation_neg_aktion: function (AJAX) {
                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                Schnittstelle_DomToastFeuern(Liste_ElementBeschriftungZurueck(AJAX.data.id, AJAX.liste) + " konnte nicht gelöscht werden.", "danger");
            },
        };

        Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
    }
}
