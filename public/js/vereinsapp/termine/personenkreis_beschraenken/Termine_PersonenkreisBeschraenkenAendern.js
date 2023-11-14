function Termine_PersonenkreisBeschraenkenAendern($btn, liste) {
    const $personenkreis_beschraenken = $btn.parents(".personenkreis_beschraenken").first();

    const $verknuepfung = $btn.parents(".personenkreis_beschraenken_sammlung").first().find(".verknuepfung").first();
    const verknuepfung = $verknuepfung.attr("data-verknuepfung");

    if (verknuepfung == "&&") $verknuepfung.attr("data-verknuepfung", "||");
    else if (verknuepfung == "||") $verknuepfung.attr("data-verknuepfung", "&&");

    const filtern_mitglieder = Liste_Gib$Filtern2Filtern($personenkreis_beschraenken, "personenkreis_beschraenken", "mitglieder");
    const AJAX_DATA = {
        id: $personenkreis_beschraenken.attr("data-element_id"),
        filtern_mitglieder: JSON.stringify(filtern_mitglieder),
    };

    const neue_ajax_id = G.AJAX.length;
    G.AJAX[neue_ajax_id] = {
        id: "personenkreis beschraenken",
        url: liste + "/ajax_termin_personenkreis_beschraenken",
        data: AJAX_DATA,
        liste: liste,
        DOM: { $btn: $btn, btn_beschriftung: $btn.html() },
        rein_aktion: function (AJAX) {
            AJAX.DOM.$btn.addClass("invisible").prop("disabled", true).after(STATUS_SPINNER_HTML);
        },
        rein_validation_pos_aktion: function (AJAX) {
            const $personenkreis_beschraenken = AJAX.DOM.$btn.parents(".personenkreis_beschraenken").first();
            const filtern_mitglieder = Liste_Gib$Filtern2Filtern($personenkreis_beschraenken, "personenkreis_beschraenken", "mitglieder");
            LISTEN[AJAX.liste].tabelle[AJAX.data.id].filtern_mitglieder = filtern_mitglieder;
            $(document).trigger("VAR_upd_LOC", [AJAX.liste]); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR' );
        },
        rein_aktion: function (AJAX) {
            AJAX.DOM.$btn.removeClass("invisible").prop("disabled", false);
            AJAX.DOM.$btn.siblings("." + STATUS_SPINNER_CLASS).remove();
        },
    };

    Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
}
