function Notenbank_TitelAendern(formular_oeffnen, title, $btn_ausloesend, $formular, titel_id) {
    if (formular_oeffnen)
        Schnittstelle_DomModalOeffnen(
            Liste_ElementFormularInitialisiertZurueck("basiseigenschaften", "notenbank", "aendern", {
                title: title,
                element_id: titel_id,
            })
        );
    else {
        Schnittstelle_BtnWartenStart($btn_ausloesend);

        const ajax_data = new Object();
        Liste_ElementFormularEigenschaftenWerteInAjaxData($formular, ajax_data);
        ajax_data.id = titel_id;

        const ajax_dom = new Object();
        ajax_dom.$btn_ausloesend = $btn_ausloesend;
        ajax_dom.$formular = $formular;

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

                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if ("dom" in AJAX && "$formular" in AJAX.dom && AJAX.dom.$formular.exists()) Schnittstelle_DomModalSchliessen(AJAX.dom.$formular);
                Schnittstelle_DomToastFeuern(Liste_ElementBeschriftungZurueck(titel_id, "notenbank") + " wurde erfolgreich geändert.");
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
