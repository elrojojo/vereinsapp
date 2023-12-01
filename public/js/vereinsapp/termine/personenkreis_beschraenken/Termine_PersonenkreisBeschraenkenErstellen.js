function Termine_PersonenkreisBeschraenkenErstellen($btn, liste) {
    const $formular = $btn.parents(".personenkreis_beschraenken_definition").first();
    const element_id = $btn.parents(".personenkreis_beschraenken_definitionen").first().attr("data-element_id");

    const filtern_eigenschaft = new Array();
    $formular.find(".personenkreis_beschraenken_wert").each(function () {
        const $personenkreis_beschraenken_wert = $(this);
        if ($personenkreis_beschraenken_wert.val())
            filtern_eigenschaft.push({
                operator: $personenkreis_beschraenken_wert.attr("data-operator"),
                eigenschaft: $formular.attr("data-eigenschaft"),
                wert: Schnittstelle_VariableWertBereinigtZurueck($personenkreis_beschraenken_wert.val()),
            });
    });

    let filtern_eigenschaft_knoten;
    if (filtern_eigenschaft.length == 1) filtern_eigenschaft_knoten = filtern_eigenschaft[0];
    else
        filtern_eigenschaft_knoten = {
            verknuepfung: "||",
            filtern: filtern_eigenschaft,
        };

    const filtern_mitglieder = G.LISTEN[liste].tabelle[element_id].filtern_mitglieder;

    if (filtern_mitglieder.length == 0) filtern_mitglieder.push(filtern_eigenschaft_knoten);
    else {
        if ("verknuepfung" in filtern_mitglieder[0]) filtern_mitglieder[0].filtern.push(filtern_eigenschaft_knoten);
        else {
            const einziges_element = filtern_mitglieder[0];
            filtern_mitglieder[0] = {
                verknuepfung: "||",
                filtern: new Array(),
            };
            filtern_mitglieder[0].filtern.push(einziges_element);
            filtern_mitglieder[0].filtern.push(filtern_eigenschaft_knoten);
        }
    }

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
        raus_aktion: function (AJAX) {
            Schnittstelle_BtnWartenStart(AJAX.$btn);
        },
        rein_validation_pos_aktion: function (AJAX) {
            const $personenkreis_beschraenken = AJAX.$btn.parents(".personenkreis_beschraenken").first();
            const filtern_mitglieder = Liste_$Filtern2FilternZurueck($personenkreis_beschraenken, "personenkreis_beschraenken", "mitglieder");
            G.LISTEN[AJAX.liste].tabelle[AJAX.data.id].filtern_mitglieder = filtern_mitglieder;
            Schnittstelle_EventVariableUpdLocalstorage(AJAX.liste, [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);
        },
        rein_aktion: function (AJAX) {
            Schnittstelle_BtnWartenEnde(AJAX.$btn);
        },
    };

    Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
}
