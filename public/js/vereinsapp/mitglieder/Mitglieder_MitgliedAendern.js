function Mitglieder_MitgliedAendern(formular_oeffnen, title, $btn_ausloesend, $formular, element_id) {
    if (formular_oeffnen)
        Schnittstelle_DomModalOeffnen(
            Liste_ElementFormularInitialisiertZurueck("basiseigenschaften", "mitglieder", "aendern", {
                title: title,
                element_id: element_id,
            })
        );
    else {
        Schnittstelle_BtnWartenStart($btn_ausloesend);

        const AJAX_DATA = new Object();
        Liste_ElementFormularEigenschaftenWerteInAjaxData($formular, AJAX_DATA);
        AJAX_DATA.id = element_id;

        const ajax_dom = new Object();
        ajax_dom.$btn_ausloesend = $btn_ausloesend;
        ajax_dom.$formular = $formular;

        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "mitglieder/ajax_mitglied_speichern",
            data: AJAX_DATA,
            liste: "mitglieder",
            dom: ajax_dom,
            rein_validation_pos_aktion: function (AJAX) {
                const element_id = AJAX.data.id;
                $.each(AJAX.data, function (eigenschaft, wert) {
                    if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME) Schnittstelle_VariableRein(wert, eigenschaft, element_id, "mitglieder");
                });
                Schnittstelle_EventVariableUpdLocalstorage("mitglieder", [
                    Schnittstelle_EventLocalstorageUpdVariable,
                    Schnittstelle_EventVariableUpdDom,
                ]);

                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if ("dom" in AJAX && "$formular" in AJAX.dom && AJAX.dom.$formular.exists()) Schnittstelle_DomModalSchliessen(AJAX.dom.$formular);
                Schnittstelle_DomToastFeuern(Liste_ElementBeschriftungZurueck(element_id, "mitglieder") + " wurde erfolgreich geändert.");
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
