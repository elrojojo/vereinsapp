function Liste_GibSqlFiltern2Filtern(phpfiltern, liste) {
    const filtern = new Array();

    $.each(phpfiltern, function (index, knoten) {
        if ("verknuepfung" in knoten) {
            const verknuepfung = knoten.verknuepfung;
            filtern.push({
                verknuepfung: verknuepfung,
                filtern: Liste_GibSqlFiltern2Filtern(knoten.filtern, liste),
            });
        } else {
            const operator = knoten.operator;
            const eigenschaft = knoten.eigenschaft;

            let wert = knoten.wert;
            if (wert && !Number.isNaN(Number(wert)) && typeof wert !== "boolean") wert = Number(wert);
            if (
                typeof EIGENSCHAFTEN[G.LISTEN[liste].controller][liste][eigenschaft] !== "undefined" &&
                EIGENSCHAFTEN[G.LISTEN[liste].controller][liste][eigenschaft]["typ"] == "zeitpunkt"
            )
                wert = DateTime.fromISO(wert);

            filtern.push({
                operator: operator,
                eigenschaft: eigenschaft,
                wert: wert,
            });
        }
    });

    return filtern;
}
