function Liste_ElementFormularOeffnen($formular, $btn_oeffnend) {
    const aktion = $btn_oeffnend.attr("data-aktion");
    const liste = $btn_oeffnend.attr("data-liste");
    // const instanz = $btn_oeffnend.attr("data-instanz");
    const element = G.LISTEN[liste].element;
    let element_id = $btn_oeffnend.attr("data-element_id");

    $formular.find(".modal-title").text(bezeichnung_kapitalisieren(unix2umlaute(element)) + " " + unix2umlaute(aktion));
    $formular.find(".is-invalid").removeClass("is-invalid");
    $formular.find(".is-valid").removeClass("is-valid");

    $formular.find(".eigenschaft").each(function () {
        const $eigenschaft = $(this);
        const eigenschaft = $eigenschaft.attr("data-eigenschaft");

        let val;
        if (typeof element_id !== "undefined") val = G.LISTEN[liste].tabelle[element_id][eigenschaft];
        else val = EIGENSCHAFTEN[G.LISTEN[liste].controller][liste][eigenschaft].standard;

        if ($eigenschaft.attr("type") == "date") {
            if (typeof val !== "object") val = DateTime.fromFormat(val, SQL_DATETIME);
            val = val.toISODate();
        } else if ($eigenschaft.attr("type") == "time") {
            if (typeof val !== "object") val = DateTime.fromFormat(val, SQL_DATETIME);
            val = val.toISOTime({
                includeOffset: false,
                suppressSeconds: true,
                suppressMilliseconds: true,
            });
        }

        $eigenschaft.val(val).change();
    });

    // Speziell für aktion == "loeschen"
    $formular.find(".beschriftung").html(
        $('.element[data-liste="' + liste + '"][data-element_id="' + element_id + '"]')
            .find(".beschriftung")
            .html()
    );

    const $btn_schliessend = $formular.find('[class^="btn_"]');

    $btn_schliessend.attr("data-liste", liste).attr("data-aktion", aktion);
    if (typeof element_id !== "undefined" && aktion != "duplizieren") $btn_schliessend.attr("data-element_id", element_id);
    else $btn_schliessend.removeAttr("data-element_id");
}
