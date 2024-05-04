function Liste_SqlFiltern2FilternZurueck(sqlfiltern, liste) {
    const filtern = new Array();
    $.each(sqlfiltern, function (index, knoten) {
        if ("verknuepfung" in knoten)
            filtern.push({
                verknuepfung: knoten.verknuepfung,
                filtern: Liste_SqlFiltern2FilternZurueck(knoten.filtern, liste),
            });
        else
            filtern.push({
                operator: knoten.operator,
                eigenschaft: knoten.eigenschaft,
                wert: Schnittstelle_VariableWertBereinigtZurueck(knoten.wert),
            });
    });

    return filtern;
}
