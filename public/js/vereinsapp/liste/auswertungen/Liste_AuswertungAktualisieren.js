function Liste_AuswertungAktualisieren($auswertung, auswertungen) {
    const auswertungen_instanz = $auswertung.attr("data-instanz");
    const $auswertungen = $('.auswertungen[id="' + auswertungen_instanz + '"]');
    const gruppieren = $auswertung.attr("data-gruppieren");
    const wert = $auswertung.attr("data-wert");

    // LISTE DEFINIEREN
    // liste aus data
    let liste_data = $auswertungen.attr("data-liste");
    if (typeof liste_data !== "undefined") liste_data = JSON.parse(liste_data);
    else liste_data = new Object();
    // liste aus liste_data
    let liste = undefined;
    if ("liste" in liste_data) liste = liste_data.liste;

    // ZUSAMMENFASSUNG ERKENNEN
    let zusammenfassung = false;
    if ($auswertung.hasClass("zusammenfassung")) zusammenfassung = true;

    // BESCHRIFTUNG AKTUALISIEREN
    if (!zusammenfassung) $auswertung.find(".beschriftung").text(Liste_WertFormatiertZurueck(wert, gruppieren, liste));

    // ERGEBNIS_ANZAHL AKTUALISIEREN
    $auswertung.find(".ergebnis_anzahl").each(function () {
        const $ergebnis_anzahl = $(this);
        const status = $ergebnis_anzahl.attr("data-status");

        let ergebnis_anzahl, ergebnis_referenz_anzahl;
        if (zusammenfassung) {
            ergebnis_anzahl = LISTEN[auswertungen].instanz[auswertungen_instanz].cluster.ergebnis_status[status].length;
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
            ergebnis_referenz_anzahl = Liste_TabelleGefiltertZurueck(liste_filtern, liste).length;
        } else {
            ergebnis_anzahl = LISTEN[auswertungen].instanz[auswertungen_instanz].cluster.ergebnis[wert][status].length;
            ergebnis_referenz_anzahl = LISTEN[auswertungen].instanz[auswertungen_instanz].cluster.ergebnis_wert[wert].length;
        }

        if ($ergebnis_anzahl.hasClass("progress"))
            $ergebnis_anzahl.attr("style", "width: " + (ergebnis_anzahl / ergebnis_referenz_anzahl) * 100 + "%");
        else $ergebnis_anzahl.text(ergebnis_anzahl);
    });

    // ERGEBNIS AKTUALISIEREN
    $auswertung.find(".ergebnis").each(function () {
        const $ergebnis = $(this);
        const status = $ergebnis.attr("data-status");

        let ergebnis;
        if (zusammenfassung) ergebnis = LISTEN[auswertungen].instanz[auswertungen_instanz].cluster.ergebnis_status[status];
        else ergebnis = LISTEN[auswertungen].instanz[auswertungen_instanz].cluster.ergebnis[wert][status];

        filtern = "";
        $.each(ergebnis, function (position, id) {
            filtern += '{"operator":"==","eigenschaft":"id","wert":' + id + "}";
            if (position < ergebnis.length - 1) filtern += ",";
        });
        filtern = '[{"verknuepfung":"||","filtern":[' + filtern + "]}]";
        $ergebnis.attr("data-filtern", filtern);
    });

    // BEINHALTETE LISTE AKTUALISIEREN
    if ("liste" in liste_data) {
        $auswertung.find('.liste[data-liste="' + liste_data.liste + '"]').each(function () {
            Liste_Aktualisieren($(this));
        });
        $auswertung.find('.element[data-liste="' + liste_data.liste + '"]').each(function () {
            Liste_ElementAktualisieren($(this), liste_data.liste);
        });
    }
}
