function Termine_RueckmeldungErstellen(dom, data, rueckmeldung_id) {
    if (typeof rueckmeldung_id !== "undefined") rueckmeldung_id = Number(rueckmeldung_id);

    Schnittstelle_BtnWartenStart(dom.$btn_ausloesend);

    // Zum Testen bzgl. "Bei iPhone verschwindet der Termin auf der Startseite nicht sofort, wenn man Rückmeldung gibt.""
    dom.$btn_ausloesend.trigger("blur");
    $(".navbar-text").trigger("focus");
    // ENDE

    const ajax_dom = dom;
    const ajax_data = data;

    const neue_ajax_id = AJAXSCHLANGE.length;
    AJAXSCHLANGE[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        url: "termine/ajax_rueckmeldung_speichern",
        data: ajax_data,
        liste: "rueckmeldungen",
        dom: ajax_dom,
        rein_validation_pos_aktion: function (AJAX) {
            if ("rueckmeldung_id" in AJAX.antwort && typeof AJAX.antwort.rueckmeldung_id !== "undefined")
                AJAX.data.id = Number(AJAX.antwort.rueckmeldung_id);
            else AJAX.data.id = Number(LISTEN["rueckmeldungen"].tabelle.length + 1);
            const rueckmeldung_id = AJAX.data.id;

            LISTEN["rueckmeldungen"].tabelle[rueckmeldung_id] = new Object();
            $.each(AJAX.data, function (eigenschaft, wert) {
                if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME)
                    Schnittstelle_VariableRein(wert, eigenschaft, rueckmeldung_id, "rueckmeldungen");
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
