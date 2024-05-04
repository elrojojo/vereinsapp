function Liste_ElementFormularInitialisiertZurueck(formular_id, liste, aktion, data) {
    if (typeof data === "undefined") data = new Object();

    if (!("title" in data)) data.title = undefined;
    const title = data.title;

    if (!("element_id" in data)) data.element_id = undefined;
    const element_id = data.element_id;

    // Formular als Modal generieren
    const $neues_formular = G.LISTEN[liste].modals[formular_id].clone().removeClass("blanko invisible").addClass("modal").addClass("formular");

    $neues_formular.find(".eigenschaft").each(function () {
        const $eigenschaft = $(this);
        const eigenschaft = $eigenschaft.attr("data-eigenschaft");

        // Wenn element_id definiert ist und es gerade um einen Button geht
        if (typeof element_id !== "undefined" && $eigenschaft.attr("type") == "button") $eigenschaft.attr("data-element_id", element_id);
        // else $eigenschaft.removeAttr("data-element_id");

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

    if (typeof title !== "undefined") $neues_formular.find(".modal-title").text(title);

    if (typeof element_id !== "undefined") $neues_formular.find(".beschriftung").text(Liste_ElementBeschriftungZurueck(element_id, liste));

    $neues_formular
        .find(".btn_" + G.LISTEN[liste].element + "_aktion")
        .addClass("btn_" + G.LISTEN[liste].element + "_" + aktion)
        .removeClass(".btn_" + G.LISTEN[liste].element + "_aktion");
    if (typeof element_id !== "undefined") $neues_formular.find(".btn_" + G.LISTEN[liste].element + "_" + aktion).attr("data-element_id", element_id);

    return $neues_formular;
}
