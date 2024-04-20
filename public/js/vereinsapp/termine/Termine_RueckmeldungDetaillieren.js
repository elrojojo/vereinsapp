function Termine_RueckmeldungDetaillieren($btn) {
    const element_id = Number($btn.attr("data-element_id"));

    if ($btn.hasClass("formular_oeffnen"))
        Schnittstelle_DomModalOeffnen(
            Liste_ElementFormularInitialisiertZurueck("bemerkung", "rueckmeldungen", "detaillieren", {
                element_id: element_id,
                title: $btn.attr("data-title"),
            })
        );
    else {
        const AJAX_DATA = new Object();
        Liste_ElementFormularEigenschaftenWerteInAjaxData($btn.closest(".formular"), AJAX_DATA);
        AJAX_DATA.id = element_id;

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
                const element_id = AJAX.data.id;
                $.each(AJAX.data, function (eigenschaft, wert) {
                    if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME)
                        Schnittstelle_VariableRein(wert, eigenschaft, element_id, "rueckmeldungen");
                });
                // Termine_RueckmeldungAktualisieren($btn);
                Schnittstelle_EventVariableUpdLocalstorage("rueckmeldungen", [
                    Schnittstelle_EventLocalstorageUpdVariable,
                    Schnittstelle_EventVariableUpdDom,
                ]);

                Schnittstelle_DomModalSchliessen(AJAX.$btn.closest(".formular"));
            },
            rein_aktion: function (AJAX) {
                Schnittstelle_BtnWartenEnde(AJAX.$btn);
            },
        };

        Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
    }
}
