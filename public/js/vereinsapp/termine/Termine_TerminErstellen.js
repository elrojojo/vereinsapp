function Termine_TerminErstellen($btn) {
    if ($btn.hasClass("formular_oeffnen"))
        Schnittstelle_DomModalOeffnen(
            Liste_ElementFormularInitialisiertZurueck("basiseigenschaften", "termine", "erstellen", {
                title: $btn.attr("data-title"),
                element_id: $btn.attr("data-element_id"),
            })
        );
    else {
        Schnittstelle_BtnWartenStart($btn);

        const AJAX_DATA = new Object();
        Liste_ElementFormularEigenschaftenWerteInAjaxData($btn.closest(".formular"), AJAX_DATA);

        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "termine/ajax_termin_speichern",
            data: AJAX_DATA,
            liste: "termine",
            $btn: $btn,
            rein_validation_pos_aktion: function (AJAX) {
                if ("element_id" in AJAX.antwort && typeof AJAX.antwort.element_id !== "undefined") AJAX.data.id = Number(AJAX.antwort.element_id);
                else AJAX.data.id = Number(LISTEN["termine"].tabelle.length + 1);
                const element_id = AJAX.data.id;

                LISTEN["termine"].tabelle[element_id] = new Object();
                $.each(AJAX.data, function (eigenschaft, wert) {
                    if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME) Schnittstelle_VariableRein(wert, eigenschaft, element_id, "termine");
                });
                Schnittstelle_EventVariableUpdLocalstorage("termine", [
                    Schnittstelle_EventLocalstorageUpdVariable,
                    Schnittstelle_EventVariableUpdDom,
                ]);

                Schnittstelle_BtnWartenEnde(AJAX.$btn);
                Schnittstelle_DomModalSchliessen(AJAX.$btn.closest(".modal.formular"));
                Schnittstelle_DomToastFeuern(Liste_ElementBeschriftungZurueck(element_id, "termine") + " wurde erfolgreich erstellt.");
            },
            rein_validation_neg_aktion: function (AJAX) {
                Liste_ElementFormularValidationAktualisieren(AJAX.$btn.closest(".formular"), AJAX.antwort.validation);
            },
        };

        Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
    }
}
