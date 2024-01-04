function Liste_ElementFormularOeffnen($formular, $btn_oeffnend) {
    const aktion = $btn_oeffnend.attr("data-aktion");
    const titel = $btn_oeffnend.attr("data-titel");
    const liste = $btn_oeffnend.attr("data-liste");
    // const instanz = $btn_oeffnend.attr("data-instanz");
    const element_id = $btn_oeffnend.attr("data-element_id");

    $formular.find(".modal-title").text(titel);
    $formular.find(".is-invalid").removeClass("is-invalid");
    $formular.find(".is-valid").removeClass("is-valid");

    $formular.find(".eigenschaft").each(function () {
        const $eigenschaft = $(this);
        const eigenschaft = $eigenschaft.attr("data-eigenschaft");

        let val;
        // Wenn ein neues Element angelegt werden soll
        if (typeof element_id === "undefined")
            if ($eigenschaft.prop("tagName") == "SELECT") {
                val = $eigenschaft.find("option:first").val();
            } else if ($eigenschaft.attr("type") == "date") {
                val = DateTime.now();
            } else if ($eigenschaft.attr("type") == "time") {
                val = DateTime.now();
            } else if (eigenschaft == "filtern_mitglieder") {
                $eigenschaft.attr("data-instanz", "filtern_mitglieder_");
                val = new Array();
            } else {
                val = "";
            }
        // Wenn ein bestehendes Element geändert oder dupliziert werden soll
        else if (eigenschaft == "filtern_mitglieder") {
            $eigenschaft.attr("data-instanz", "filtern_mitglieder_" + element_id);
            val = G.LISTEN.mitglieder.instanz["filtern_mitglieder_" + element_id].filtern;
        } else {
            val = G.LISTEN[liste].tabelle[element_id][eigenschaft];
        }

        if ($eigenschaft.attr("type") == "date") {
            val = val.toISODate();
        } else if ($eigenschaft.attr("type") == "time") {
            val = val.set({ seconds: 0 }).toISOTime({
                includeOffset: false,
                suppressSeconds: true,
                suppressMilliseconds: true,
            });
        } else if (isObject(val) || Array.isArray(val)) val = JSON.stringify(val);
        $eigenschaft.val(val).change();
    });

    // Wenn ein bestehendes Element gelöscht werden soll
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
