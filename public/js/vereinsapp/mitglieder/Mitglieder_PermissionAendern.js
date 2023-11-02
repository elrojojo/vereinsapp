function Mitglieder_PermissionAendern($check, liste) {
    const $check_beschriftung = $check.siblings(".beschriftung").closest();
    const check_beschriftung = $check_beschriftung.html();

    const $liste = $check.parents(".permissions").first();
    const aktion = $liste.attr("data-aktion");

    // const liste = $liste.attr('data-liste');
    // const LISTE = LISTEN[ liste ];
    const element = "permission";
    const element_id = $check.val();
    const checkliste = $liste.attr("data-checkliste");

    //const CHECKLISTE = LISTEN[ checkliste ];
    const check_element = element;
    const gegen_element = $liste.attr("data-gegen_element");
    const gegen_element_id = $liste.attr("data-gegen_element_id");

    const AJAX_DATA = { checked: $check.is(":checked") };
    AJAX_DATA[element + "_id"] = element_id;
    AJAX_DATA[gegen_element + "_id"] = gegen_element_id;

    // AJAX IN DIE SCHLANGE
    $.ajaxQueue({
        url: BASE_URL + "/" + liste + "/ajax_" + gegen_element + "_" + check_element + "_" + aktion + "",
        method: "post",
        data: AJAX_DATA,
        dataType: "json",
        beforeSend: function () {
            $check_beschriftung.html(STATUS_SPINNER_HTML).addClass("text-primary");
        },
        success: function (antwort) {
            G.CSRF[CSRF_NAME] = antwort[CSRF_NAME];

            if (typeof antwort.validation !== "undefined")
                console.log("FEHLER " + element + " " + aktion + ": validation -> " + JSON.stringify(antwort.validation));
            else {
                if (typeof antwort.info !== "undefined") console.log(JSON.stringify(antwort.info)); //console.log( 'ERFOLG '+element+' '+aktion );

                $.each(LISTEN[liste].tabelle[gegen_element_id].permissions, function (index, permission) {
                    if (permission == element_id) delete LISTEN[liste].tabelle[gegen_element_id].permissions[index];
                });

                if (
                    !("permissions" in LISTEN[liste].tabelle[gegen_element_id]) ||
                    typeof LISTEN[liste].tabelle[gegen_element_id].permissions !== "object"
                )
                    LISTEN[liste].tabelle[gegen_element_id].permissions = new Array();

                if (AJAX_DATA.checked) LISTEN[liste].tabelle[gegen_element_id].permissions.push(element_id);

                $(document).trigger("VAR_upd_LOC", [liste]); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR );
            }
        },
        error: function (xhr) {
            console.log("FEHLER " + element + " " + aktion + ": " + xhr.status + " " + xhr.statusText);
        },
        complete: function () {
            $check_beschriftung.html(check_beschriftung).removeClass("text-primary");
        },
    });
}
