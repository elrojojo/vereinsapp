function Termine_TerminAendern($btn) {
    if ($btn.hasClass("formular_oeffnen"))
        Schnittstelle_DomModalOeffnen(
            Liste_ElementFormularInitialisiertZurueck("basiseigenschaften", "termine", "aendern", {
                title: $btn.attr("data-title"),
                element_id: $btn.attr("data-element_id"),
            })
        );
    else {
        Schnittstelle_BtnWartenStart($btn);

        const AJAX_DATA = new Object();
        Liste_ElementFormularEigenschaftenWerteInAjaxData($btn.closest(".formular"), AJAX_DATA);
        AJAX_DATA.id = Number($btn.attr("data-element_id"));

        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "termine/ajax_termin_speichern",
            data: AJAX_DATA,
            liste: "termine",
            $btn: $btn,
            rein_validation_pos_aktion: function (AJAX) {
                const element_id = AJAX.data.id;
                $.each(AJAX.data, function (eigenschaft, wert) {
                    if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME) Schnittstelle_VariableRein(wert, eigenschaft, element_id, "termine");
                });
                Schnittstelle_EventVariableUpdLocalstorage("termine", [
                    Schnittstelle_EventLocalstorageUpdVariable,
                    Schnittstelle_EventVariableUpdDom,
                ]);

                Schnittstelle_BtnWartenEnde(AJAX.$btn);
                Schnittstelle_DomModalSchliessen(AJAX.$btn.closest(".modal.formular"));
                Schnittstelle_DomToastFeuern(Liste_ElementBeschriftungZurueck(element_id, "termine") + " wurde erfolgreich geändert.");
            },
            rein_validation_neg_aktion: function (AJAX) {
                Liste_ElementFormularValidationAktualisieren(AJAX.$btn.closest(".formular"), AJAX.antwort.validation);
            },
        };

        Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
    }
}
