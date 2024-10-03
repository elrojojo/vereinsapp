function Termine_TerminAendern(formular_oeffnen, dom, data, title, termin_id) {
    if (typeof termin_id !== "undefined") termin_id = Number(termin_id);

    if (formular_oeffnen) {
        const $neues_modal = Schnittstelle_DomNeuesModalInitialisiertZurueck(title, "termine_basiseigenschaften");
        Liste_ElementFormularInitialisieren($neues_modal.find(".formular"), "aendern", termin_id, "termine");
        Schnittstelle_DomModalOeffnen($neues_modal);
    } else {
        Schnittstelle_BtnWartenStart(dom.$btn_ausloesend);

        const ajax_dom = dom;
        const ajax_data = data;
        ajax_data.id = termin_id;
        if (!("titel" in data)) data.titel = Schnittstelle_VariableRausZurueck("titel", termin_id, "termine");
        if (!("start" in data)) data.start = Schnittstelle_VariableRausZurueck("start", termin_id, "termine").toISO();
        if (!("ort" in data)) data.ort = Schnittstelle_VariableRausZurueck("ort", termin_id, "termine");
        if (!("kategorie" in data)) data.kategorie = Schnittstelle_VariableRausZurueck("kategorie", termin_id, "termine");
        if (!("filtern_mitglieder" in data)) data.filtern_mitglieder = Schnittstelle_VariableRausZurueck("filtern_mitglieder", termin_id, "termine");
        if (!("bemerkung" in data)) data.bemerkung = Schnittstelle_VariableRausZurueck("bemerkung", termin_id, "termine");

        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "termine/ajax_termin_speichern",
            data: ajax_data,
            liste: "termine",
            dom: ajax_dom,
            rein_validation_pos_aktion: function (AJAX) {
                const termin_id = AJAX.data.id;
                $.each(AJAX.data, function (eigenschaft, wert) {
                    if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME) Schnittstelle_VariableRein(wert, eigenschaft, termin_id, "termine");
                });
                Schnittstelle_EventVariableUpdLocalstorage("termine", [
                    Schnittstelle_EventLocalstorageUpdVariable,
                    Schnittstelle_EventVariableUpdDom,
                ]);

                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if ("dom" in AJAX && "$modal" in AJAX.dom && AJAX.dom.$modal.exists()) {
                    Schnittstelle_DomModalSchliessen(AJAX.dom.$modal);
                    Schnittstelle_DomToastFeuern(Liste_ElementBeschriftungZurueck(termin_id, "termine") + " wurde erfolgreich geändert.");
                }
            },
            rein_validation_neg_aktion: function (AJAX) {
                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if ("dom" in AJAX && "$formular" in AJAX.dom && AJAX.dom.$formular.exists())
                    Liste_ElementFormularValidationAktualisieren(AJAX.dom.$formular, AJAX.antwort.validation);
                else Schnittstelle_DomToastFeuern(Liste_ElementBeschriftungZurueck(AJAX.data.id, "termine") + " konnte nicht gespeichert werden.");
            },
        };

        Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
    }
}
