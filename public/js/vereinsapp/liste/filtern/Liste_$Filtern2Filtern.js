function $filtern2filtern($filtern, liste) {
    const filtern = new Array();

    $filtern.children(".filtern_element, .filtern_sammlung").each(function () {
        const $knoten = $(this);

        if ($knoten.hasClass("filtern_sammlung")) {
            const verknuepfung = $knoten.find(".verknuepfung").attr("data-verknuepfung");
            filtern.push({
                verknuepfung: verknuepfung,
                filtern: $filtern2filtern($knoten.find(".filtern_kind").first(), liste),
            });
        } else if ($knoten.hasClass("filtern_element")) {
            const operator = $knoten.find(".operator").attr("data-operator");
            const eigenschaft = $knoten.find(".eigenschaft").attr("data-eigenschaft");

            let wert = $knoten.find(".wert").attr("data-wert");
            if (wert && !Number.isNaN(Number(wert)) && typeof wert !== "boolean") wert = Number(wert);
            if (
                typeof EIGENSCHAFTEN[LISTEN[liste].controller][liste][eigenschaft] !== "undefined" &&
                EIGENSCHAFTEN[LISTEN[liste].controller][liste][eigenschaft]["typ"] == "zeitpunkt"
            )
                wert = DateTime.fromFormat(wert, SQL_DATETIME);

            filtern.push({
                operator: operator,
                eigenschaft: eigenschaft,
                wert: wert,
            });
        }
    });

    return filtern;
}
