function Strafkatalog_KassenbucheintragErstellen(formular_oeffnen, dom, data, title, kassenbucheintrag_id) {
    if (typeof kassenbucheintrag_id !== "undefined") kassenbucheintrag_id = Number(kassenbucheintrag_id);

    if (formular_oeffnen) {
        const $neues_modal = Schnittstelle_DomNeuesModalInitialisiertZurueck(title, "kassenbuch_basiseigenschaften");
        Liste_ElementFormularInitialisieren($neues_modal.find(".formular"), "erstellen", kassenbucheintrag_id, "kassenbuch");
        Schnittstelle_DomModalOeffnen($neues_modal);
    } else {
        Schnittstelle_BtnWartenStart(dom.$btn_ausloesend);

        const ajax_dom = dom;
        const ajax_data = data;
        if (!("mitglied_id" in ajax_data)) ajax_data.mitglied_id = ICH["id"]; // Prototypisch! -> TODO!
        if (!("aktiv" in ajax_data)) ajax_data.aktiv = 1;

        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "strafkatalog/ajax_kassenbucheintrag_speichern",
            data: ajax_data,
            liste: "kassenbuch",
            dom: ajax_dom,
            rein_validation_pos_aktion: function (AJAX) {
                if ("kassenbucheintrag_id" in AJAX.antwort && typeof AJAX.antwort.kassenbucheintrag_id !== "undefined")
                    AJAX.data.id = Number(AJAX.antwort.kassenbucheintrag_id);
                else AJAX.data.id = Number(LISTEN["kassenbuch"].tabelle.length + 1);
                const kassenbucheintrag_id = AJAX.data.id;

                LISTEN["kassenbuch"].tabelle[kassenbucheintrag_id] = new Object();
                $.each(AJAX.data, function (eigenschaft, wert) {
                    if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME)
                        Schnittstelle_VariableRein(wert, eigenschaft, kassenbucheintrag_id, "kassenbuch");
                });
                Schnittstelle_VariableRein(DateTime.now(), "erstellung", kassenbucheintrag_id, "kassenbuch");
                Schnittstelle_EventVariableUpdLocalstorage("kassenbuch", [
                    Schnittstelle_EventLocalstorageUpdVariable,
                    Schnittstelle_EventVariableUpdDom,
                ]);

                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if ("dom" in AJAX && "$modal" in AJAX.dom && AJAX.dom.$modal.exists()) Schnittstelle_DomModalSchliessen(AJAX.dom.$modal);
                Schnittstelle_DomToastFeuern(Liste_ElementBeschriftungZurueck(kassenbucheintrag_id, "kassenbuch") + " wurde erfolgreich erstellt.");
            },
            rein_validation_neg_aktion: function (AJAX) {
                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if ("dom" in AJAX && "$formular" in AJAX.dom && AJAX.dom.$formular.exists())
                    Liste_ElementFormularValidationAktualisieren(AJAX.dom.$formular, AJAX.antwort.validation);
                else Schnittstelle_DomToastFeuern(Liste_ElementBeschriftungZurueck(AJAX.data.id, "kassenbuch") + " konnte nicht gespeichert werden.");
            },
        };

        Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
    }
}
