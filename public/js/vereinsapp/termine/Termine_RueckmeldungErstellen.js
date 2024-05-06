function Termine_RueckmeldungErstellen($btn) {
    // Zum Testen bzgl. "Bei iPhone verschwindet der Termin auf der Startseite nicht sofort, wenn man Rückmeldung gibt.""
    $btn.trigger("blur");
    $(".navbar-text").trigger("focus");
    // ENDE

    const AJAX_DATA = new Object();
    AJAX_DATA.bemerkung = "";
    const data_werte = $btn.attr("data-werte");
    if (typeof data_werte !== "undefined") {
        AJAX_DATA.termin_id = JSON.parse(data_werte).termin_id;
        AJAX_DATA.mitglied_id = JSON.parse(data_werte).mitglied_id;
        AJAX_DATA.status = JSON.parse(data_werte).status;
    }

    const neue_ajax_id = AJAXSCHLANGE.length;
    AJAXSCHLANGE[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        url: "termine/ajax_rueckmeldung_speichern",
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
            if ("element_id" in AJAX.antwort && typeof AJAX.antwort.element_id !== "undefined") AJAX.data.id = Number(AJAX.antwort.element_id);
            else AJAX.data.id = Number(LISTEN["rueckmeldungen"].tabelle.length + 1);
            const element_id = AJAX.data.id;

            LISTEN["rueckmeldungen"].tabelle[element_id] = new Object();
            $.each(AJAX.data, function (eigenschaft, wert) {
                if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME) Schnittstelle_VariableRein(wert, eigenschaft, element_id, "rueckmeldungen");
            });

            // Zum Testen bzgl. "Bei iPhone verschwindet der Termin auf der Startseite nicht sofort, wenn man Rückmeldung gibt.""
            $btn.trigger("blur");
            $(".navbar-text").trigger("focus");
            // ENDE

            // Termine_RueckmeldungAktualisieren($btn);

            Schnittstelle_EventVariableUpdLocalstorage("rueckmeldungen", [
                Schnittstelle_EventLocalstorageUpdVariable,
                Schnittstelle_EventVariableUpdDom,
            ]);
        },
        rein_aktion: function (AJAX) {
            Schnittstelle_BtnWartenEnde(AJAX.$btn);
        },
    };

    Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
}
