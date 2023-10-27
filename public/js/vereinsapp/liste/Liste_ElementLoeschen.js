function Liste_ElementLoeschen($btn, liste) {
    const btn_beschriftung = $btn.html();
    const $formular = $btn.parents(".formular").first();
    const element = $btn.attr("data-element");
    const element_id = $btn.attr("data-element_id");

    $.ajaxQueue({
        url: BASE_URL + "/" + LISTEN[liste].controller + "/ajax_" + element + "_loeschen",
        method: "post",
        data: { [CSRF_NAME]: $("#csrf_hash").val(), id: element_id },
        dataType: "json",
        beforeSend: function () {
            $btn.html(STATUS_SPINNER_HTML).prop("disabled", true);
        },
        success: function (antwort) {
            $("#csrf_hash").val(antwort.csrf_hash);
            if (typeof antwort.validation !== "undefined")
                console.log("FEHLER " + element + " " + aktion + ": validation -> " + JSON.stringify(antwort.validation));
            else {
                if (typeof antwort.info !== "undefined") console.log(JSON.stringify(antwort.info)); //console.log( 'ERFOLG '+element+' '+aktion );
                delete LISTEN[liste].tabelle[element_id];
                $(document).trigger("VAR_upd_LOC", [liste]); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR' );
                $formular.modal("hide");
            }
        },
        error: function (xhr) {
            console.log("FEHLER " + element + " " + aktion + ": " + xhr.status + " " + xhr.statusText);
        },
        complete: function () {
            $btn.html(btn_beschriftung).prop("disabled", false);
        },
    });
}
