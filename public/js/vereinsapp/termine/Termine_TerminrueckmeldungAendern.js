function Termine_TerminrueckmeldungAendern(formular_oeffnen, dom, data, title, terminrueckmeldung_id) {
    if (typeof terminrueckmeldung_id !== "undefined") terminrueckmeldung_id = Number(terminrueckmeldung_id);

    if (formular_oeffnen) {
        const $neues_modal = Schnittstelle_DomNeuesModalInitialisiertZurueck(title, "terminrueckmeldungen_basiseigenschaften");
        Schnittstelle_DomModalOeffnen($neues_modal);
        Liste_ElementFormularInitialisieren($neues_modal.find(".formular"), "aendern", terminrueckmeldung_id, "terminrueckmeldungen");
    } else {
        if (!dom.$btn_ausloesend.hasClass("element")) Schnittstelle_BtnWartenStart(dom.$btn_ausloesend);

        const ajax_dom = dom;
        const ajax_data = data;
        ajax_data.id = terminrueckmeldung_id;
        if (!("termin_id" in data)) data.termin_id = Schnittstelle_VariableRausZurueck("termin_id", terminrueckmeldung_id, "terminrueckmeldungen");
        if (!("mitglied_id" in data))
            data.mitglied_id = Schnittstelle_VariableRausZurueck("mitglied_id", terminrueckmeldung_id, "terminrueckmeldungen");
        if (!("status" in data)) data.status = Schnittstelle_VariableRausZurueck("status", terminrueckmeldung_id, "terminrueckmeldungen");
        if (!("bemerkung" in data)) data.bemerkung = Schnittstelle_VariableRausZurueck("bemerkung", terminrueckmeldung_id, "terminrueckmeldungen");

        Schnittstelle_AjaxInDieSchlange(
            "termine/ajax_terminrueckmeldung_speichern",
            ajax_data,
            ajax_dom,
            function (AJAX) {
                const terminrueckmeldung_id = AJAX.data.id;
                $.each(AJAX.data, function (eigenschaft, wert) {
                    if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME)
                        Schnittstelle_VariableRein(wert, eigenschaft, terminrueckmeldung_id, "terminrueckmeldungen");
                });
                Schnittstelle_EventAusfuehren(
                    [Schnittstelle_EventVariableUpdLocalstorage, Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom],
                    { liste: "terminrueckmeldungen" }
                );

                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists() && !dom.$btn_ausloesend.hasClass("element"))
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if ("dom" in AJAX && "$modal" in AJAX.dom && AJAX.dom.$modal.exists()) {
                    Schnittstelle_DomModalSchliessen(AJAX.dom.$modal);
                    Schnittstelle_DomToastFeuern(
                        Liste_ElementBeschriftungZurueck(terminrueckmeldung_id, "terminrueckmeldungen") + " wurde erfolgreich geändert."
                    );
                }
            },
            function (AJAX) {
                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists() && !dom.$btn_ausloesend.hasClass("element"))
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if (isString(AJAX.antwort.validation)) Schnittstelle_DomToastFeuern(AJAX.antwort.validation, "danger");
                else if ("dom" in AJAX && "$formular" in AJAX.dom && AJAX.dom.$formular.exists())
                    Liste_ElementFormularValidationAktualisieren(AJAX.dom.$formular, AJAX.antwort.validation);
                Schnittstelle_DomToastFeuern(
                    Liste_ElementBeschriftungZurueck(AJAX.data.id, "terminrueckmeldungen") + " konnte nicht gespeichert werden.",
                    "danger"
                );
            }
        );
    }
}
