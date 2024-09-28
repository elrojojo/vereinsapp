function Mitglieder_MitgliedAendern(formular_oeffnen, dom, data, title, mitglied_id) {
    if (typeof mitglied_id !== "undefined") mitglied_id = Number(mitglied_id);

    if (formular_oeffnen)
        Schnittstelle_DomModalOeffnen(
            Liste_ElementFormularInitialisiertZurueck("basiseigenschaften", "mitglieder", "aendern", {
                title: title,
                element_id: mitglied_id,
            })
        );
    else {
        Schnittstelle_BtnWartenStart(dom.$btn_ausloesend);

        const ajax_dom = dom;
        const ajax_data = data;
        ajax_data.id = mitglied_id;
        if (!("email" in data)) data.email = Schnittstelle_VariableRausZurueck("email", titel_id, "mitglieder");
        if (!("vorname" in data)) data.vorname = Schnittstelle_VariableRausZurueck("vorname", titel_id, "mitglieder");
        if (!("nachname" in data)) data.nachname = Schnittstelle_VariableRausZurueck("nachname", titel_id, "mitglieder");
        if (!("geburt" in data)) data.geburt = Schnittstelle_VariableRausZurueck("geburt", titel_id, "mitglieder");
        if (!("postleitzahl" in data)) data.postleitzahl = Schnittstelle_VariableRausZurueck("postleitzahl", titel_id, "mitglieder");
        if (!("wohnort" in data)) data.wohnort = Schnittstelle_VariableRausZurueck("wohnort", titel_id, "mitglieder");
        if (!("geschlecht" in data)) data.geschlecht = Schnittstelle_VariableRausZurueck("geschlecht", titel_id, "mitglieder");
        if (!("register" in data)) data.register = Schnittstelle_VariableRausZurueck("register", titel_id, "mitglieder");
        if (!("auto" in data)) data.auto = Schnittstelle_VariableRausZurueck("auto", titel_id, "mitglieder");
        if (!("funktion" in data)) data.funktion = Schnittstelle_VariableRausZurueck("funktion", titel_id, "mitglieder");
        if (!("vorstandschaft" in data)) data.vorstandschaft = Schnittstelle_VariableRausZurueck("vorstandschaft", titel_id, "mitglieder");
        if (!("aktiv" in data)) data.aktiv = Schnittstelle_VariableRausZurueck("aktiv", titel_id, "mitglieder");

        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "mitglieder/ajax_mitglied_speichern",
            data: ajax_data,
            liste: "mitglieder",
            dom: ajax_dom,
            rein_validation_pos_aktion: function (AJAX) {
                const mitglied_id = AJAX.data.id;
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
                    Schnittstelle_DomToastFeuern(Liste_ElementBeschriftungZurueck(mitglied_id, "mitglieder") + " wurde erfolgreich geändert.");
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
