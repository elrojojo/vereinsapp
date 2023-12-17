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
        ajax_id: neue_ajax_id,
        label: "personenkreis beschraenken",
        url: liste + "/ajax_termin_personenkreis_beschraenken",
        data: AJAX_DATA,
        liste: liste,
        $btn: $btn,
        warten_auf: neue_ajax_id,
        raus_aktion: function (AJAX) {
            Schnittstelle_BtnDanebenWartenStart(AJAX.$btn);
        },
        rein_validation_pos_aktion: function (AJAX) {
            const $personenkreis_beschraenken = AJAX.$btn.parents(".personenkreis_beschraenken").first();
            const filtern_mitglieder = Liste_$Filtern2FilternZurueck($personenkreis_beschraenken, "personenkreis_beschraenken", "mitglieder");
            G.LISTEN[AJAX.liste].tabelle[AJAX.data.id].filtern_mitglieder = filtern_mitglieder;
            Schnittstelle_EventVariableUpdLocalstorage(AJAX.liste, [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);
        },
        rein_aktion: function (AJAX) {
            Schnittstelle_BtnDanebenWartenEnde(AJAX.$btn);
        },
    };

    Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
}
