function Mitglieder_MitgliedErstellen(formular_oeffnen, dom, data, title, mitglied_id) {
    if (typeof mitglied_id !== "undefined") mitglied_id = Number(mitglied_id);

    if (formular_oeffnen)
        Schnittstelle_DomModalOeffnen(
            Liste_ElementFormularInitialisiertZurueck("basiseigenschaften", "mitglieder", {
                aktion: "erstellen",
                title: title,
                element_id: mitglied_id,
            })
        );
    else {
        Schnittstelle_BtnWartenStart(dom.$btn_ausloesend);

        const ajax_dom = dom;
        const ajax_data = data;

        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "mitglieder/ajax_mitglied_speichern",
            data: ajax_data,
            liste: "mitglieder",
            dom: ajax_dom,
            rein_validation_pos_aktion: function (AJAX) {
                if ("mitglied_id" in AJAX.antwort && typeof AJAX.antwort.mitglied_id !== "undefined") AJAX.data.id = Number(AJAX.antwort.mitglied_id);
                else AJAX.data.id = Number(LISTEN["mitglieder"].tabelle.length + 1);
                const mitglied_id = AJAX.data.id;

                LISTEN["mitglieder"].tabelle[mitglied_id] = new Object();
                $.each(AJAX.data, function (eigenschaft, wert) {
                    if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME)
                        Schnittstelle_VariableRein(wert, eigenschaft, mitglied_id, "mitglieder");
                });
                Schnittstelle_EventVariableUpdLocalstorage("mitglieder", [
                    Schnittstelle_EventLocalstorageUpdVariable,
                    Schnittstelle_EventVariableUpdDom,
                ]);

                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if ("dom" in AJAX && "$modal" in AJAX.dom && AJAX.dom.$modal.exists()) {
                    Schnittstelle_DomModalSchliessen(AJAX.dom.$modal);
                    Schnittstelle_DomToastFeuern(Liste_ElementBeschriftungZurueck(mitglied_id, "mitglieder") + " wurde erfolgreich erstellt.");
                }
            },
            rein_validation_neg_aktion: function (AJAX) {
                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                if ("dom" in AJAX && "$formular" in AJAX.dom && AJAX.dom.$formular.exists())
                    Liste_ElementFormularValidationAktualisieren(AJAX.dom.$formular, AJAX.antwort.validation);
                else Schnittstelle_DomToastFeuern(Liste_ElementBeschriftungZurueck(AJAX.data.id, "mitglieder") + " konnte nicht gespeichert werden.");
            },
        };

        Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
    }
}
