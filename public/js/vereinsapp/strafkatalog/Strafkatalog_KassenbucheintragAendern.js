function Strafkatalog_KassenbucheintragAendern(formular_oeffnen, title, $btn_ausloesend, $formular, kassenbucheintrag_id) {
    if (formular_oeffnen)
        Schnittstelle_DomModalOeffnen(
            Liste_ElementFormularInitialisiertZurueck("basiseigenschaften", "kassenbuch", "aendern", {
                title: title,
                element_id: kassenbucheintrag_id,
            })
        );
    else {
        Schnittstelle_BtnWartenStart($btn_ausloesend);

        const ajax_data = new Object();
        Liste_ElementFormularEigenschaftenWerteInAjaxData($formular, ajax_data);
        ajax_data.id = kassenbucheintrag_id;
        ajax_data.id = DateTime.now();

        const ajax_dom = new Object();
        ajax_dom.$btn_ausloesend = $btn_ausloesend;
        ajax_dom.$formular = $formular;

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
                Schnittstelle_VariableRein(DateTime.now(), "letzte_aktivitaet", kassenbucheintrag_id, "kassenbuch");
                Schnittstelle_EventVariableUpdLocalstorage("kassenbuch", [
                    Schnittstelle_EventLocalstorageUpdVariable,
                    Schnittstelle_EventVariableUpdDom,
                ]);

                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if ("dom" in AJAX && "$formular" in AJAX.dom && AJAX.dom.$formular.exists()) Schnittstelle_DomModalSchliessen(AJAX.dom.$formular);
                Schnittstelle_DomToastFeuern(Liste_ElementBeschriftungZurueck(kassenbucheintrag_id, "kassenbuch") + " wurde erfolgreich geändert.");
            },
            rein_validation_neg_aktion: function (AJAX) {
                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if ("dom" in AJAX && "$formular" in AJAX.dom && AJAX.dom.$formular.exists())
                    Liste_ElementFormularValidationAktualisieren(AJAX.dom.$formular, AJAX.antwort.validation);
            },
        };

        Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
    }
}
