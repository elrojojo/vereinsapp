function Liste_ElementFormularOeffnen($formular, $btn_oeffnend) {
    const aktion = $btn_oeffnend.attr("data-aktion");
    const liste = $btn_oeffnend.attr("data-liste");
    // const instanz = $btn_oeffnend.attr("data-instanz");
    const element_id = $btn_oeffnend.attr("data-element_id");

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
            else if ($eigenschaft.attr("type") == "date") wert = DateTime.now();
            else if ($eigenschaft.attr("type") == "time") wert = DateTime.now();
            else if ($eigenschaft.attr("type") == "datetime-local") wert = DateTime.now();
            else if ($eigenschaft.attr("type") == "button") wert = new Array();
            else wert = "";

        let wert_formatiert = wert;
        // Wenn aber die Eigenschaft ein Datum ist
        if ($eigenschaft.attr("type") == "date") wert_formatiert = wert.toISODate();
        // Oder wenn aber die Eigenschaft eine Uhrzeit ist
        else if ($eigenschaft.attr("type") == "time")
            wert_formatiert = wert.set({ seconds: 0 }).toISOTime({
                includeOffset: false,
                suppressSeconds: true,
                suppressMilliseconds: true,
            });
        // Oder wenn aber die Eigenschaft ein Datum und eine Uhrzeit ist
        else if ($eigenschaft.attr("type") == "datetime-local")
            wert_formatiert = wert.set({ seconds: 0 }).toISO({
                includeOffset: false,
                suppressSeconds: true,
                suppressMilliseconds: true,
            });
        // Oder wenn aber die Eigenschaft ein Objekt oder ein Array ist
        else if (isObject(wert) || Array.isArray(wert)) wert_formatiert = JSON.stringify(wert);

        $eigenschaft.val(wert_formatiert).change();
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
