function Mitglieder_EinmalLinkAnzeigen(formular_oeffnen, title, $btn_ausloesend, $formular, element_id) {
    if (formular_oeffnen)
        Schnittstelle_DomModalOeffnen(
            Liste_ElementFormularInitialisiertZurueck("einmal_link_anzeigen", "mitglieder", "einmal_link_anzeigen", {
                title: title,
                element_id: element_id,
            })
        );
    else {
        Schnittstelle_BtnWartenStart($btn_ausloesend);

        const AJAX_DATA = new Object();
        AJAX_DATA.id = element_id;

        const ajax_dom = new Object();
        ajax_dom.$btn_ausloesend = $btn_ausloesend;
        ajax_dom.$formular = $formular;
        ajax_dom.$einmal_link = $formular.find(".einmal_link");
        ajax_dom.$btn_dismiss = $formular.find(".btn[data-bs-dismiss]");

        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "mitglieder/ajax_mitglied_einmal_link_erstellen",
            data: AJAX_DATA,
            liste: "mitglieder",
            dom: ajax_dom,
            rein_validation_pos_aktion: function (AJAX) {
                if ("dom" in AJAX && "$einmal_link" in AJAX.dom && AJAX.dom.$einmal_link.exists())
                    AJAX.dom.$einmal_link.val(AJAX.antwort.einmal_link);
                if ("dom" in AJAX && "$btn_dismiss" in AJAX.dom && AJAX.dom.$btn_dismiss.exists())
                    AJAX.dom.$btn_dismiss
                        .attr("data-beschriftung", AJAX.dom.$btn_dismiss.text())
                        .removeClass("btn-outline-danger")
                        .addClass("btn-outline-primary")
                        .text("Schließen");

                Schnittstelle_EventVariableUpdLocalstorage("mitglieder", [
                    Schnittstelle_EventLocalstorageUpdVariable,
                    Schnittstelle_EventVariableUpdDom,
                ]);
                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
            },
            rein_validation_neg_aktion: function (AJAX) {
                if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                    Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
                Schnittstelle_DomToastFeuern(
                    "Einmal-Link für " + Liste_ElementBeschriftungZurueck(AJAX.data.id, "mitglieder") + " konnte nicht erstellt werden.",
                    "danger"
                );
            },
        };

        Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
    }
}
