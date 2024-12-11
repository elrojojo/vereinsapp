function Schnittstelle_EventLocalstorageUpdVariable(folgendes_event, data) {
    let liste;
    if ("liste" in data && data.liste in LISTEN) liste = data.liste;

    if ("abhaengig_von" in LISTEN[liste])
        $.each(LISTEN[liste].abhaengig_von, function (prio, liste) {
            Schnittstelle_EventAusfuehren(Schnittstelle_EventLocalstorageUpdVariable, { liste: liste });
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

        if ("element_ergaenzen_aktion" in LISTEN[liste] && typeof LISTEN[liste].element_ergaenzen_aktion === "function")
            LISTEN[liste].element_ergaenzen_aktion(tabelle[element_id]);
    });
    LISTEN[liste].tabelle = tabelle;

    $.each(LISTEN[liste].instanz, function (instanz) {
        // filtern wird aus dem Localstorage geholt und in der Variable gespeichert
        let filtern_LocalStorage = Schnittstelle_LocalstorageRausZurueck(liste + "_" + instanz + "_filtern");
        if (typeof filtern_LocalStorage === "undefined") filtern_LocalStorage = new Array();
        LISTEN[liste].instanz[instanz].filtern = filtern_LocalStorage;
        function LOC_upd_VAR_filtern(filtern, liste) {
            $.each(filtern, function (index, knoten) {
                if ("verknuepfung" in knoten) LOC_upd_VAR_filtern(knoten.filtern, liste);
                else if ("operator" in knoten) knoten.wert = Schnittstelle_VariableWertBereinigtZurueck(knoten.wert);
            });
        }
        LOC_upd_VAR_filtern(LISTEN[liste].instanz[instanz].filtern, liste);

        // sortieren wird aus dem Localstorage geholt und in der Variable gespeichert
        let sortieren_LocalStorage = Schnittstelle_LocalstorageRausZurueck(liste + "_" + instanz + "_sortieren");
        if (typeof sortieren_LocalStorage === "undefined") sortieren_LocalStorage = new Array();
        LISTEN[liste].instanz[instanz].sortieren = sortieren_LocalStorage;

        // gruppieren wird aus dem Localstorage geholt und in der Variable gespeichert
        LISTEN[liste].instanz[instanz].gruppieren = Schnittstelle_LocalstorageRausZurueck(liste + "_" + instanz + "_gruppieren");
    });

    if (typeof folgendes_event === "function" || (isArray(folgendes_event) && folgendes_event.length > 0))
        Schnittstelle_EventAusfuehren(folgendes_event, data);
}
