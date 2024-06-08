function Liste_ElementFormularEigenschaftenWerteInAjaxData($formular, ajax_data) {
    $formular.find(".eigenschaft").each(function () {
        const $eigenschaft = $(this);
        const eigenschaft = $eigenschaft.attr("data-eigenschaft");

        let wert = $eigenschaft.val();
        // Wenn aber die Eigenschaft ein Datum, ein Uhrzeit oder ein Datum und eine Uhrzeit ist
        if (["date", "time", "datetime-local"].includes($eigenschaft.attr("type"))) {
            wert = DateTime.fromISO(wert);
            if (eigenschaft == "ende") wert = wert.plus({ days: 1 }).minus({ seconds: 1 });
            wert = wert.toSQL();
        }
        // Wenn aber die Eigenschaft eine Zahl ist
        else if (isNumber(wert)) wert = Number(wert);

        ajax_data[eigenschaft] = wert;

        $eigenschaft.removeClass("is-valid").removeClass("is-invalid");
        $eigenschaft.find(".valid-tooltip").remove();
        $eigenschaft.find(".invalid-tooltip").remove();
    });
}
