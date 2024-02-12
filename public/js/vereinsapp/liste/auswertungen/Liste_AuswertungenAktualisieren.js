function Liste_AuswertungenAktualisieren($auswertungen, auswertungen) {
    const auswertungen_instanz = $auswertungen.attr("id");

    // STATUS_AUSWAHL DEFINIEREN
    let status_auswahl = $auswertungen.attr("data-status_auswahl");
    if (typeof status_auswahl !== "undefined") status_auswahl = JSON.parse(status_auswahl);
    else status_auswahl = new Object();
    status_auswahl[0] = undefined;

    // LISTE DEFINIEREN
    // liste aus data
    let liste_data = $auswertungen.attr("data-liste");
    if (typeof liste_data !== "undefined") liste_data = JSON.parse(liste_data);
    else liste_data = new Object();
    // liste aus liste_data
    let liste = undefined;
    if ("liste" in liste_data) liste = liste_data.liste;
    // eigenschaft aus liste_data
    let eigenschaft_data = undefined;
    if ("eigenschaft" in liste_data) eigenschaft_data = liste_data.eigenschaft;
    // eigenschaft aus LocalStorage
    const eigenschaft_LocalStorage = G.LISTEN[auswertungen].auswertungen[auswertungen_instanz].eigenschaft;
    // eigenschaft_data und eigenschaft_LocalStorage kombinieren
    let eigenschaft;
    if (typeof eigenschaft_LocalStorage === "undefined") eigenschaft = eigenschaft_data;
    else eigenschaft = eigenschaft_LocalStorage;
    // filtern aus liste_data
    let liste_filtern = new Array();
    if ("filtern" in liste_data) liste_filtern = Liste_SqlFiltern2FilternZurueck(liste_data.filtern, liste);
    const tabelle_gefiltert = Liste_TabelleGefiltertZurueck(liste_filtern, liste);

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
    if ("filtern" in gegen_liste_data) gegen_liste_filtern = Liste_SqlFiltern2FilternZurueck(gegen_liste_data.filtern, gegen_liste);
    const gegen_tabelle_gefiltert = Liste_TabelleGefiltertZurueck(gegen_liste_filtern, gegen_liste);

    // AUSWERTUNGEN FILTERN
    // filtern für liste definieren
    const auswertungen_liste_filtern = { verknuepfung: "||", filtern: new Array() };
    const eigenschaft_werte = new Array();
    $.each(tabelle_gefiltert, function () {
        const element = this;
        auswertungen_liste_filtern.filtern.push({ operator: "==", eigenschaft: G.LISTEN[liste].element + "_id", wert: element.id });
        // werte zur eigenschaft sammeln
        if (!eigenschaft_werte.includes(element[eigenschaft])) eigenschaft_werte.push(element[eigenschaft]);
    });
    // filtern für gegen_liste definieren
    const auswertungen_gegen_liste_filtern = { verknuepfung: "||", filtern: new Array() };
    $.each(gegen_tabelle_gefiltert, function () {
        const element = this;
        auswertungen_gegen_liste_filtern.filtern.push({ operator: "==", eigenschaft: G.LISTEN[gegen_liste].element + "_id", wert: element.id });
    });
    // filtern für liste und filtern für gegen_liste kombinieren
    const auswertungen_filtern = [{ verknuepfung: "&&", filtern: [auswertungen_liste_filtern, auswertungen_gegen_liste_filtern] }];
    // auswertungen filtern
    const auswertungen_tabelle_gefiltert = Liste_TabelleGefiltertZurueck(auswertungen_filtern, auswertungen);

    // WERTE ZUR EIGENSCHAFT SORTIEREN
    eigenschaft_werte.sort();

    // CLUSTERN
    // ergebnis vorbereiten
    G.LISTEN[auswertungen].auswertungen[auswertungen_instanz].cluster.ergebnis = new Object();
    $.each(eigenschaft_werte, function (position, wert) {
        G.LISTEN[auswertungen].auswertungen[auswertungen_instanz].cluster.ergebnis[wert] = new Object();
        $.each(status_auswahl, function (status) {
            G.LISTEN[auswertungen].auswertungen[auswertungen_instanz].cluster.ergebnis[wert][status] = new Array();
        });
    });
    // ergebnis_wert vorbereiten
    G.LISTEN[auswertungen].auswertungen[auswertungen_instanz].cluster.ergebnis_wert = new Object();
    $.each(eigenschaft_werte, function (position, wert) {
        G.LISTEN[auswertungen].auswertungen[auswertungen_instanz].cluster.ergebnis_wert[wert] = new Array();
    });
    // ergebnis_status vorbereiten
    G.LISTEN[auswertungen].auswertungen[auswertungen_instanz].cluster.ergebnis_status = new Object();
    $.each(status_auswahl, function (status) {
        G.LISTEN[auswertungen].auswertungen[auswertungen_instanz].cluster.ergebnis_status[status] = new Array();
    });

    // ergebnis, ergebnis_wert und ergebnis_status clustern
    $.each(auswertungen_tabelle_gefiltert, function () {
        const auswertung = this;
        const status = auswertung.status;
        const element_id = auswertung[G.LISTEN[liste].element + "_id"];
        const wert = G.LISTEN[liste].tabelle[element_id][eigenschaft];
        G.LISTEN[auswertungen].auswertungen[auswertungen_instanz].cluster.ergebnis[wert][status].push(element_id);
        G.LISTEN[auswertungen].auswertungen[auswertungen_instanz].cluster.ergebnis_status[status].push(element_id);
        G.LISTEN[auswertungen].auswertungen[auswertungen_instanz].cluster.ergebnis_wert[wert].push(element_id);
    });
    // ergebnis[wert][0] clustern und in ergebnis_wert integrieren
    $.each(tabelle_gefiltert, function (position, element) {
        const element_id = element.id;
        const wert = G.LISTEN[liste].tabelle[element_id][eigenschaft];
        if (!G.LISTEN[auswertungen].auswertungen[auswertungen_instanz].cluster.ergebnis_wert[wert].includes(element_id)) {
            G.LISTEN[auswertungen].auswertungen[auswertungen_instanz].cluster.ergebnis_wert[wert].push(element_id);
            G.LISTEN[auswertungen].auswertungen[auswertungen_instanz].cluster.ergebnis_status[0].push(element_id);
            G.LISTEN[auswertungen].auswertungen[auswertungen_instanz].cluster.ergebnis[wert][0].push(element_id);
        }
    });

    // DOM LÖSCHEN
    $auswertungen.find('.auswertung[data-eigenschaft="' + eigenschaft + '"]').each(function () {
        const $auswertung = $(this);
        if (typeof $auswertung.attr("data-wert") === "undefined" || !eigenschaft_werte.includes($auswertung.attr("data-wert"))) $auswertung.remove();
    });

    // DOM ERGÄNZEN
    $.each(eigenschaft_werte, function (position, wert) {
        const $auswertung = $auswertungen.find('.auswertung[data-eigenschaft="' + eigenschaft + '"][data-wert="' + wert + '"]');
        if (!$auswertung.exists()) {
            const $neue_auswertung = G.LISTEN[auswertungen].auswertungen[auswertungen_instanz].$blanko_auswertung
                .clone()
                .removeClass("blanko invisible")
                .attr("data-auswertungen", auswertungen)
                .attr("data-instanz", auswertungen_instanz)
                .attr("data-eigenschaft", eigenschaft)
                .attr("data-wert", wert);

            $neue_auswertung
                .find('[data-bs-toggle="collapse"]')
                .attr("data-bs-target", "#auswertung_" + auswertungen_instanz + "_" + eigenschaft + "_" + wert);

            $neue_auswertung.find(".collapse").attr("id", "auswertung_" + auswertungen_instanz + "_" + eigenschaft + "_" + wert);

            if (position == 0) $neue_auswertung.appendTo($auswertungen);
            else
                $neue_auswertung.insertAfter(
                    $auswertungen.find('.auswertung[data-eigenschaft="' + eigenschaft + '"][data-wert="' + eigenschaft_werte[position - 1] + '"]')
                );
        }
    });

    // ZUSAMMENFASSUNG
    $('.auswertung.zusammenfassung[data-instanz="' + auswertungen_instanz + '"]').each(function () {
        const $auswertung = $(this);
        $auswertung.attr("data-auswertungen", auswertungen);
        $auswertung
            .find('[data-bs-toggle="collapse"]')
            .attr("data-bs-target", "#auswertung_" + auswertungen_instanz + "_" + eigenschaft + "_zusammenfassung");
        $auswertung.find(".collapse").attr("id", "auswertung_" + auswertungen_instanz + "_" + eigenschaft + "_zusammenfassung");
    });
}
