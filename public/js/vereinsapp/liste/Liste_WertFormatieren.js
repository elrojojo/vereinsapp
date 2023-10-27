function Liste_WertFormatieren(wert, eigenschaft, liste) {
    if (eigenschaft == "geburt") wert = wert.toFormat("dd.MM.yyyy");
    if (eigenschaft == "geburtstag") wert = wert.toFormat("dd.MM.");
    if (eigenschaft == "alter") wert = Math.floor(wert) + " Jahre";
    if (eigenschaft == "alter_geburtstag") wert = Math.floor(wert) + " Jahre";
    if (eigenschaft == "geschlecht") wert = VORGEGEBENE_WERTE[liste].geschlecht[wert].beschriftung;
    if (eigenschaft == "register") wert = VORGEGEBENE_WERTE[liste].register[wert].beschriftung;
    if (eigenschaft == "funktion") wert = VORGEGEBENE_WERTE[liste].funktion[wert].beschriftung;
    if (eigenschaft == "vorstandschaft") wert = JANEIN[wert].beschriftung;
    if (eigenschaft == "aktiv") wert = JANEIN[wert].beschriftung;
    if (eigenschaft == "start") wert = WOCHENTAGE[wert.weekday].kurz + ", " + wert.toFormat("dd.MM.yyyy HH:mm");
    if (eigenschaft == "ende") wert = WOCHENTAGE[wert.weekday].kurz + ", " + wert.toFormat("dd.MM.yyyy HH:mm");
    if (eigenschaft == "kategorie") wert = VORGEGEBENE_WERTE[liste].kategorie[wert].beschriftung;
    if (eigenschaft == "anzahl_noten") wert = wert + '<i class="bi bi-' + SYMBOLE["noten"]["bootstrap"] + '">';
    if (eigenschaft == "anzahl_audio") wert = wert + '<i class="bi bi-' + SYMBOLE["audio"]["bootstrap"] + '">';
    if (eigenschaft == "anzahl_verzeichnis") wert = wert + '<i class="bi bi-' + SYMBOLE["verzeichnis"]["bootstrap"] + '">';
    return wert;
}
