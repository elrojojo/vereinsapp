function Mitglieder_PasswortAendern($btn) {
    Schnittstelle_BtnWartenStart($btn);

    const AJAX_DATA = new Object();
    Liste_ElementFormularEigenschaftenWerteInAjaxData($btn.closest(".formular"), AJAX_DATA);
    AJAX_DATA.id = Number($btn.attr("data-element_id"));

    const neue_ajax_id = AJAXSCHLANGE.length;
    AJAXSCHLANGE[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        url: "mitglieder/ajax_mitglied_passwort_aendern",
        data: AJAX_DATA,
        liste: "mitglieder",
        $btn: $btn,
        rein_validation_pos_aktion: function (AJAX) {
            AJAX.$btn.closest(".formular").find(".eigenschaft").val("");
            Schnittstelle_BtnWartenEnde(AJAX.$btn);
            Schnittstelle_DomToastFeuern("Dein Password wurde erfolgreich geändert.");
        },
        rein_validation_neg_aktion: function (AJAX) {
            Liste_ElementFormularValidationAktualisieren(AJAX.$btn.closest(".formular"), AJAX.antwort.validation);
        },
    };

    Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
}
