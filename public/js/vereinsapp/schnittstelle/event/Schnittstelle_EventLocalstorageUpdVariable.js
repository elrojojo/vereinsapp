function Schnittstelle_EventLocalstorageUpdVariable(liste, naechste_aktionen) {
    Schnittstelle_EventDurchfuehren(liste, naechste_aktionen, LocalstorageUpdVariable);
    function LocalstorageUpdVariable(liste) {
        if ("abhaengig_von" in G.LISTEN[liste])
            $.each(G.LISTEN[liste].abhaengig_von, function (prio, liste) {
                LocalstorageUpdVariable(liste, []);
            });

        // tabelle wird aus dem Localstorage geholt und in der Variable gespeichert
        const tabelle = new Array();
        $.each(Schnittstelle_LocalstorageRausZurueck(liste + "_tabelle", true), function () {
            const element_id = this["id"];
            tabelle[element_id] = this;

            $.each(tabelle[element_id], function (eigenschaft, wert) {
                tabelle[element_id][eigenschaft] = Schnittstelle_VariableWertBereinigtZurueck(wert);
            });

            if ("element_ergaenzen_aktion" in G.LISTEN[liste] && typeof G.LISTEN[liste].element_ergaenzen_aktion === "function")
                G.LISTEN[liste].element_ergaenzen_aktion(tabelle[element_id]);
        });
        G.LISTEN[liste].tabelle = tabelle;

        $.each(G.LISTEN[liste].instanz, function (instanz) {
            // sortieren wird aus dem Localstorage geholt und in der Variable gespeichert
            G.LISTEN[liste].instanz[instanz].sortieren = Schnittstelle_LocalstorageRausZurueck(liste + "_" + instanz + "_sortieren", true);

            // filtern wird aus dem Localstorage geholt und in der Variable gespeichert
            G.LISTEN[liste].instanz[instanz].filtern = Schnittstelle_LocalstorageRausZurueck(liste + "_" + instanz + "_filtern", true);
            function LOC_upd_VAR_filtern(filtern, liste) {
                $.each(filtern, function (index, knoten) {
                    if ("verknuepfung" in knoten) LOC_upd_VAR_filtern(knoten.filtern, liste);
                    else if ("operator" in knoten) knoten.wert = Schnittstelle_VariableWertBereinigtZurueck(knoten.wert);
                });
            }
            LOC_upd_VAR_filtern(G.LISTEN[liste].instanz[instanz].filtern, liste);
        });
    }
}
