function Termine_RueckmeldungDetaillieren($btn) {
    if ($btn.hasClass("formular_oeffnen"))
        Liste_ElementFormularOeffnen($("#rueckmeldung_detaillieren_modal"), "rueckmeldungen", "detaillieren", {
            title: $btn.attr("data-title"),
            element_id: $btn.attr("data-element_id"),
        });
    else {
        const AJAX_DATA = new Object();
        Liste_ElementFormularEigenschaftenWerteInAjaxData($btn.closest(".formular"), AJAX_DATA);
        AJAX_DATA.id = Number($btn.attr("data-element_id"));
        const data_werte = $btn.attr("data-werte");
        if (typeof data_werte !== "undefined")
            $.each(JSON.parse(data_werte), function (eigenschaft, wert) {
                AJAX_DATA[eigenschaft] = wert;
            });

        const neue_ajax_id = G.AJAX.length;
        G.AJAX[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "termine/ajax_rueckmeldung_aendern",
            data: AJAX_DATA,
            liste: "rueckmeldungen",
            $btn: $btn,
            raus_aktion: function (AJAX) {
                Schnittstelle_BtnWartenStart(AJAX.$btn);
            },
            rein_validation_neg_aktion: function (AJAX) {
                Liste_ElementFormularValidationAktualisieren(AJAX.$btn.closest(".formular"), AJAX.antwort.validation);
            },
            rein_validation_pos_aktion: function (AJAX) {
                $.each(AJAX.data, function (eigenschaft, wert) {
                    if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME)
                        Schnittstelle_VariableRein(wert, eigenschaft, AJAX.data.id, "rueckmeldungen");
                });
                // Termine_RueckmeldungAktualisieren($btn);
                Schnittstelle_EventVariableUpdLocalstorage("rueckmeldungen", [
                    Schnittstelle_EventLocalstorageUpdVariable,
                    Schnittstelle_EventVariableUpdDom,
                ]);

                Liste_ElementFormularSchliessen(AJAX.$btn.closest(".formular"), "rueckmeldungen", "detaillieren");
            },
            rein_aktion: function (AJAX) {
                Schnittstelle_BtnWartenEnde(AJAX.$btn);
            },
        };

        Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
    }
}
