function Liste_PhpFiltern2Filtern(phpfiltern, liste) {
    const filtern = new Array();

    $.each(phpfiltern, function (index, knoten) {
        if ("verknuepfung" in knoten) {
            const verknuepfung = knoten.verknuepfung;
            filtern.push({
                verknuepfung: verknuepfung,
                filtern: Liste_PhpFiltern2Filtern(knoten.filtern, liste),
            });
        } else {
            const operator = knoten.operator;
            const eigenschaft = knoten.eigenschaft;

            let wert = knoten.wert;
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
