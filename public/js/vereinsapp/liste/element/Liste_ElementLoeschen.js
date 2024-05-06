function Liste_ElementLoeschen($btn) {
    const liste = $btn.attr("data-liste");
    const element_id = Number($btn.attr("data-element_id"));

    if ($btn.hasClass("bestaetigung_einfordern")) {
        const data = { liste: liste, element_id: element_id };
        const weiterleiten = $btn.attr("data-weiterleiten");
        if (typeof weiterleiten !== "undefined") data.weiterleiten = weiterleiten;

        Schnittstelle_DomBestaetigungEinfordern(
            "Willst du " + Liste_ElementBeschriftungZurueck(element_id, liste) + " wirklich löschen?",
            $btn.attr("data-title"),
            G.LISTEN[liste].element + "_loeschen",
            data,
            $btn.attr("data-farbe")
        );
    } else {
        const AJAX_DATA = new Object();
        AJAX_DATA.id = element_id;

        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: G.LISTEN[liste].controller + "/ajax_" + G.LISTEN[liste].element + "_loeschen",
            data: AJAX_DATA,
            liste: liste,
            $btn: $btn,
            raus_aktion: function (AJAX) {
                Schnittstelle_BtnWartenStart(AJAX.$btn);
            },
            rein_validation_pos_aktion: function (AJAX) {
                // Beschriftung speichern, bevor Element gelöscht wird
                const beschriftung = Liste_ElementBeschriftungZurueck(AJAX.data.id, AJAX.liste);

                Schnittstelle_VariableLoeschen(AJAX.data.id, AJAX.liste);

                Schnittstelle_EventVariableUpdLocalstorage(AJAX.liste);

                const weiterleiten = AJAX.$btn.attr("data-weiterleiten");
                if (typeof weiterleiten !== "undefined") $(location).attr("href", BASE_URL + weiterleiten);
                else {
                    Schnittstelle_EventLocalstorageUpdVariable(AJAX.liste, [Schnittstelle_EventVariableUpdDom]);
                    Schnittstelle_DomModalSchliessen($("#" + G.LISTEN[AJAX.liste].element + "_loeschen_bestaetigung"));
                    Schnittstelle_DomToastFeuern(beschriftung + " wurde erfolgreich gelöscht.");
                }
            },
            rein_validation_neg_aktion: function (AJAX) {
                Schnittstelle_DomToastFeuern(Liste_ElementBeschriftungZurueck(AJAX.data.id, AJAX.liste) + " konnte nicht gelöscht werden.", "danger");
            },
            rein_aktion: function (AJAX) {
                Schnittstelle_BtnWartenEnde(AJAX.$btn);
            },
        };

        Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
    }
}
