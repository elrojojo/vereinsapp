function Notenbank_TitelErstellen($btn) {
    if ($btn.hasClass("formular_oeffnen"))
        Schnittstelle_DomModalOeffnen(
            Liste_ElementFormularInitialisiertZurueck("basiseigenschaften", "notenbank", "erstellen", {
                title: $btn.attr("data-title"),
                element_id: $btn.attr("data-element_id"),
            })
        );
    else {
        const AJAX_DATA = new Object();
        Liste_ElementFormularEigenschaftenWerteInAjaxData($btn.closest(".formular"), AJAX_DATA);

        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "notenbank/ajax_titel_speichern",
            data: AJAX_DATA,
            liste: "notenbank",
            $btn: $btn,
            raus_aktion: function (AJAX) {
                Schnittstelle_BtnWartenStart(AJAX.$btn);
            },
            rein_validation_neg_aktion: function (AJAX) {
                Liste_ElementFormularValidationAktualisieren(AJAX.$btn.closest(".formular"), AJAX.antwort.validation);
            },
            rein_validation_pos_aktion: function (AJAX) {
                if ("element_id" in AJAX.antwort && typeof AJAX.antwort.element_id !== "undefined") AJAX.data.id = Number(AJAX.antwort.element_id);
                else AJAX.data.id = Number(LISTEN["notenbank"].tabelle.length + 1);
                const element_id = AJAX.data.id;

                LISTEN["notenbank"].tabelle[element_id] = new Object();
                $.each(AJAX.data, function (eigenschaft, wert) {
                    if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME) Schnittstelle_VariableRein(wert, eigenschaft, element_id, "notenbank");
                });
                Schnittstelle_EventVariableUpdLocalstorage("notenbank", [
                    Schnittstelle_EventLocalstorageUpdVariable,
                    Schnittstelle_EventVariableUpdDom,
                ]);

                Schnittstelle_DomModalSchliessen(AJAX.$btn.closest(".formular"));
                Schnittstelle_DomToastFeuern(Liste_ElementBeschriftungZurueck(element_id, "notenbank") + " wurde erfolgreich erstellt.");
            },
            rein_aktion: function (AJAX) {
                Schnittstelle_BtnWartenEnde(AJAX.$btn);
            },
        };

        Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
    }
}
