function Strafkatalog_StrafeAendern(formular_oeffnen, dom, data, title, strafe_id) {
    if (typeof strafe_id !== "undefined") strafe_id = Number(strafe_id);

    if (formular_oeffnen)
        Schnittstelle_DomModalOeffnen(
            Liste_ElementFormularInitialisiertZurueck("basiseigenschaften", "strafkatalog", {
                aktion: "aendern",
                title: title,
                element_id: strafe_id,
            })
        );
    else {
        Schnittstelle_BtnWartenStart(dom.$btn_ausloesend);

        const ajax_dom = dom;
        const ajax_data = data;
        ajax_data.id = strafe_id;
        if (!("titel" in data)) data.titel = Schnittstelle_VariableRausZurueck("titel", strafe_id, "strafkatalog");
        if (!("wert" in data)) data.wert = Schnittstelle_VariableRausZurueck("wert", strafe_id, "strafkatalog");
        if (!("kategorie" in data)) data.kategorie = Schnittstelle_VariableRausZurueck("kategorie", strafe_id, "strafkatalog");
        if (!("bemerkung" in data)) data.bemerkung = Schnittstelle_VariableRausZurueck("bemerkung", strafe_id, "strafkatalog");

        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "strafkatalog/ajax_strafe_speichern",
            data: ajax_data,
            liste: "strafkatalog",
            dom: ajax_dom,
            rein_validation_pos_aktion: function (AJAX) {
                const strafe_id = AJAX.data.id;
                $.each(AJAX.data, function (eigenschaft, wert) {
                    if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME)
                        Schnittstelle_VariableRein(wert, eigenschaft, strafe_id, "strafkatalog");
                });
                Schnittstelle_EventVariableUpdLocalstorage("strafkatalog", [
                    Schnittstelle_EventLocalstorageUpdVariable,
                    Schnittstelle_EventVariableUpdDom,
                ]);

                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if ("dom" in AJAX && "$modal" in AJAX.dom && AJAX.dom.$modal.exists()) {
                    Schnittstelle_DomModalSchliessen(AJAX.dom.$modal);
                    Schnittstelle_DomToastFeuern(Liste_ElementBeschriftungZurueck(strafe_id, "strafkatalog") + " wurde erfolgreich geändert.");
                }
            },
            rein_validation_neg_aktion: function (AJAX) {
                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if ("dom" in AJAX && "$formular" in AJAX.dom && AJAX.dom.$formular.exists())
                    Liste_ElementFormularValidationAktualisieren(AJAX.dom.$formular, AJAX.antwort.validation);
                else
                    Schnittstelle_DomToastFeuern(
                        Liste_ElementBeschriftungZurueck(AJAX.data.id, "strafkatalog") + " konnte nicht gespeichert werden."
                    );
            },
        };

        Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
    }
}
