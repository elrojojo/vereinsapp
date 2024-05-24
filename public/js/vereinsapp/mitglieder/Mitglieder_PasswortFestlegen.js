function Mitglieder_PasswortFestlegen($btn_ausloesend, $formular, mitglied_id) {
    Schnittstelle_BtnWartenStart($btn_ausloesend);

    const ajax_data = new Object();
    Liste_ElementFormularEigenschaftenWerteInAjaxData($formular, ajax_data);
    ajax_data.id = mitglied_id;

    const ajax_dom = new Object();
    ajax_dom.$btn_ausloesend = $btn_ausloesend;
    ajax_dom.$formular = $formular;

    const neue_ajax_id = AJAXSCHLANGE.length;
    AJAXSCHLANGE[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        url: "mitglieder/ajax_mitglied_passwort_festlegen",
        data: ajax_data,
        liste: "mitglieder",
        dom: ajax_dom,
        rein_validation_pos_aktion: function (AJAX) {
            if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
            if ("dom" in AJAX && "$formular" in AJAX.dom && AJAX.dom.$formular.exists()) Schnittstelle_DomModalSchliessen(AJAX.dom.$formular);
            Schnittstelle_DomToastFeuern("Du hast erfolgreich ein neues Password festgelegt.");
        },
        rein_validation_neg_aktion: function (AJAX) {
            if ("dom" in AJAX && "$btn_ausloesend" in AJAX.dom && AJAX.dom.$btn_ausloesend.exists())
                Schnittstelle_BtnWartenEnde(AJAX.dom.$btn_ausloesend);
            if ("dom" in AJAX && "$formular" in AJAX.dom && AJAX.dom.$formular.exists())
                Liste_ElementFormularValidationAktualisieren(AJAX.dom.$formular, AJAX.antwort.validation);
        },
    };

    Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
}
