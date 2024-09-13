function Liste_ElementFormular_Init() {
    $(".formular").each(function () {
        const $formular = $(this);

        const liste = $formular.attr("data-liste");

        let element_id_data = $formular.attr("data-element_id");
        if (typeof element_id_data !== "undefined") element_id_data = Number(element_id_data);
        const element_id = element_id_data;

        $formular.find(".eigenschaft").each(function () {
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
    });
}
