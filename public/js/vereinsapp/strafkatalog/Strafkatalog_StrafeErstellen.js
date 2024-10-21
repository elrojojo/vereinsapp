function Strafkatalog_StrafeErstellen(formular_oeffnen, dom, data, title, strafe_id) {
    if (typeof strafe_id !== "undefined") strafe_id = Number(strafe_id);

    if (formular_oeffnen) {
        const $neues_modal = Schnittstelle_DomNeuesModalInitialisiertZurueck(title, "strafkatalog_basiseigenschaften");
        Liste_ElementFormularInitialisieren($neues_modal.find(".formular"), "erstellen", strafe_id, "strafkatalog");
        Schnittstelle_DomModalOeffnen($neues_modal);
    } else {
        if (!dom.$btn_ausloesend.hasClass("element")) Schnittstelle_BtnWartenStart(dom.$btn_ausloesend);

        const ajax_dom = dom;
        const ajax_data = data;

        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "strafkatalog/ajax_strafe_speichern",
            data: ajax_data,
            liste: "strafkatalog",
            dom: ajax_dom,
            rein_validation_pos_aktion: function (AJAX) {
                if ("strafe_id" in AJAX.antwort && typeof AJAX.antwort.strafe_id !== "undefined") AJAX.data.id = Number(AJAX.antwort.strafe_id);
                else AJAX.data.id = Number(LISTEN["strafkatalog"].tabelle.length + 1);
                const strafe_id = AJAX.data.id;

                LISTEN["strafkatalog"].tabelle[strafe_id] = new Object();
                $.each(AJAX.data, function (eigenschaft, wert) {
                    if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME)
                        Schnittstelle_VariableRein(wert, eigenschaft, strafe_id, "strafkatalog");
                });
                Schnittstelle_EventVariableUpdLocalstorage("strafkatalog", [
                    Schnittstelle_EventLocalstorageUpdVariable,
                    Schnittstelle_EventVariableUpdDom,
                ]);

                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists() && !dom.$btn_ausloesend.hasClass("element"))
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if ("dom" in AJAX && "$modal" in AJAX.dom && AJAX.dom.$modal.exists()) Schnittstelle_DomModalSchliessen(AJAX.dom.$modal);
                Schnittstelle_DomToastFeuern(Liste_ElementBeschriftungZurueck(strafe_id, "strafkatalog") + " wurde erfolgreich erstellt.");
            },
            rein_validation_neg_aktion: function (AJAX) {
                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists() && !dom.$btn_ausloesend.hasClass("element"))
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
