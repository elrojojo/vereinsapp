function Termine_RueckmeldungAendern($btn_ausloesend, status, element_id) {
    Schnittstelle_BtnWartenStart($btn_ausloesend);

    const ajax_data = new Object();
    ajax_data.id = element_id;
    ajax_data.status = status;
    ajax_data.bemerkung = "";

    const ajax_dom = new Object();
    ajax_dom.$btn_ausloesend = $btn_ausloesend;

    const neue_ajax_id = AJAXSCHLANGE.length;
    AJAXSCHLANGE[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        url: "termine/ajax_rueckmeldung_aendern",
        data: ajax_data,
        liste: "rueckmeldungen",
        dom: ajax_dom,
        rein_validation_pos_aktion: function (AJAX) {
            $.each(AJAX.data, function (eigenschaft, wert) {
                if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME)
                    Schnittstelle_VariableRein(wert, eigenschaft, AJAX.data.id, "rueckmeldungen");
            });

            Schnittstelle_EventVariableUpdLocalstorage("rueckmeldungen", [
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
                "Rückgemeldung zu " + Liste_ElementBeschriftungZurueck(AJAX.data.termin_id, "termine") + "konnte nicht gespeichert werden."
            );
        },
    };

    Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
}
