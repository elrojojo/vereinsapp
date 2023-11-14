function Mitglieder_PermissionAendern($check, liste) {
    const $liste = $check.parents(".permissions").first();
    // const checkliste = $liste.attr("data-checkliste");
    const element = "permission";
    const gegen_element = $liste.attr("data-gegen_element");
    const aktion = $liste.attr("data-aktion");

    const AJAX_DATA = { checked: $check.is(":checked") };
    AJAX_DATA[element + "_id"] = $check.val();
    AJAX_DATA[gegen_element + "_id"] = $liste.attr("data-gegen_element_id");

    const neue_ajax_id = G.AJAX.length;
    G.AJAX[neue_ajax_id] = {
        id: element + "_" + aktion,
        url: liste + "/ajax_" + gegen_element + "_" + element + "_" + aktion + "",
        data: AJAX_DATA,
        liste: liste,
        DOM: { $check: $check, check_beschriftung: $check.siblings(".beschriftung").html() },
        raus_aktion: function (AJAX) {
            const $check_beschriftung = AJAX.DOM.$check.siblings(".beschriftung");
            $check_beschriftung.html(STATUS_SPINNER_HTML).addClass("text-primary");
        },
        rein_validation_pos_aktion: function (AJAX) {
            const $liste = AJAX.DOM.$check.parents(".permissions").first();
            const element = "permission";
            const element_id = AJAX.data[element + "_id"];
            const gegen_element = $liste.attr("data-gegen_element");
            const gegen_element_id = AJAX.data[gegen_element + "_id"];

            // bereits vorhandene identische Einträge in der Checkliste werden gelöscht
            $.each(LISTEN[AJAX.liste].tabelle[gegen_element_id].permissions, function (index, permission) {
                if (permission == element_id) delete LISTEN[AJAX.liste].tabelle[gegen_element_id].permissions[index];
            });

            // Falls der Haken gesetzt wurde, wird ein neuer Eintrag hinzugefügt
            if (
                !("permissions" in LISTEN[AJAX.liste].tabelle[gegen_element_id]) ||
                typeof LISTEN[AJAX.liste].tabelle[gegen_element_id].permissions !== "object"
            )
                LISTEN[AJAX.liste].tabelle[gegen_element_id].permissions = new Array();

            if (AJAX.data.checked) LISTEN[AJAX.liste].tabelle[gegen_element_id].permissions.push(element_id);

            $(document).trigger("VAR_upd_LOC", [AJAX.liste]); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR );
        },
        rein_aktion: function (AJAX) {
            const $check_beschriftung = AJAX.DOM.$check.siblings(".beschriftung");
            $check_beschriftung.html(AJAX.DOM.check_beschriftung).removeClass("text-primary");
        },
    };

    Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
}
