function Schnittstelle_EventVariableUpdLocalstorage(liste) {
    // tabelle wird vorbereitet
    const LOC_tabelle = new Array();
    $.each(G.LISTEN[liste].tabelle, function () {
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
                element[eigenschaft] = Schnittstelle_LocalstorageWertBereinigtZurueck(wert);
            });
            LOC_tabelle.push(element);
        }
    });
    // tabelle wird im Localstorage gespeichert
    Schnittstelle_LocalstorageRein(liste + "_tabelle", JSON.stringify(LOC_tabelle));

    // sortieren wird vorbereitet
    const LOC_sortieren = G.LISTEN[liste].sortieren;
    // sortieren wird im Localstorage gespeichert
    Schnittstelle_LocalstorageRein(liste + "_sortieren", JSON.stringify(LOC_sortieren));

    // filtern wird vorbereitet
    const LOC_filtern = new Array();
    if (G.LISTEN[liste].filtern.length >= 1) LOC_filtern.push(G.LISTEN[liste].filtern[0]);
    function VAR_upd_LOC_filtern(filtern, liste) {
        $.each(filtern, function (index, knoten) {
            if ("verknuepfung" in knoten) VAR_upd_LOC_filtern(knoten.filtern, liste);
            else if ("operator" in knoten) knoten.wert = Schnittstelle_LocalstorageWertBereinigtZurueck(knoten.wert);
        });
    }
    VAR_upd_LOC_filtern(LOC_filtern, liste);
    // filtern wird im Localstorage gespeichert
    Schnittstelle_LocalstorageRein(liste + "_filtern", JSON.stringify(LOC_filtern));

    // Nachdem alles im Localstorage gespeichert ist, wird die Variable nochmal aktualisiert
    Schnittstelle_EventLocalstorageUpdVariable(liste);
}
