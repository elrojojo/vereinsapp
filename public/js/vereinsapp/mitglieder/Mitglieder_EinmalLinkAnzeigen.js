function Mitglieder_EinmalLinkAnzeigen($btn) {
    const element_id = Number($btn.attr("data-element_id"));

    if ($btn.hasClass("formular_oeffnen"))
        Schnittstelle_DomModalOeffnen(
            Liste_ElementFormularInitialisiertZurueck("einmal_link_anzeigen", "mitglieder", "einmal_link_anzeigen", {
                title: $btn.attr("data-title"),
                element_id: element_id,
            })
        );
    else {
        const AJAX_DATA = new Object();
        AJAX_DATA.id = element_id;

        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "mitglieder/ajax_mitglied_einmal_link_erstellen",
            data: AJAX_DATA,
            liste: "mitglieder",
            $btn: $btn,
            raus_aktion: function (AJAX) {
                Schnittstelle_BtnWartenStart(AJAX.$btn);
            },
            rein_validation_pos_aktion: function (AJAX) {
                const $formular = AJAX.$btn.closest(".formular");
                const $btn_dismiss = $formular.find(".btn[data-bs-dismiss]");

                $formular.find(".einmal_link").val(AJAX.antwort.einmal_link);
                $btn_dismiss.attr("data-beschriftung", $btn_dismiss.text());
                $btn_dismiss.removeClass("btn-outline-danger").addClass("btn-outline-primary").text("Schließen");

                Schnittstelle_EventVariableUpdLocalstorage("mitglieder", [
                    Schnittstelle_EventLocalstorageUpdVariable,
                    Schnittstelle_EventVariableUpdDom,
                ]);
            },
            rein_validation_neg_aktion: function (AJAX) {
                Schnittstelle_DomToastFeuern(
                    "Einmal-Link für " + Liste_ElementBeschriftungZurueck(AJAX.data.id, "mitglieder") + " konnte nicht erstellt werden.",
                    "danger"
                );
            },
            rein_aktion: function (AJAX) {
                Schnittstelle_BtnWartenEnde(AJAX.$btn);
            },
        };

        Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
    }
}
