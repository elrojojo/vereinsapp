// LOC VOM SERVER AKTUALISIEREN
$(document).on("SQL_upd_LOC", async function (event, schleife, liste) {
    if (typeof schleife === "undefined") schleife = false;
    $.ajaxQueue({
        url: BASE_URL + "/" + LISTEN[liste].controller + "/ajax_" + liste,
        method: "post",
        data: {
            hash: sha256(String(localStorage.getItem("vereinsapp_" + liste + "_tabelle"))),
        },
        dataType: "json",
        beforeSend: function () {
            console.log(liste + " wird geladen");
        },
        success: function (antwort) {
            $("#csrf_hash").val(antwort.csrf_hash);
            localStorage.setItem("vereinsapp_" + liste + "_tabelle", JSON.stringify(antwort.tabelle));
            if (typeof antwort.info !== "undefined") console.log(JSON.stringify(antwort.info)); //console.log( 'ERFOLG SQL_upd_LOC_'+liste );
        },
        error: function (xhr) {
            console.log("FEHLER SQL_upd_LOC_" + liste + ": " + xhr.status + " " + xhr.statusText);
        },
        complete: function () {
            console.log(liste + " wurde geladen");
            $(document).trigger("LOC_upd_VAR", [liste]); // impliziert auch ein $(document).trigger( 'VAR_upd_DOM', [ liste ] );
            if (schleife)
                setTimeout(function () {
                    $(document).trigger("SQL_upd_LOC", [true, liste]);
                }, AJAX_REFRESH_INTERVALL * 1000);
        },
    });
});
