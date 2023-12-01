function Schnittstelle_EventLocalstorageUpdVariable(liste) {
    // tabelle wird aus dem Localstorage geholt und in der Variable gespeichert
    G.LISTEN[liste].tabelle = new Array();
    $.each(Schnittstelle_LocalstorageRausZurueck(liste + "_tabelle", true), function () {
        const element_id = this["id"];
        G.LISTEN[liste].tabelle[element_id] = this;

        $.each(G.LISTEN[liste].tabelle[element_id], function (eigenschaft, wert) {
            G.LISTEN[liste].tabelle[element_id][eigenschaft] = Schnittstelle_VariableWertBereinigtZurueck(wert);
        });

        switch (liste) {
            case "mitglieder":
                Schnittstelle_EventElementErgaenzenMitglieder(G.LISTEN[liste].tabelle[element_id]);
                break;
            case "termine":
                Schnittstelle_EventElementErgaenzenTermine(G.LISTEN[liste].tabelle[element_id]);
                break;
            case "notenbank":
                Schnittstelle_EventElementErgaenzenNotenbank(G.LISTEN[liste].tabelle[element_id]);
                break;
        }
    });

    // sortieren wird aus dem Localstorage geholt und in der Variable gespeichert
    G.LISTEN[liste].sortieren = Schnittstelle_LocalstorageRausZurueck(liste + "_sortieren", true);

    // filtern wird aus dem Localstorage geholt und in der Variable gespeichert
    G.LISTEN[liste].filtern = Schnittstelle_LocalstorageRausZurueck(liste + "_filtern", true);
    function LOC_upd_VAR_filtern(filtern, liste) {
        $.each(filtern, function (index, knoten) {
            if ("verknuepfung" in knoten) LOC_upd_VAR_filtern(knoten.filtern, liste);
            else if ("operator" in knoten) knoten.wert = Schnittstelle_VariableWertBereinigtZurueck(knoten.wert);
        });
    }
    LOC_upd_VAR_filtern(G.LISTEN[liste].filtern, liste);

    Schnittstelle_EventVariableUpdDom(liste);
}
