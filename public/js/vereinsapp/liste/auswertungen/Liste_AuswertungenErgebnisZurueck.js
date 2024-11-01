function Liste_AuswertungenErgebnisZurueck(auswertungen_tabelle, liste_tabelle, gruppieren, gruppieren_werte, status_auswahl, liste) {
    const ergebnis = new Object();
    const ergebnis_element_ids = new Object();

    // ergebnis vorbereiten
    $.each(gruppieren_werte, function (position, wert) {
        ergebnis[wert] = new Object();
        $.each(status_auswahl, function (status) {
            ergebnis[wert][status] = new Array();
        });
        ergebnis_element_ids[wert] = new Array();
    });

    // ergebnis befüllen
    $.each(auswertungen_tabelle, function () {
        const auswertung = this;
        const element_id = auswertung[LISTEN[liste].element + "_id"];
        const wert = Schnittstelle_VariableRausZurueck(gruppieren, element_id, liste);

        ergebnis[wert][auswertung.status].push(element_id);
        ergebnis_element_ids[wert].push(element_id);
    });

    // ergebnis[wert][0] in ergebnis integrieren
    $.each(liste_tabelle, function (position, element) {
        const element_id = element.id;
        const wert = Schnittstelle_VariableRausZurueck(gruppieren, element_id, liste);

        if (!ergebnis_element_ids[wert].includes(element_id)) ergebnis[wert][0].push(element_id);
    });

    return ergebnis;
}
