function Liste_AuswertungenAktualisieren($auswertungen, auswertungen) {
    const auswertungen_instanz = $auswertungen.attr("id");
    const INSTANZ = LISTEN[auswertungen].instanz[auswertungen_instanz];

    // STATUS_AUSWAHL DEFINIEREN
    let status_auswahl = $auswertungen.attr("data-status_auswahl");
    if (typeof status_auswahl !== "undefined") status_auswahl = JSON.parse(status_auswahl);
    else status_auswahl = new Object();
    status_auswahl[0] = undefined;

    // LISTE DEFINIEREN
    // liste_data aus data
    let liste_data = $auswertungen.attr("data-liste");
    if (typeof liste_data !== "undefined") liste_data = JSON.parse(liste_data);
    else liste_data = new Object();
    // liste aus liste_data
    let liste = undefined;
    if ("liste" in liste_data) liste = liste_data.liste;
    // gruppieren aus liste_data
    let gruppieren_data = undefined;
    if ("gruppieren" in liste_data) gruppieren_data = liste_data.gruppieren;
    // gruppieren aus LocalStorage
    const gruppieren_LocalStorage = LISTEN[liste].instanz[auswertungen_instanz].gruppieren;
    // gruppieren_data und gruppieren_LocalStorage kombinieren
    let gruppieren;
    if (typeof gruppieren_LocalStorage === "undefined") gruppieren = gruppieren_data;
    else gruppieren = gruppieren_LocalStorage;
    // filtern aus liste_data
    let liste_filtern_data = new Array();
    if ("filtern" in liste_data) liste_filtern_data = Schnittstelle_VariableArrayBereinigtZurueck(liste_data.filtern);
    // filtern aus LocalStorage
    const liste_filtern_LocalStorage = LISTEN[liste].instanz[auswertungen_instanz].filtern;
    // liste_filtern_data und liste_filtern_LocalStorage kombinieren
    let liste_filtern;
    if (liste_filtern_LocalStorage.length == 0) liste_filtern = liste_filtern_data;
    else if (liste_filtern_data.length == 0) liste_filtern = liste_filtern_LocalStorage;
    else liste_filtern = [{ verknuepfung: "&&", filtern: liste_filtern_data.concat(liste_filtern_LocalStorage) }];
    const tabelle_gefiltert = Liste_TabelleGefiltertZurueck(liste_filtern, liste);
    const tabelle_gefiltert_gruppiert = Liste_ArrayGruppiertZurueck(tabelle_gefiltert, gruppieren);

    // GEGEN_LISTE DEFINIEREN
    // gegen_liste_data aus data
    let gegen_liste_data = $auswertungen.attr("data-gegen_liste");
    if (typeof gegen_liste_data !== "undefined") gegen_liste_data = JSON.parse(gegen_liste_data);
    else gegen_liste_data = new Object();
    // gegen_liste aus gegen_liste_data
    let gegen_liste = undefined;
    if ("liste" in gegen_liste_data) gegen_liste = gegen_liste_data.liste;
    // gegen_liste_filtern aus gegen_liste_data
    let gegen_liste_filtern = new Array();
    if ("filtern" in gegen_liste_data) gegen_liste_filtern = Schnittstelle_VariableArrayBereinigtZurueck(gegen_liste_data.filtern);
    const gegen_tabelle_gefiltert = Liste_TabelleGefiltertZurueck(gegen_liste_filtern, gegen_liste);

    // AUSWERTUNGEN FILTERN
    // filtern für liste definieren
    const auswertungen_liste_filtern = { verknuepfung: "||", filtern: new Array() };
    $.each(tabelle_gefiltert, function () {
        auswertungen_liste_filtern.filtern.push({ operator: "==", eigenschaft: LISTEN[liste].element + "_id", wert: this.id });
    });
    // filtern für gegen_liste definieren
    const auswertungen_gegen_liste_filtern = { verknuepfung: "||", filtern: new Array() };
    $.each(gegen_tabelle_gefiltert, function () {
        auswertungen_gegen_liste_filtern.filtern.push({ operator: "==", eigenschaft: LISTEN[gegen_liste].element + "_id", wert: this.id });
    });
    // filtern für liste und filtern für gegen_liste kombinieren
    const auswertungen_filtern = [{ verknuepfung: "&&", filtern: [auswertungen_liste_filtern, auswertungen_gegen_liste_filtern] }];
    // auswertungen filtern
    const auswertungen_tabelle_gefiltert = Liste_TabelleGefiltertZurueck(auswertungen_filtern, auswertungen);

    // WERTE ZU GRUPPIEREN SORTIEREN
    const gruppieren_werte = Object.keys(tabelle_gefiltert_gruppiert);
    gruppieren_werte.sort();

    // CLUSTERN
    INSTANZ.cluster = new Object();
    // ergebnis vorbereiten
    INSTANZ.cluster.ergebnis = new Object();
    $.each(gruppieren_werte, function (position, wert) {
        INSTANZ.cluster.ergebnis[wert] = new Object();
        $.each(status_auswahl, function (status) {
            INSTANZ.cluster.ergebnis[wert][status] = new Array();
        });
    });
    // ergebnis_wert vorbereiten
    INSTANZ.cluster.ergebnis_wert = new Object();
    $.each(gruppieren_werte, function (position, wert) {
        INSTANZ.cluster.ergebnis_wert[wert] = new Array();
    });
    // ergebnis_status vorbereiten
    INSTANZ.cluster.ergebnis_status = new Object();
    $.each(status_auswahl, function (status) {
        INSTANZ.cluster.ergebnis_status[status] = new Array();
    });

    // ergebnis, ergebnis_wert und ergebnis_status clustern
    $.each(auswertungen_tabelle_gefiltert, function () {
        const auswertung = this;
        const status = auswertung.status;
        const element_id = auswertung[LISTEN[liste].element + "_id"];
        const wert = LISTEN[liste].tabelle[element_id][gruppieren];
        INSTANZ.cluster.ergebnis[wert][status].push(element_id);
        INSTANZ.cluster.ergebnis_status[status].push(element_id);
        INSTANZ.cluster.ergebnis_wert[wert].push(element_id);
    });
    // ergebnis[wert][0] clustern und in ergebnis_wert integrieren
    $.each(tabelle_gefiltert, function (position, element) {
        const element_id = element.id;
        const wert = LISTEN[liste].tabelle[element_id][gruppieren];
        if (!INSTANZ.cluster.ergebnis_wert[wert].includes(element_id)) {
            INSTANZ.cluster.ergebnis_wert[wert].push(element_id);
            INSTANZ.cluster.ergebnis_status[0].push(element_id);
            INSTANZ.cluster.ergebnis[wert][0].push(element_id);
        }
    });

    // DOM LÖSCHEN
    $auswertungen.find(".auswertung").each(function () {
        const $auswertung = $(this);
        const wert = $auswertung.attr("data-wert");
        if (!gruppieren_werte.includes(wert)) $auswertung.remove();
    });

    // DOM ERGÄNZEN
    $.each(gruppieren_werte, function (position, wert) {
        const $auswertung = $auswertungen.find('.auswertung[data-gruppieren="' + gruppieren + '"][data-wert="' + wert + '"]');
        if (!$auswertung.exists()) {
            const $neue_auswertung = LISTEN[auswertungen].instanz[auswertungen_instanz].$blanko_auswertung
                .clone()
                .removeClass("blanko invisible")
                .attr("data-auswertungen", auswertungen)
                .attr("data-instanz", auswertungen_instanz)
                .attr("data-liste", liste)
                .attr("data-gruppieren", gruppieren)
                .attr("data-wert", wert);

            const neue_id = zufaelligeZeichenketteZurueck(8);
            $neue_auswertung.find('[data-bs-toggle="collapse"]').attr("data-bs-target", "#auswertung_" + neue_id);
            $neue_auswertung.find(".toggle_symbol").attr("data-bs-target", "#auswertung_" + neue_id);
            $neue_auswertung.find(".collapse").attr("id", "auswertung_" + neue_id);

            if (position == 0) $neue_auswertung.appendTo($auswertungen);
            else
                $neue_auswertung.insertAfter(
                    $auswertungen.find('.auswertung[data-gruppieren="' + gruppieren + '"][data-wert="' + gruppieren_werte[position - 1] + '"]')
                );
        }
    });

    // ZUSAMMENFASSUNG
    $('.auswertung.zusammenfassung[data-instanz="' + auswertungen_instanz + '"]').each(function () {
        const $auswertung = $(this);
        $auswertung.attr("data-auswertungen", auswertungen).attr("data-liste", liste);
        $auswertung
            .find('[data-bs-toggle="collapse"]')
            .attr("data-bs-target", "#auswertung_" + auswertungen_instanz + "_" + gruppieren + "_zusammenfassung");
        $auswertung.find(".collapse").attr("id", "auswertung_" + auswertungen_instanz + "_" + gruppieren + "_zusammenfassung");
    });
}
