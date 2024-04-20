function Mitglieder_EinmalLinkAnzeigen($btn) {
    const element_id = Number($btn.attr("data-element_id"));

    if ($btn.hasClass("formular_oeffnen")) {
        const $formular = Liste_ElementFormularInitialisiertZurueck("einmal_link_anzeigen", "mitglieder", "einmal_link_anzeigen", {
            element_id: element_id,
            title: $btn.attr("data-title"),
        });
        const $btn_dismiss = $formular.find(".btn[data-bs-dismiss]");
        const btn_dismiss_beschriftung = $btn_dismiss.attr("data-beschriftung");
        $btn_dismiss.addClass("btn-outline-danger").removeClass("btn-outline-primary");
        if (typeof btn_dismiss_beschriftung !== "undefined") $btn_dismiss.text(btn_dismiss_beschriftung);
        $formular.find(".einmal_link").val("");
        $formular.find(".btn_mitglied_einmal_link_erstellen").removeClass("invisible");

        Schnittstelle_DomModalOeffnen($formular);
    } else {
        const AJAX_DATA = new Object();
        AJAX_DATA.id = element_id;

        const neue_ajax_id = G.AJAX.length;
        G.AJAX[neue_ajax_id] = {
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

        Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
    }
}
