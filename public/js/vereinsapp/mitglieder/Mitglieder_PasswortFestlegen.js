function Mitglieder_PasswortFestlegen($btn) {
    const AJAX_DATA = new Object();
    Liste_ElementFormularEigenschaftenWerteInAjaxData($btn.closest(".formular"), AJAX_DATA);
    AJAX_DATA.id = Number($btn.attr("data-element_id"));

    const neue_ajax_id = AJAXSCHLANGE.length;
    AJAXSCHLANGE[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        url: "mitglieder/ajax_mitglied_passwort_festlegen",
        data: AJAX_DATA,
        liste: "mitglieder",
        $btn: $btn,
        raus_aktion: function (AJAX) {
            Schnittstelle_BtnWartenStart(AJAX.$btn);
        },
        rein_validation_neg_aktion: function (AJAX) {
            Liste_ElementFormularValidationAktualisieren(AJAX.$btn.closest(".formular"), AJAX.antwort.validation);
        },
        rein_validation_pos_aktion: function (AJAX) {
            Schnittstelle_DomModalSchliessen(AJAX.$btn.closest(".formular"));
            Schnittstelle_DomToastFeuern("Du hast erfolgreich ein neues Password festgelegt.");
        },
        rein_aktion: function (AJAX) {
            Schnittstelle_BtnWartenEnde(AJAX.$btn);
        },
    };

    Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
}
