function Termine_RueckmeldungAendern(formular_oeffnen, dom, data, title, rueckmeldung_id) {
    if (typeof rueckmeldung_id !== "undefined") rueckmeldung_id = Number(rueckmeldung_id);

    if (formular_oeffnen) {
        const $neues_modal = Schnittstelle_DomNeuesModalInitialisiertZurueck(title, "rueckmeldungen_basiseigenschaften");
        Liste_ElementFormularInitialisieren($neues_modal.find(".formular"), "aendern", rueckmeldung_id, "rueckmeldungen");
        Schnittstelle_DomModalOeffnen($neues_modal);
    } else {
        Schnittstelle_BtnWartenStart(dom.$btn_ausloesend);

        const ajax_dom = dom;
        const ajax_data = data;
        ajax_data.id = rueckmeldung_id;
        if (!("termin_id" in data)) data.termin_id = Schnittstelle_VariableRausZurueck("termin_id", rueckmeldung_id, "rueckmeldungen");
        if (!("mitglied_id" in data)) data.mitglied_id = Schnittstelle_VariableRausZurueck("mitglied_id", rueckmeldung_id, "rueckmeldungen");
        if (!("status" in data)) data.status = Schnittstelle_VariableRausZurueck("status", rueckmeldung_id, "rueckmeldungen");
        if (!("bemerkung" in data)) data.bemerkung = Schnittstelle_VariableRausZurueck("bemerkung", rueckmeldung_id, "rueckmeldungen");

        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "termine/ajax_rueckmeldung_speichern",
            data: ajax_data,
            liste: "rueckmeldungen",
            dom: ajax_dom,
            rein_validation_pos_aktion: function (AJAX) {
                const rueckmeldung_id = AJAX.data.id;
                $.each(AJAX.data, function (eigenschaft, wert) {
                    if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME)
                        Schnittstelle_VariableRein(wert, eigenschaft, rueckmeldung_id, "rueckmeldungen");
                });
                Schnittstelle_EventVariableUpdLocalstorage("rueckmeldungen", [
                    Schnittstelle_EventLocalstorageUpdVariable,
                    Schnittstelle_EventVariableUpdDom,
                ]);

                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if ("dom" in AJAX && "$modal" in AJAX.dom && AJAX.dom.$modal.exists()) {
                    Schnittstelle_DomModalSchliessen(AJAX.dom.$modal);
                    Schnittstelle_DomToastFeuern(
                        Liste_ElementBeschriftungZurueck(rueckmeldung_id, "rueckmeldungen") + " wurde erfolgreich geändert."
                    );
                }
            },
            rein_validation_neg_aktion: function (AJAX) {
                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if ("dom" in AJAX && "$formular" in AJAX.dom && AJAX.dom.$formular.exists())
                    Liste_ElementFormularValidationAktualisieren(AJAX.dom.$formular, AJAX.antwort.validation);
                else
                    Schnittstelle_DomToastFeuern(
                        Liste_ElementBeschriftungZurueck(AJAX.data.id, "rueckmeldungen") + " konnte nicht gespeichert werden."
                    );
            },
        };

        Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
    }
}
