function VAR_upd_LOC(liste) {
    const LISTE = LISTEN[liste];

    const LOC_tabelle = new Array();
    $.each(LISTE.tabelle, function () {
        const element = this;
        if ("id" in element) {
            if ("alter" in element) delete element["alter"];
            if ("alter_geburtstag" in element) delete element["alter_geburtstag"];
            if ("geburtstag" in element) delete element["geburtstag"];
            if ("abwesend" in element) delete element["abwesend"];
            if ("ich_rueckmeldung_id" in element) delete element["ich_rueckmeldung_id"];
            if ("ich_eingeladen" in element) delete element["ich_eingeladen"];
            if ("filtern_mitglieder" in element) element["filtern_mitglieder"] = JSON.stringify(element["filtern_mitglieder"]);
            $.each(element, function (eigenschaft, wert) {
                if (wert && !Number.isNaN(Number(wert)) && typeof wert !== "boolean") element[eigenschaft] = Number(wert);
                if (
                    typeof EIGENSCHAFTEN[LISTE.controller][liste][eigenschaft] !== "undefined" &&
                    EIGENSCHAFTEN[LISTE.controller][liste][eigenschaft]["typ"] == "zeitpunkt"
                )
                    element[eigenschaft] = wert.toFormat(SQL_DATETIME);
            });
            LOC_tabelle.push(element);
        }
    });
    Schnittstelle_LocalstorageRein(liste + "_tabelle", JSON.stringify(LOC_tabelle));

    Schnittstelle_LocalstorageRein(liste + "_sortieren", JSON.stringify(LISTE.sortieren));

    const LOC_filtern = new Array();
    if (LISTE.filtern.length >= 1) LOC_filtern.push(LISTE.filtern[0]);
    function VAR_upd_LOC_filtern(filtern, liste) {
        const LISTE = LISTEN[liste];
        $.each(filtern, function (index, knoten) {
            if ("verknuepfung" in knoten) VAR_upd_LOC_filtern(knoten.filtern, liste);
            else if ("operator" in knoten) {
                const eigenschaft = knoten.eigenschaft;
                let wert = knoten.wert;
                if (
                    typeof EIGENSCHAFTEN[LISTE.controller][liste][eigenschaft] !== "undefined" &&
                    EIGENSCHAFTEN[LISTE.controller][liste][eigenschaft]["typ"] == "zeitpunkt"
                )
                    knoten.wert = wert.toFormat(SQL_DATETIME);
            }
        });
    }
    VAR_upd_LOC_filtern(LOC_filtern, liste);
    Schnittstelle_LocalstorageRein(liste + "_filtern", JSON.stringify(LOC_filtern));
}
