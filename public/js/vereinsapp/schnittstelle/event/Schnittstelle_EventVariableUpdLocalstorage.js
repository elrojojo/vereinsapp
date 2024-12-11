function Schnittstelle_EventVariableUpdLocalstorage(folgendes_event, data) {
    let liste;
    if ("liste" in data && data.liste in LISTEN) liste = data.liste;

    // tabelle wird vorbereitet
    const LOC_tabelle = new Array();
    $.each(LISTEN[liste].tabelle, function () {
        const element = this;
        if ("id" in element) {
            if ("alter" in element) delete element["alter"];
            if ("alter_geburtstag" in element) delete element["alter_geburtstag"];
            if ("geburtstag" in element) delete element["geburtstag"];
            if ("ich_rueckmeldung_id" in element) delete element["ich_rueckmeldung_id"];
            if ("ich_rueckgemeldet" in element) delete element["ich_rueckgemeldet"];
            if ("ich_eingeladen" in element) delete element["ich_eingeladen"];
            if ("filtern_mitglieder" in element) element["filtern_mitglieder"] = JSON.stringify(element["filtern_mitglieder"]);
            $.each(element, function (eigenschaft, wert) {
                element[eigenschaft] = Schnittstelle_LocalstorageWertBereinigtZurueck(wert);
            });
            LOC_tabelle.push(element);
        }
    });
    // tabelle wird im Localstorage gespeichert
    Schnittstelle_LocalstorageRein(liste + "_tabelle", LOC_tabelle);

    $.each(LISTEN[liste].instanz, function (instanz) {
        // filtern wird vorbereitet
        const LOC_filtern = new Array();
        if (LISTEN[liste].instanz[instanz].filtern.length >= 1) LOC_filtern.push(LISTEN[liste].instanz[instanz].filtern[0]);
        function VAR_upd_LOC_filtern(filtern, liste) {
            $.each(filtern, function (index, knoten) {
                if ("verknuepfung" in knoten) VAR_upd_LOC_filtern(knoten.filtern, liste);
                else if ("operator" in knoten) knoten.wert = Schnittstelle_LocalstorageWertBereinigtZurueck(knoten.wert);
            });
        }
        VAR_upd_LOC_filtern(LOC_filtern, liste);
        // filtern wird im Localstorage gespeichert
        if (LOC_filtern.length > 0) Schnittstelle_LocalstorageRein(liste + "_" + instanz + "_filtern", LOC_filtern);
        else Schnittstelle_LocalstorageLoeschen(liste + "_" + instanz + "_filtern");

        // sortieren wird vorbereitet
        const LOC_sortieren = LISTEN[liste].instanz[instanz].sortieren;
        // sortieren wird im Localstorage gespeichert
        if (LOC_sortieren.length > 0) Schnittstelle_LocalstorageRein(liste + "_" + instanz + "_sortieren", LOC_sortieren);
        else Schnittstelle_LocalstorageLoeschen(liste + "_" + instanz + "_sortieren");

        // gruppieren wird vorbereitet
        const LOC_gruppieren = LISTEN[liste].instanz[instanz].gruppieren;
        // gruppieren wird im Localstorage gespeichert
        if (typeof LOC_gruppieren !== "undefined") Schnittstelle_LocalstorageRein(liste + "_" + instanz + "_gruppieren", LOC_gruppieren);
        else Schnittstelle_LocalstorageLoeschen(liste + "_" + instanz + "_gruppieren");
    });

    if (typeof folgendes_event === "function" || (isArray(folgendes_event) && folgendes_event.length > 0))
        Schnittstelle_EventAusfuehren(folgendes_event, data);
}

function Schnittstelle_LocalstorageWertBereinigtZurueck(wert) {
    if (isLuxonDateTime(wert)) wert = wert.toSQL();
    else if (isNumber(wert)) wert = Number(wert);

    return wert;
}
