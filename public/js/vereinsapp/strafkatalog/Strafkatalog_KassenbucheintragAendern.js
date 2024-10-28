function Strafkatalog_KassenbucheintragAendern(formular_oeffnen, dom, data, title, kassenbucheintrag_id) {
    if (typeof kassenbucheintrag_id !== "undefined") kassenbucheintrag_id = Number(kassenbucheintrag_id);

    if (formular_oeffnen) {
        const $neues_modal = Schnittstelle_DomNeuesModalInitialisiertZurueck(title, "kassenbuch_basiseigenschaften");
        Liste_ElementFormularInitialisieren($neues_modal.find(".formular"), "aendern", kassenbucheintrag_id, "kassenbuch");
        Schnittstelle_DomModalOeffnen($neues_modal);
    } else {
        if (!dom.$btn_ausloesend.hasClass("element")) Schnittstelle_BtnWartenStart(dom.$btn_ausloesend);

        const ajax_dom = dom;
        const ajax_data = data;
        ajax_data.id = kassenbucheintrag_id;
        if (!("titel" in data)) data.titel = Schnittstelle_VariableRausZurueck("titel", kassenbucheintrag_id, "kassenbuch");
        if (!("wert" in data)) data.wert = Schnittstelle_VariableRausZurueck("wert", kassenbucheintrag_id, "kassenbuch");
        if (!("mitglied_id" in ajax_data))
            ajax_data.mitglied_id = Schnittstelle_VariableRausZurueck("mitglied_id", kassenbucheintrag_id, "kassenbuch");
        if ("erledigt" in data && typeof data.erledigt === "undefined") data.erledigt = null;
        if (!("bemerkung" in data)) data.bemerkung = Schnittstelle_VariableRausZurueck("bemerkung", kassenbucheintrag_id, "kassenbuch");

        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "strafkatalog/ajax_kassenbucheintrag_speichern",
            data: ajax_data,
            liste: "kassenbuch",
            dom: ajax_dom,
            rein_validation_pos_aktion: function (AJAX) {
                const kassenbucheintrag_id = AJAX.data.id;
                $.each(AJAX.data, function (eigenschaft, wert) {
                    if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME)
                        Schnittstelle_VariableRein(wert, eigenschaft, kassenbucheintrag_id, "kassenbuch");
                });
                Schnittstelle_EventVariableUpdLocalstorage("kassenbuch", [
                    Schnittstelle_EventLocalstorageUpdVariable,
                    Schnittstelle_EventVariableUpdDom,
                ]);

                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists() && !dom.$btn_ausloesend.hasClass("element"))
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if ("dom" in AJAX && "$modal" in AJAX.dom && AJAX.dom.$modal.exists()) {
                    Schnittstelle_DomModalSchliessen(AJAX.dom.$modal);
                    Schnittstelle_DomToastFeuern(
                        Liste_ElementBeschriftungZurueck(kassenbucheintrag_id, "kassenbuch") + " wurde erfolgreich geändert."
                    );
                }
            },
            rein_validation_neg_aktion: function (AJAX) {
                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists() && !dom.$btn_ausloesend.hasClass("element"))
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if ("dom" in AJAX && "$formular" in AJAX.dom && AJAX.dom.$formular.exists())
                    Liste_ElementFormularValidationAktualisieren(AJAX.dom.$formular, AJAX.antwort.validation);
                else
                    Schnittstelle_DomToastFeuern(
                        Liste_ElementBeschriftungZurueck(AJAX.data.id, "kassenbuch") + " konnte nicht gespeichert werden.",
                        "danger"
                    );
            },
        };

        Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
    }
}
