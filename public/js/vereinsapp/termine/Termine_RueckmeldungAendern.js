function Termine_RueckmeldungAendern($btn) {
    Schnittstelle_BtnWartenStart($btn);

    const AJAX_DATA = new Object();
    AJAX_DATA.id = Number($btn.attr("data-element_id"));
    AJAX_DATA.bemerkung = "";
    const data_werte = $btn.attr("data-werte");
    if (typeof data_werte !== "undefined") AJAX_DATA.status = JSON.parse(data_werte).status;

    const neue_ajax_id = AJAXSCHLANGE.length;
    AJAXSCHLANGE[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        url: "termine/ajax_rueckmeldung_aendern",
        data: AJAX_DATA,
        liste: "rueckmeldungen",
        $btn: $btn,
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
            Schnittstelle_BtnWartenEnde(AJAX.$btn);
        },
        rein_validation_neg_aktion: function (AJAX) {
            Liste_ElementFormularValidationAktualisieren(AJAX.$btn.closest(".formular"), AJAX.antwort.validation);
        },
    };

    Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
}
