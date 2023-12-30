function Liste_TabelleGefiltertZurueck(filtern, liste) {
    function element_filtern(element, filtern, liste) {
        const sammler = new Array();

        $.each(filtern, function (position, knoten) {
            if ("verknuepfung" in knoten) {
                const sammler_knoten = element_filtern(element, knoten.filtern, liste);
                if (
                    (knoten.verknuepfung == "&&" && sammler_knoten.includes(false)) ||
                    (knoten.verknuepfung == "||" && !sammler_knoten.includes(true))
                )
                    sammler.push(false);
                else sammler.push(true);
            } else sammler.push((knoten.operator == "==" && element[knoten.eigenschaft] == knoten.wert) || (knoten.operator == "!=" && element[knoten.eigenschaft] != knoten.wert) || (knoten.operator == "<=" && element[knoten.eigenschaft] <= knoten.wert) || (knoten.operator == ">=" && element[knoten.eigenschaft] >= knoten.wert));
        });

        return sammler;
    }

    const tabelle_gefiltert = new Array();
    $.each(G.LISTEN[liste].tabelle, function () {
        const element = this;
        if ("id" in element) {
            if (filtern.length == 0 || element_filtern(element, filtern, liste)[0]) tabelle_gefiltert.push(element);
        }
    });

    return tabelle_gefiltert;
}
