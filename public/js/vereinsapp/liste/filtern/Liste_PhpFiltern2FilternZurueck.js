function Liste_PhpFiltern2FilternZurueck(phpfiltern, liste) {
    const filtern = new Array();
    $.each(phpfiltern, function (index, knoten) {
        if ("verknuepfung" in knoten)
            filtern.push({
                verknuepfung: knoten.verknuepfung,
                filtern: Liste_PhpFiltern2FilternZurueck(knoten.filtern, liste),
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
