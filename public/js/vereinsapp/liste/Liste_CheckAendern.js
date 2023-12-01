function Liste_CheckAendern($check, liste) {
    const $liste = $check.parents(".liste").first();
    const checkliste = $liste.attr("data-checkliste");
    const element = G.LISTEN[liste].element;
    const gegen_element = $liste.attr("data-gegen_element");
    const aktion = $liste.attr("data-aktion");

    const AJAX_DATA = { checked: $check.is(":checked") };
    AJAX_DATA[element + "_id"] = $check.val();
    AJAX_DATA[gegen_element + "_id"] = $liste.attr("data-gegen_element_id");

    const neue_ajax_id = G.AJAX.length;
    G.AJAX[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        label: element + "_" + aktion,
        url: G.LISTEN[checkliste].controller + "/ajax_" + G.LISTEN[checkliste].element + "_" + aktion,
        data: AJAX_DATA,
        liste: liste,
        $check: $check,
        raus_aktion: function (AJAX) {
            Schnittstelle_CheckWartenStart(AJAX.$check);
        },
        rein_validation_pos_aktion: function (AJAX) {
            const $liste = AJAX.$check.parents(".liste").first();
            const checkliste = $liste.attr("data-checkliste");
            const element = G.LISTEN[AJAX.liste].element;
            const element_id = AJAX.data[element + "_id"];
            const gegen_element = $liste.attr("data-gegen_element");
            const gegen_element_id = AJAX.data[gegen_element + "_id"];

            // bereits vorhandene identische Einträge in der Checkliste werden gelöscht
            $.each(G.LISTEN[checkliste].tabelle, function () {
                const checkliste_element = this;
                if ("id" in checkliste_element) {
                    if (checkliste_element[element + "_id"] == element_id && checkliste_element[gegen_element + "_id"] == gegen_element_id)
                        delete G.LISTEN[checkliste].tabelle[Number(checkliste_element["id"])];
                }
            });

            // Falls der Haken gesetzt wurde, wird ein neuer Eintrag hinzugefügt
            if (AJAX.data.checked) {
                AJAX.data.id = G.LISTEN[checkliste].tabelle.length + 1;
                G.LISTEN[checkliste].tabelle[AJAX.data.id] = new Object();
                delete AJAX.data.checked;
                $.each(AJAX.data, function (eigenschaft, wert) {
                    G.LISTEN[checkliste].tabelle[AJAX.data.id][eigenschaft] = Schnittstelle_VariableWertBereinigtZurueck(wert);
                });
            }

            Schnittstelle_EventVariableUpdLocalstorage(checkliste); // impliziert auch ein Schnittstelle_EventLocalstorageUpdVariable;
        },
        rein_aktion: function (AJAX) {
            Schnittstelle_CheckWartenEnde(AJAX.$check);
        },
    };

    Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
}
