function Schnittstelle_EventLocalstorageUpdVariable(liste, naechste_aktionen) {
    Schnittstelle_EventDurchfuehren(liste, naechste_aktionen, LocalstorageUpdVariable);
    function LocalstorageUpdVariable(liste) {
        if ("abhaengig_von" in G.LISTEN[liste])
            $.each(G.LISTEN[liste].abhaengig_von, function (prio, liste) {
                LocalstorageUpdVariable(liste, []);
            });

        // tabelle wird aus dem Localstorage geholt und in der Variable gespeichert
        const tabelle = new Array();
        let tabelle_LocalStorage = Schnittstelle_LocalstorageRausZurueck(liste + "_tabelle");
        if (typeof tabelle_LocalStorage === "undefined") tabelle_LocalStorage = new Array();
        $.each(tabelle_LocalStorage, function () {
            const element_id = this["id"];
            tabelle[element_id] = this;

            $.each(tabelle[element_id], function (eigenschaft, wert) {
                tabelle[element_id][eigenschaft] = Schnittstelle_VariableWertBereinigtZurueck(wert);
            });

            if ("element_ergaenzen_aktion" in G.LISTEN[liste] && typeof G.LISTEN[liste].element_ergaenzen_aktion === "function")
                G.LISTEN[liste].element_ergaenzen_aktion(tabelle[element_id]);
        });
        G.LISTEN[liste].tabelle = tabelle;
        G.LISTEN[liste].tmp = new Array();

        $.each(G.LISTEN[liste].instanz, function (instanz) {
            // filtern wird aus dem Localstorage geholt und in der Variable gespeichert
            let filtern_LocalStorage = Schnittstelle_LocalstorageRausZurueck(liste + "_" + instanz + "_filtern");
            if (typeof filtern_LocalStorage === "undefined") filtern_LocalStorage = new Array();
            G.LISTEN[liste].instanz[instanz].filtern = filtern_LocalStorage;
            function LOC_upd_VAR_filtern(filtern, liste) {
                $.each(filtern, function (index, knoten) {
                    if ("verknuepfung" in knoten) LOC_upd_VAR_filtern(knoten.filtern, liste);
                    else if ("operator" in knoten) knoten.wert = Schnittstelle_VariableWertBereinigtZurueck(knoten.wert);
                });
            }
            LOC_upd_VAR_filtern(G.LISTEN[liste].instanz[instanz].filtern, liste);

            // sortieren wird aus dem Localstorage geholt und in der Variable gespeichert
            let sortieren_LocalStorage = Schnittstelle_LocalstorageRausZurueck(liste + "_" + instanz + "_sortieren");
            if (typeof sortieren_LocalStorage === "undefined") sortieren_LocalStorage = new Array();
            G.LISTEN[liste].instanz[instanz].sortieren = sortieren_LocalStorage;
        });

        $.each(G.LISTEN[liste].auswertungen, function (auswertungen_instanz) {
            // sortieren wird aus dem Localstorage geholt und in der Variable gespeichert
            G.LISTEN[liste].auswertungen[auswertungen_instanz].eigenschaft = Schnittstelle_LocalstorageRausZurueck(
                liste + "_" + auswertungen_instanz + "_auswertungen_eigenschaft"
            );
        });
    }
}
