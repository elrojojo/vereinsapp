function Liste_CheckAendern($check) {
    const $liste = $check.closest(".liste");
    const liste = $liste.attr("data-liste");
    const checkliste = $liste.attr("data-checkliste");
    const element = G.LISTEN[liste].element;
    const gegen_element = G.LISTEN[$liste.attr("data-gegen_liste")].element;
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
            const $liste = AJAX.$check.closest(".liste");
            const checkliste = $liste.attr("data-checkliste");
            const element = G.LISTEN[AJAX.liste].element;
            const element_id = AJAX.data[element + "_id"];
            const gegen_element = G.LISTEN[$liste.attr("data-gegen_liste")].element;
            const gegen_element_id = AJAX.data[gegen_element + "_id"];

            // bereits vorhandene identische Einträge in der Checkliste werden gelöscht
            $.each(G.LISTEN[checkliste].tabelle, function () {
                const checkliste_element = this;
                if ("id" in checkliste_element) {
                    if (checkliste_element[element + "_id"] == element_id && checkliste_element[gegen_element + "_id"] == gegen_element_id)
                        Schnittstelle_VariableLoeschen(checkliste_element["id"], checkliste);
                }
            });

            // Falls der Haken gesetzt wurde, wird ein neuer Eintrag hinzugefügt
            if (AJAX.data.checked) {
                AJAX.data.id = G.LISTEN[checkliste].tabelle.length;
                G.LISTEN[checkliste].tabelle[AJAX.data.id] = new Object();
                delete AJAX.data.checked;
                $.each(AJAX.data, function (eigenschaft, wert) {
                    Schnittstelle_VariableRein(wert, eigenschaft, Number(AJAX.data.id), checkliste);
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
