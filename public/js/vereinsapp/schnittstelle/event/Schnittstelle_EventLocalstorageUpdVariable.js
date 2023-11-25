function Schnittstelle_EventLocalstorageUpdVariable(liste) {
    // console.log("Schnittstelle_EventLocalstorageUpdVariable", "called", "with", liste);
    G.LISTEN[liste].tabelle = new Array();

    $.each(Schnittstelle_LocalstorageRausZurueck(liste + "_tabelle", true), function () {
        const element_id = this["id"];
        G.LISTEN[liste].tabelle[element_id] = this;

        $.each(G.LISTEN[liste].tabelle[element_id], function (eigenschaft, wert) {
            G.LISTEN[liste].tabelle[element_id][eigenschaft] = Schnittstelle_LocalstorageWertBereinigtZurueck(wert, eigenschaft, liste);
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

    G.LISTEN[liste].sortieren = Schnittstelle_LocalstorageRausZurueck(liste + "_sortieren", true);

    G.LISTEN[liste].filtern = Schnittstelle_LocalstorageRausZurueck(liste + "_filtern", true);
    function LOC_upd_VAR_filtern(filtern, liste) {
        $.each(filtern, function (index, knoten) {
            if ("verknuepfung" in knoten) LOC_upd_VAR_filtern(knoten.filtern, liste);
            else if ("operator" in knoten) knoten.wert = Schnittstelle_LocalstorageWertBereinigtZurueck(knoten.wert, knoten.eigenschaft, liste);
        });
    }
    LOC_upd_VAR_filtern(G.LISTEN[liste].filtern, liste);

    $(document).trigger("VAR_upd_DOM", [liste]);
}
