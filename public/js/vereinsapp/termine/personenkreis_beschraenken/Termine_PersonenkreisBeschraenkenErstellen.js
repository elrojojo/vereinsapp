function Termine_PersonenkreisBeschraenkenErstellen($btn, liste) {
    const $formular = $btn.parents(".personenkreis_beschraenken_definition").first();

    const filtern_liste = $btn.parents("[data-filtern_liste]").first().attr("data-filtern_liste");

    const eigenschaft = $formular.attr("data-eigenschaft");

    const element_id = $btn.parents(".personenkreis_beschraenken_definitionen").first().attr("data-element_id");

    const filtern_eigenschaft = new Array();
    $formular.find(".personenkreis_beschraenken_wert").each(function () {
        const $personenkreis_beschraenken_wert = $(this);

        if ($personenkreis_beschraenken_wert.val()) {
            const operator = $personenkreis_beschraenken_wert.attr("data-operator");
            let wert = $personenkreis_beschraenken_wert.val();

            if (wert && !Number.isNaN(Number(wert)) && typeof wert !== "boolean") wert = Number(wert);
            if (
                typeof EIGENSCHAFTEN[LISTEN[filtern_liste].controller][filtern_liste][eigenschaft] !== "undefined" &&
                EIGENSCHAFTEN[LISTEN[filtern_liste].controller][filtern_liste][eigenschaft]["typ"] == "zeitpunkt"
            )
                wert = DateTime.fromISO(wert);
            filtern_eigenschaft.push({
                operator: operator,
                eigenschaft: eigenschaft,
                wert: wert,
            });
        }
    });

    let filtern_eigenschaft_knoten;
    if (filtern_eigenschaft.length == 1) filtern_eigenschaft_knoten = filtern_eigenschaft[0];
    else
        filtern_eigenschaft_knoten = {
            verknuepfung: "||",
            filtern: filtern_eigenschaft,
        };

    const filtern_mitglieder = LISTEN[liste].tabelle[element_id].filtern_mitglieder;

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
            const filtern_mitglieder = Liste_Gib$Filtern2Filtern($personenkreis_beschraenken, "personenkreis_beschraenken", "mitglieder");
            LISTEN[AJAX.liste].tabelle[AJAX.data.id].filtern_mitglieder = filtern_mitglieder;
            $(document).trigger("VAR_upd_LOC", [AJAX.liste]); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR' );
        },
        rein_aktion: function (AJAX) {
            Schnittstelle_BtnWartenEnde(AJAX.$btn);
        },
    };

    Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
}
