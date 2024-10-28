function Notenbank_TitelAendern(formular_oeffnen, dom, data, title, titel_id) {
    if (typeof titel_id !== "undefined") titel_id = Number(titel_id);

    if (formular_oeffnen) {
        const $neues_modal = Schnittstelle_DomNeuesModalInitialisiertZurueck(title, "notenbank_basiseigenschaften");
        Liste_ElementFormularInitialisieren($neues_modal.find(".formular"), "aendern", titel_id, "notenbank");
        Schnittstelle_DomModalOeffnen($neues_modal);
    } else {
        if (!dom.$btn_ausloesend.hasClass("element")) Schnittstelle_BtnWartenStart(dom.$btn_ausloesend);

        const ajax_dom = dom;
        const ajax_data = data;
        ajax_data.id = titel_id;
        if (!("titel" in data)) data.titel = Schnittstelle_VariableRausZurueck("titel", titel_id, "notenbank");
        if (!("titel_nr" in data)) data.titel_nr = Schnittstelle_VariableRausZurueck("titel_nr", titel_id, "notenbank");
        if (!("kategorie" in data)) data.kategorie = Schnittstelle_VariableRausZurueck("kategorie", titel_id, "notenbank");
        if (!("bemerkung" in data)) data.bemerkung = Schnittstelle_VariableRausZurueck("bemerkung", titel_id, "notenbank");

        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "notenbank/ajax_titel_speichern",
            data: ajax_data,
            liste: "notenbank",
            dom: ajax_dom,
            rein_validation_pos_aktion: function (AJAX) {
                const titel_id = AJAX.data.id;
                $.each(AJAX.data, function (eigenschaft, wert) {
                    if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME) Schnittstelle_VariableRein(wert, eigenschaft, titel_id, "notenbank");
                });
                Schnittstelle_EventVariableUpdLocalstorage("notenbank", [
                    Schnittstelle_EventLocalstorageUpdVariable,
                    Schnittstelle_EventVariableUpdDom,
                ]);

                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists() && !dom.$btn_ausloesend.hasClass("element"))
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if ("dom" in AJAX && "$modal" in AJAX.dom && AJAX.dom.$modal.exists()) {
                    Schnittstelle_DomModalSchliessen(AJAX.dom.$modal);
                    Schnittstelle_DomToastFeuern(Liste_ElementBeschriftungZurueck(titel_id, "notenbank") + " wurde erfolgreich geändert.");
                }
            },
            rein_validation_neg_aktion: function (AJAX) {
                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists() && !dom.$btn_ausloesend.hasClass("element"))
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if ("dom" in AJAX && "$formular" in AJAX.dom && AJAX.dom.$formular.exists())
                    Liste_ElementFormularValidationAktualisieren(AJAX.dom.$formular, AJAX.antwort.validation);
                else
                    Schnittstelle_DomToastFeuern(
                        Liste_ElementBeschriftungZurueck(AJAX.data.id, "notenbank") + " konnte nicht gespeichert werden.",
                        "danger"
                    );
            },
        };

        Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
    }
}
