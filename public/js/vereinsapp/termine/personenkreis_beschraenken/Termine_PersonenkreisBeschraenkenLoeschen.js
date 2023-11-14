function Termine_PersonenkreisBeschraenkenLoeschen($btn, liste) {
    const $personenkreis_beschraenken = $btn.parents(".personenkreis_beschraenken").first();

    const element_id = $personenkreis_beschraenken.attr("data-element_id");

    const $element = $btn.parents(".personenkreis_beschraenken_element").first();

    const $sammlung = $btn.parents(".personenkreis_beschraenken_sammlung").first();

    let $knoten;
    if ($element.exists()) {
        $knoten = $element;
    } else $knoten = $sammlung;

    let $knoten_parallel = $knoten.siblings(".personenkreis_beschraenken_element, .personenkreis_beschraenken_sammlung");

    let $sammlung_ebene_hoeher = $knoten.parents(".personenkreis_beschraenken_sammlung").first();

    $knoten.remove();

    while ($knoten_parallel.length == 1) {
        const $knoten_ebene_hoeher = $sammlung_ebene_hoeher.siblings(".personenkreis_beschraenken_element, .personenkreis_beschraenken_sammlung");
        $sammlung_ebene_hoeher.replaceWith($knoten_parallel);
        $knoten_parallel = $knoten_ebene_hoeher;
        $sammlung_ebene_hoeher = $knoten_parallel.first().parents(".personenkreis_beschraenken_sammlung").first();
        // sammlung_ebene_hoeher = $knoten_parallel.first().parents('.personenkreis_beschraenken_sammlung').first();
    }

    const filtern_mitglieder = $personenkreis_beschraenken2filtern_mitglieder($personenkreis_beschraenken, "mitglieder");

    const AJAX_DATA = {
        id: element_id,
        filtern_mitglieder: JSON.stringify(filtern_mitglieder),
    };

    const neue_ajax_id = G.AJAX.length;
    G.AJAX[neue_ajax_id] = {
        id: "personenkreis beschraenken",
        url: liste + "/ajax_termin_personenkreis_beschraenken",
        data: AJAX_DATA,
        liste: liste,
        DOM: { $btn: $btn, btn_beschriftung: $btn.html() },
        raus_aktion: function (AJAX) {
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
