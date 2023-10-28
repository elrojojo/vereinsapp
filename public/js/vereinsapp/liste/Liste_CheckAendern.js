function Liste_CheckAendern($check, liste) {
    const $check_beschriftung = $check.siblings(".beschriftung");
    const check_beschriftung = $check_beschriftung.html();
    const $liste = $check.parents(".liste").first();
    const aktion = $liste.attr("data-aktion");

    const element = LISTEN[liste].element;
    const element_id = $check.val();
    const checkliste = $liste.attr("data-checkliste");
    const check_element = LISTEN[checkliste].element;
    const gegen_element = $liste.attr("data-gegen_element");
    const gegen_element_id = $liste.attr("data-gegen_element_id");

    const AJAX_DATA = { checked: $check.is(":checked") };
    AJAX_DATA[element + "_id"] = element_id;
    AJAX_DATA[gegen_element + "_id"] = gegen_element_id;

    // AJAX IN DIE SCHLANGE
    $.ajaxQueue({
        url: BASE_URL + "/" + LISTEN[checkliste].controller + "/ajax_" + check_element + "_" + aktion,
        method: "post",
        data: AJAX_DATA,
        dataType: "json",
        beforeSend: function () {
            $check_beschriftung.html(STATUS_SPINNER_HTML).addClass("text-primary");
        },
        success: function (antwort) {
            $("#csrf_hash").val(antwort.csrf_hash);

            if (typeof antwort.validation !== "undefined")
                console.log("FEHLER " + element + " " + aktion + ": validation -> " + JSON.stringify(antwort.validation));
            else {
                if (typeof antwort.info !== "undefined") console.log(JSON.stringify(antwort.info)); //console.log( 'ERFOLG '+element+' '+aktion );

                if (CSRF_NAME in AJAX_DATA) delete AJAX_DATA[CSRF_NAME];

                $.each(LISTEN[checkliste].tabelle, function () {
                    const element = this;
                    if ("id" in element) {
                        if (element[LISTEN[liste].element + "_id"] == element_id && element[gegen_element + "_id"] == gegen_element_id)
                            delete LISTEN[checkliste].tabelle[element["id"]];
                    }
                });

                if (AJAX_DATA.checked) {
                    AJAX_DATA["id"] = LISTEN[checkliste].tabelle.length + 1;
                    LISTEN[checkliste].tabelle[AJAX_DATA["id"]] = new Object();
                    delete AJAX_DATA.checked;
                    $.each(AJAX_DATA, function (eigenschaft, wert) {
                        if (wert && !Number.isNaN(Number(wert)) && typeof wert !== "boolean") wert = Number(wert);
                        LISTEN[checkliste].tabelle[AJAX_DATA["id"]][eigenschaft] = wert;
                    });
                }

                $(document).trigger("VAR_upd_LOC", [checkliste]); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR );
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
