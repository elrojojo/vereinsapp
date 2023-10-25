function Termine_PersonenkreisBeschraenkenAendern($btn, liste) {
    const $personenkreis_beschraenken = $btn
        .parents(".personenkreis_beschraenken")
        .first();
    const element_id = $personenkreis_beschraenken.attr("data-element_id");
    const $verknuepfung = $btn
        .parents(".personenkreis_beschraenken_sammlung")
        .first()
        .find(".verknuepfung")
        .first();
    const verknuepfung = $verknuepfung.attr("data-verknuepfung");

    if (verknuepfung == "&&") $verknuepfung.attr("data-verknuepfung", "||");
    else if (verknuepfung == "||")
        $verknuepfung.attr("data-verknuepfung", "&&");

    const filtern_mitglieder = $personenkreis_beschraenken2filtern_mitglieder(
        $personenkreis_beschraenken,
        "mitglieder"
    );
    const AJAX_DATA = {
        id: element_id,
        filtern_mitglieder: JSON.stringify(filtern_mitglieder),
    };

    // AJAX IN DIE SCHLANGE
    $.ajaxQueue({
        url: BASE_URL + "/" + liste + "/ajax_termin_personenkreis_beschraenken",
        method: "post",
        data: AJAX_DATA,
        dataType: "json",
        beforeSend: function () {
            $btn.addClass("invisible")
                .prop("disabled", true)
                .after(STATUS_SPINNER_HTML);
        },
        success: function (antwort) {
            $("#csrf_hash").val(antwort.csrf_hash);

            if (typeof antwort.validation !== "undefined")
                console.log(
                    "FEHLER personenkreis beschraenken: validation -> " +
                        JSON.stringify(antwort.validation)
                );
            else {
                if (typeof antwort.info !== "undefined")
                    console.log(JSON.stringify(antwort.info)); //console.log( 'ERFOLG '+element+' '+aktion );
                LISTEN[liste].tabelle[element_id].filtern_mitglieder =
                    filtern_mitglieder;
                $(document).trigger("VAR_upd_LOC", [liste]); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR' );
            }
        },
        error: function (xhr) {
            console.log(
                "FEHLER personenkreis beschraenken: " +
                    xhr.status +
                    " " +
                    xhr.statusText
            );
        },
        complete: function () {
            $btn.removeClass("invisible").prop("disabled", false);
            $btn.siblings("." + STATUS_SPINNER_CLASS).remove();
        },
    });
}
