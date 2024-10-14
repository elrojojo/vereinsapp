function Liste_AuswertungenAktualisieren($auswertungen, auswertungen) {
    const auswertungen_instanz = $auswertungen.attr("id");

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
    if (liste_filtern_LocalStorage.length === 0) liste_filtern = liste_filtern_data;
    else if (liste_filtern_data.length === 0) liste_filtern = liste_filtern_LocalStorage;
    else liste_filtern = [{ verknuepfung: "&&", filtern: [liste_filtern_data[0], liste_filtern_LocalStorage[0]] }];
    const liste_tabelle_gefiltert = Liste_TabelleGefiltertZurueck(liste_filtern, liste);

    // GEGEN_LISTE DEFINIEREN
    // gegen_liste aus data
    let gegen_liste = undefined;
    const gegen_liste_data = $auswertungen.attr("data-gegen_liste");
    if (typeof gegen_liste_data !== "undefined") gegen_liste = gegen_liste_data;
    // gegen_element_id aus data
    let gegen_element_id = undefined;
    const gegen_element_id_data = $auswertungen.attr("data-gegen_element_id");
    if (typeof gegen_element_id_data !== "undefined") gegen_element_id = gegen_element_id_data;

    // AUSWERTUNGEN FILTERN
    // filtern für liste definieren
    const auswertungen_liste_filtern = [{ verknuepfung: "||", filtern: new Array() }];
    $.each(liste_tabelle_gefiltert, function () {
        auswertungen_liste_filtern[0].filtern.push({ operator: "==", eigenschaft: LISTEN[liste].element + "_id", wert: this.id });
    });
    // filtern für gegen_liste definieren
    const auswertungen_gegen_liste_filtern = [
        { verknuepfung: "||", filtern: [{ operator: "==", eigenschaft: LISTEN[gegen_liste].element + "_id", wert: gegen_element_id }] },
    ];
    // filtern für liste und filtern für gegen_liste kombinieren und damit auswertungen filtern
    const auswertungen_tabelle_gefiltert = Liste_TabelleGefiltertZurueck(
        [{ verknuepfung: "&&", filtern: [auswertungen_liste_filtern[0], auswertungen_gegen_liste_filtern[0]] }],
        auswertungen
    );

    // WERTE ZU GRUPPIEREN SORTIEREN
    const gruppieren_werte = Object.keys(Liste_ArrayGruppiertZurueck(liste_tabelle_gefiltert, gruppieren));
    gruppieren_werte.sort();

    // ERGEBNIS DER AUSWERTUNGEN GLOBAL SPEICHERN
    LISTEN[auswertungen].instanz[auswertungen_instanz].auswertungen_ergebnis = Liste_AuswertungenErgebnisZurueck(
        auswertungen_tabelle_gefiltert,
        liste_tabelle_gefiltert,
        gruppieren,
        gruppieren_werte,
        status_auswahl,
        liste
    );

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
            const $neue_auswertung = LISTEN[auswertungen].instanz[auswertungen_instanz].$blanko_auswertung.clone().removeClass("blanko invisible");

            $neue_auswertung
                .attr("data-auswertungen", auswertungen)
                .attr("data-instanz", auswertungen_instanz)
                .attr("data-liste", liste)
                .attr("data-gruppieren", gruppieren)
                .attr("data-wert", wert);

            const neue_id = zufaelligeZeichenketteZurueck(8);
            $neue_auswertung.find('[data-bs-toggle="collapse"]').attr("data-bs-target", "#target_" + neue_id);
            $neue_auswertung.find(".toggle_symbol").attr("data-bs-target", "#target_" + neue_id);
            $neue_auswertung.find(".collapse").attr("id", "target_" + neue_id);

            if (position == 0) $neue_auswertung.appendTo($auswertungen);
            else
                $neue_auswertung.insertAfter(
                    $auswertungen.find('.auswertung[data-gruppieren="' + gruppieren + '"][data-wert="' + gruppieren_werte[position - 1] + '"]')
                );
        }
    });
}
