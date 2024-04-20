function Mitglieder_PasswortFestlegen($btn) {
    if (typeof $btn === "undefined" || !$btn.exists()) {
        const neue_ajax_id = G.AJAX.length;
        G.AJAX[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "mitglieder/ajax_mitglied_passwort_festlegen_modal",
            rein_validation_pos_aktion: function (AJAX) {
                const $umgebung = $("#modals");
                const temp_id = zufaelligeZeichenketteZurueck(8);
                $umgebung.after('<div id="modal_' + temp_id + '"></div>');
                const $umgebung_temp = $umgebung.siblings("#modal_" + temp_id).first();
                $umgebung_temp.append(AJAX.antwort.html);
                $modal = $umgebung_temp.find(".modal").first();
                $umgebung_temp.remove();
                G.LISTEN["mitglieder"].modals["passwort_festlegen"] = $modal;
                Schnittstelle_DomModalOeffnen(Liste_ElementFormularInitialisiertZurueck("passwort_festlegen", "mitglieder", "passwort_festlegen"));
            },
        };
        Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
    } else {
        const AJAX_DATA = new Object();
        Liste_ElementFormularEigenschaftenWerteInAjaxData($btn.closest(".formular"), AJAX_DATA);
        AJAX_DATA.id = Number($btn.attr("data-element_id"));

        const neue_ajax_id = G.AJAX.length;
        G.AJAX[neue_ajax_id] = {
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
                Schnittstelle_DomModalSchliessen($("#mitglied_passwort_festlegen_modal"));
                Schnittstelle_DomToastFeuern("Du hast erfolgreich ein neues Password festgelegt.");
            },
            rein_aktion: function (AJAX) {
                Schnittstelle_BtnWartenEnde(AJAX.$btn);
            },
        };

        Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
    }
}
