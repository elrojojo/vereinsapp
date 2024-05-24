function Termine_RueckmeldungDetaillieren(formular_oeffnen, title, $btn_ausloesend, $formular, rueckmeldung_id) {
    if (formular_oeffnen)
        Schnittstelle_DomModalOeffnen(
            Liste_ElementFormularInitialisiertZurueck("bemerkung", "rueckmeldungen", "detaillieren", {
                title: title,
                element_id: rueckmeldung_id,
            })
        );
    else {
        Schnittstelle_BtnWartenStart($btn_ausloesend);

        const ajax_data = new Object();
        Liste_ElementFormularEigenschaftenWerteInAjaxData($formular, ajax_data);
        ajax_data.id = rueckmeldung_id;

        const ajax_dom = new Object();
        ajax_dom.$btn_ausloesend = $btn_ausloesend;
        ajax_dom.$formular = $formular;

        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "termine/ajax_rueckmeldung_aendern",
            data: ajax_data,
            liste: "rueckmeldungen",
            dom: ajax_dom,
            rein_validation_pos_aktion: function (AJAX) {
                $.each(AJAX.data, function (eigenschaft, wert) {
                    if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME)
                        Schnittstelle_VariableRein(wert, eigenschaft, AJAX.data.id, "rueckmeldungen");
                });

                Schnittstelle_EventVariableUpdLocalstorage("rueckmeldungen", [
                    Schnittstelle_EventLocalstorageUpdVariable,
                    Schnittstelle_EventVariableUpdDom,
                ]);

                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if ("dom" in AJAX && "$formular" in AJAX.dom && AJAX.dom.$formular.exists()) Schnittstelle_DomModalSchliessen(AJAX.dom.$formular);
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
