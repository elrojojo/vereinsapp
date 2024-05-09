function Termine_RueckmeldungErstellen($btn_ausloesend, termin_id, mitglied_id, status) {
    Schnittstelle_BtnWartenStart($btn_ausloesend);

    // Zum Testen bzgl. "Bei iPhone verschwindet der Termin auf der Startseite nicht sofort, wenn man Rückmeldung gibt.""
    $btn_ausloesend.trigger("blur");
    $(".navbar-text").trigger("focus");
    // ENDE

    const ajax_data = new Object();
    ajax_data.termin_id = termin_id;
    ajax_data.mitglied_id = mitglied_id;
    ajax_data.status = status;
    ajax_data.bemerkung = "";

    const ajax_dom = new Object();
    ajax_dom.$btn_ausloesend = $btn_ausloesend;

    const neue_ajax_id = AJAXSCHLANGE.length;
    AJAXSCHLANGE[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        url: "termine/ajax_rueckmeldung_speichern",
        data: ajax_data,
        liste: "rueckmeldungen",
        dom: ajax_dom,
        rein_validation_pos_aktion: function (AJAX) {
            if ("element_id" in AJAX.antwort && typeof AJAX.antwort.element_id !== "undefined") AJAX.data.id = Number(AJAX.antwort.element_id);
            else AJAX.data.id = Number(LISTEN["rueckmeldungen"].tabelle.length + 1);
            const element_id = AJAX.data.id;

            LISTEN["rueckmeldungen"].tabelle[element_id] = new Object();
            $.each(AJAX.data, function (eigenschaft, wert) {
                if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME) Schnittstelle_VariableRein(wert, eigenschaft, element_id, "rueckmeldungen");
            });

            // Zum Testen bzgl. "Bei iPhone verschwindet der Termin auf der Startseite nicht sofort, wenn man Rückmeldung gibt.""
            AJAX.dom.$btn_ausloesend.trigger("blur");
            $(".navbar-text").trigger("focus");
            // ENDE

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
