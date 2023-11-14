function Liste_CheckAendern($check, liste) {
    const $liste = $check.parents(".liste").first();
    const checkliste = $liste.attr("data-checkliste");
    const element = LISTEN[liste].element;
    const gegen_element = $liste.attr("data-gegen_element");
    const aktion = $liste.attr("data-aktion");

    const AJAX_DATA = { checked: $check.is(":checked") };
    AJAX_DATA[element + "_id"] = $check.val();
    AJAX_DATA[gegen_element + "_id"] = $liste.attr("data-gegen_element_id");

    const neue_ajax_id = G.AJAX.length;
    G.AJAX[neue_ajax_id] = {
        id: element + "_" + aktion,
        url: LISTEN[checkliste].controller + "/ajax_" + LISTEN[checkliste].element + "_" + aktion,
        data: AJAX_DATA,
        liste: liste,
        DOM: { $check: $check, check_beschriftung: $check.siblings(".beschriftung").html() },
        raus_aktion: function (AJAX) {
            const $check_beschriftung = AJAX.DOM.$check.siblings(".beschriftung");
            $check_beschriftung.html(STATUS_SPINNER_HTML).addClass("text-primary");
        },
        rein_validation_pos_aktion: function (AJAX) {
            const $liste = AJAX.DOM.$check.parents(".liste").first();
            const checkliste = $liste.attr("data-checkliste");
            const element = LISTEN[AJAX.liste].element;
            const element_id = AJAX.data[element + "_id"];
            const gegen_element = $liste.attr("data-gegen_element");
            const gegen_element_id = AJAX.data[gegen_element + "_id"];

            // bereits vorhandene identische Einträge in der Checkliste werden gelöscht
            $.each(LISTEN[checkliste].tabelle, function () {
                const checkliste_element = this;
                if ("id" in checkliste_element) {
                    if (checkliste_element[element + "_id"] == element_id && checkliste_element[gegen_element + "_id"] == gegen_element_id)
                        delete LISTEN[checkliste].tabelle[Number(checkliste_element["id"])];
                }
            });

            // Falls der Haken gesetzt wurde, wird ein neuer Eintrag hinzugefügt
            if (AJAX.data.checked) {
                AJAX.data.id = LISTEN[checkliste].tabelle.length + 1;
                LISTEN[checkliste].tabelle[AJAX.data.id] = new Object();
                delete AJAX.data.checked;
                $.each(AJAX.data, function (eigenschaft, wert) {
                    if (wert && !Number.isNaN(Number(wert)) && typeof wert !== "boolean") wert = Number(wert);
                    LISTEN[checkliste].tabelle[AJAX.data.id][eigenschaft] = wert;
                });
            }

            $(document).trigger("VAR_upd_LOC", [checkliste]); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR );
        },
        rein_aktion: function (AJAX) {
            const $check_beschriftung = AJAX.DOM.$check.siblings(".beschriftung");
            $check_beschriftung.html(AJAX.DOM.check_beschriftung).removeClass("text-primary");
        },
    };

    Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
}
