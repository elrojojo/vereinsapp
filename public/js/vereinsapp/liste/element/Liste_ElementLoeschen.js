function Liste_ElementLoeschen(data, element_id, liste) {
    if (typeof data === "undefined") data = new Object();

    if (!("bestaetigung_einfordern" in data)) data.bestaetigung_einfordern = false;
    const bestaetigung_einfordern = data.bestaetigung_einfordern;

    if (!("weiterleiten" in data)) data.weiterleiten = undefined;
    const weiterleiten = data.weiterleiten;

    if (!("title" in data)) data.title = "";
    const title = data.title;

    if (!("$btn_ausloesend" in data)) data.$btn_ausloesend = undefined;
    const $btn_ausloesend = data.$btn_ausloesend;

    if (!("$modal_ausloesend" in data)) data.$modal_ausloesend = undefined;
    const $modal_ausloesend = data.$modal_ausloesend;

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

        const ajax_dom_elemente = new Object();
        ajax_dom_elemente.$btn_ausloesend = $btn_ausloesend;
        ajax_dom_elemente.$modal_ausloesend = $modal_ausloesend;

        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: LISTEN[liste].controller + "/ajax_" + LISTEN[liste].element + "_loeschen",
            data: AJAX_DATA,
            liste: liste,
            dom_elemente: ajax_dom_elemente,
            rein_validation_pos_aktion: function (AJAX) {
                // Beschriftung speichern, bevor Element gelöscht wird
                const beschriftung = Liste_ElementBeschriftungZurueck(AJAX.data.id, AJAX.liste);

                Schnittstelle_VariableLoeschen(AJAX.data.id, AJAX.liste);

                Schnittstelle_EventVariableUpdLocalstorage(AJAX.liste);

                const weiterleiten = AJAX.data.weiterleiten;
                if (typeof weiterleiten !== "undefined") $(location).attr("href", BASE_URL + weiterleiten);
                else {
                    Schnittstelle_EventLocalstorageUpdVariable(AJAX.liste, [Schnittstelle_EventVariableUpdDom]);
                    Schnittstelle_BtnWartenEnde(AJAX.dom_elemente.$btn_ausloesend);
                    Schnittstelle_DomModalSchliessen(AJAX.dom_elemente.$modal_ausloesend);
                    Schnittstelle_DomToastFeuern(beschriftung + " wurde erfolgreich gelöscht.");
                }
            },
            rein_validation_neg_aktion: function (AJAX) {
                Schnittstelle_DomToastFeuern(Liste_ElementBeschriftungZurueck(AJAX.data.id, AJAX.liste) + " konnte nicht gelöscht werden.", "danger");
            },
        };

        Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
    }
}
