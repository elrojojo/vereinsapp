function Liste_ElementFormularOeffnen($formular, $btn_oeffnend) {
    let aktion, liste, element_id, gegen_element_id;

    if ($btn_oeffnend.exists()) {
        aktion = $btn_oeffnend.attr("data-aktion");
        liste = $btn_oeffnend.attr("data-liste");
        element_id = $btn_oeffnend.attr("data-element_id");
        gegen_element_id = $btn_oeffnend.attr("data-gegen_element_id");
    } else {
        aktion = $formular.attr("data-aktion");
        liste = $formular.attr("data-liste");
    }

    if (typeof liste !== "undefined") $formular.attr("data-liste", liste);
    if (typeof aktion !== "undefined") $formular.attr("data-aktion", aktion);

    $formular.find(".is-invalid").removeClass("is-invalid");
    $formular.find(".is-valid").removeClass("is-valid");

    $formular.find(".eigenschaft").each(function () {
        const $eigenschaft = $(this);
        const eigenschaft = $eigenschaft.attr("data-eigenschaft");

        // Wenn element_id definiert ist
        if (typeof element_id !== "undefined" && $eigenschaft.attr("type") == "button") $eigenschaft.attr("data-element_id", element_id);
        else $eigenschaft.removeAttr("data-element_id");

        let wert = Schnittstelle_VariableRausZurueck(eigenschaft, element_id, liste);
        // Wenn aber nichts definiert ist, dann nimm den Blanko-Wert (je nach Typ)
        if (typeof wert === "undefined")
            if ($eigenschaft.prop("tagName") == "SELECT") wert = $eigenschaft.find("option:first").val();
            else if ($eigenschaft.attr("type") == "date") wert = DateTime.now().plus({ days: 1 });
            else if ($eigenschaft.attr("type") == "time") wert = DateTime.now().plus({ minutes: 1 });
            else if ($eigenschaft.attr("type") == "datetime-local") wert = DateTime.now().plus({ minutes: 1 });
            else if ($eigenschaft.attr("type") == "button") wert = new Array();
            else wert = "";

        let wert_formatiert = wert;
        // Wenn aber die Eigenschaft ein Datum ist
        if ($eigenschaft.attr("type") == "date") wert_formatiert = wert.toISODate();
        // Oder wenn aber die Eigenschaft eine Uhrzeit ist
        else if ($eigenschaft.attr("type") == "time")
            wert_formatiert = wert.set({ seconds: 0, milliseconds: 0 }).toISOTime({
                includeOffset: false,
                suppressSeconds: true,
                suppressMilliseconds: true,
            });
        // Oder wenn aber die Eigenschaft ein Datum und eine Uhrzeit ist
        else if ($eigenschaft.attr("type") == "datetime-local")
            wert_formatiert = wert.set({ seconds: 0, milliseconds: 0 }).toISO({
                includeOffset: false,
                suppressSeconds: true,
                suppressMilliseconds: true,
            });
        // Oder wenn aber die Eigenschaft ein Objekt oder ein Array ist
        else if (isObject(wert) || Array.isArray(wert)) wert_formatiert = JSON.stringify(wert);

        $eigenschaft.val(wert_formatiert).change();
    });

    if (typeof liste !== "undefined" && typeof aktion !== "undefined")
        $formular.find(".btn_" + G.LISTEN[liste].element + "_aktion").addClass("btn_" + G.LISTEN[liste].element + "_" + aktion);
    if (typeof element_id !== "undefined")
        $formular
            .find(".btn_" + G.LISTEN[liste].element + "_aktion, .btn_" + G.LISTEN[liste].element + "_" + aktion)
            .attr("data-element_id", element_id);

    if (typeof gegen_element_id !== "undefined") $formular.find(".checkliste").attr("data-gegen_element_id", gegen_element_id);
    else $formular.find(".checkliste").removeAttr("data-gegen_element_id");
    Schnittstelle_EventVariableUpdDom(liste);
}
