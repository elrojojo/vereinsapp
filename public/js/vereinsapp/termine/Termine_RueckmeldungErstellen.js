function Termine_RueckmeldungErstellen(formular_oeffnen, dom, data, title, rueckmeldung_id) {
    if (typeof rueckmeldung_id !== "undefined") rueckmeldung_id = Number(rueckmeldung_id);

    if (formular_oeffnen) {
        const $neues_modal = Schnittstelle_DomNeuesModalInitialisiertZurueck(title, "rueckmeldungen_basiseigenschaften");
        Liste_ElementFormularInitialisieren($neues_modal.find(".formular"), "erstellen", rueckmeldung_id, "rueckmeldungen");
        Schnittstelle_DomModalOeffnen($neues_modal);
    } else {
        if (!dom.$btn_ausloesend.hasClass("element")) Schnittstelle_BtnWartenStart(dom.$btn_ausloesend);

        const ajax_dom = dom;
        const ajax_data = data;

        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "termine/ajax_rueckmeldung_speichern",
            data: ajax_data,
            liste: "rueckmeldungen",
            dom: ajax_dom,
            rein_validation_pos_aktion: function (AJAX) {
                if ("rueckmeldung_id" in AJAX.antwort && typeof AJAX.antwort.rueckmeldung_id !== "undefined")
                    AJAX.data.id = Number(AJAX.antwort.rueckmeldung_id);
                else AJAX.data.id = Number(LISTEN["rueckmeldungen"].tabelle.length + 1);
                const rueckmeldung_id = AJAX.data.id;

                LISTEN["rueckmeldungen"].tabelle[rueckmeldung_id] = new Object();
                $.each(AJAX.data, function (eigenschaft, wert) {
                    if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME)
                        Schnittstelle_VariableRein(wert, eigenschaft, rueckmeldung_id, "rueckmeldungen");
                });
                Schnittstelle_EventAusfuehren(
                    [Schnittstelle_EventVariableUpdLocalstorage, Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom],
                    { liste: "rueckmeldungen" }
                );

                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists() && !dom.$btn_ausloesend.hasClass("element"))
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if ("dom" in AJAX && "$modal" in AJAX.dom && AJAX.dom.$modal.exists()) {
                    Schnittstelle_DomModalSchliessen(AJAX.dom.$modal);
                    Schnittstelle_DomToastFeuern(
                        Liste_ElementBeschriftungZurueck(rueckmeldung_id, "rueckmeldungen") + " wurde erfolgreich erstellt."
                    );
                }
            },
            rein_validation_neg_aktion: function (AJAX) {
                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists() && !dom.$btn_ausloesend.hasClass("element"))
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if (isString(AJAX.antwort.validation)) Schnittstelle_DomToastFeuern(AJAX.antwort.validation, "danger");
                else if ("dom" in AJAX && "$formular" in AJAX.dom && AJAX.dom.$formular.exists())
                    Liste_ElementFormularValidationAktualisieren(AJAX.dom.$formular, AJAX.antwort.validation);
            },
        };

        Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
    }
}
