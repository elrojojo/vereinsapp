function Liste_AuswertungenErgebnisZurueck(auswertungen_tabelle, liste_tabelle, gruppieren, gruppieren_werte, status_auswahl, liste) {
    const ergebnis = new Object();
    ergebnis.ergebnis = new Object();
    ergebnis.ergebnis_wert = new Object();
    ergebnis.ergebnis_status = new Object();

    // ergebnis, ergebnis_wert und ergebnis_status vorbereiten
    $.each(gruppieren_werte, function (position, wert) {
        ergebnis.ergebnis[wert] = new Object();
        $.each(status_auswahl, function (status) {
            ergebnis.ergebnis[wert][status] = new Array();
            if (!(status in ergebnis.ergebnis_status)) ergebnis.ergebnis_status[status] = new Array();
        });
        ergebnis.ergebnis_wert[wert] = new Array();
    });

    // ergebnis, ergebnis_wert und ergebnis_status befüllen
    $.each(auswertungen_tabelle, function () {
        const auswertung = this;
        const status = auswertung.status;
        const element_id = auswertung[LISTEN[liste].element + "_id"];
        const wert = LISTEN[liste].tabelle[element_id][gruppieren];

        ergebnis.ergebnis[wert][status].push(element_id);
        ergebnis.ergebnis_status[status].push(element_id);
        ergebnis.ergebnis_wert[wert].push(element_id);
    });

    // ergebnis[wert][0] in ergebnis, ergebnis_wert und ergebnis_status integrieren
    $.each(liste_tabelle, function (position, element) {
        const element_id = element.id;
        const wert = LISTEN[liste].tabelle[element_id][gruppieren];

        if (!ergebnis.ergebnis_wert[wert].includes(element_id)) {
            ergebnis.ergebnis_wert[wert].push(element_id);
            ergebnis.ergebnis_status[0].push(element_id);
            ergebnis.ergebnis[wert][0].push(element_id);
        }
    });

    return ergebnis;
}
