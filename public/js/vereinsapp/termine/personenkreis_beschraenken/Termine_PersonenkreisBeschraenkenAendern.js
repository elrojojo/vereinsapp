function Termine_PersonenkreisBeschraenkenAendern($btn, liste) {
    const $personenkreis_beschraenken = $btn.parents(".personenkreis_beschraenken").first();

    const $verknuepfung = $btn.parents(".personenkreis_beschraenken_sammlung").first().find(".verknuepfung").first();
    const verknuepfung = $verknuepfung.attr("data-verknuepfung");

    if (verknuepfung == "&&") $verknuepfung.attr("data-verknuepfung", "||");
    else if (verknuepfung == "||") $verknuepfung.attr("data-verknuepfung", "&&");

    const filtern_mitglieder = Liste_$Filtern2FilternZurueck($personenkreis_beschraenken, "personenkreis_beschraenken", "mitglieder");
    const AJAX_DATA = {
        id: $personenkreis_beschraenken.attr("data-element_id"),
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
        raus_aktion: function (AJAX) {
            Schnittstelle_BtnDanebenWartenStart(AJAX.$btn);
        },
        rein_validation_pos_aktion: function (AJAX) {
            const $personenkreis_beschraenken = AJAX.$btn.parents(".personenkreis_beschraenken").first();
            const filtern_mitglieder = Liste_$Filtern2FilternZurueck($personenkreis_beschraenken, "personenkreis_beschraenken", "mitglieder");
            G.LISTEN[AJAX.liste].tabelle[AJAX.data.id].filtern_mitglieder = filtern_mitglieder;
            Schnittstelle_EventVariableUpdLocalstorage(AJAX.liste); // impliziert auch ein Schnittstelle_EventLocalstorageUpdVariable
        },
        rein_aktion: function (AJAX) {
            Schnittstelle_BtnDanebenWartenEnde(AJAX.$btn);
        },
    };

    Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
}
