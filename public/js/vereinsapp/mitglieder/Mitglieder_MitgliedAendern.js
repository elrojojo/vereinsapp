function Mitglieder_MitgliedAendern($btn) {
    const element_id = $btn.attr("data-element_id");

    const AJAX_DATA = new Object();
    Liste_ElementFormularEigenschaftenWerteInAjaxData($btn.closest(".formular"), AJAX_DATA);
    AJAX_DATA.id = Number(element_id);

    const neue_ajax_id = G.AJAX.length;
    G.AJAX[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        url: "mitglieder/ajax_mitglied_speichern",
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
            const element_id = AJAX.data.id;

            G.LISTEN["mitglieder"].tabelle[element_id] = new Object();
            $.each(AJAX.data, function (eigenschaft, wert) {
                if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME) Schnittstelle_VariableRein(wert, eigenschaft, element_id, "mitglieder");
            });

            Schnittstelle_EventVariableUpdLocalstorage("mitglieder", [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);

            AJAX.$btn.closest(".formular").modal("hide");

            Schnittstelle_DomToastFeuern(Liste_ElementBeschriftungZurueck(element_id, "mitglieder") + " erfolgreich gespeichert.");
        },
        rein_aktion: function (AJAX) {
            Schnittstelle_BtnWartenEnde(AJAX.$btn);
        },
    };

    Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
}
