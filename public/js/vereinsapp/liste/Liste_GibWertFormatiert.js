function Liste_GibWertFormatiert(wert, eigenschaft, liste) {
    if (eigenschaft == "geburt") wert_formatiert = wert.toFormat("dd.MM.yyyy");
    if (eigenschaft == "geburtstag") wert_formatiert = wert.toFormat("dd.MM.");
    if (eigenschaft == "alter") wert_formatiert = Math.floor(wert) + " Jahre";
    if (eigenschaft == "alter_geburtstag") wert_formatiert = Math.floor(wert) + " Jahre";
    if (eigenschaft == "geschlecht") wert_formatiert = VORGEGEBENE_WERTE[liste].geschlecht[wert].beschriftung;
    if (eigenschaft == "register") wert_formatiert = VORGEGEBENE_WERTE[liste].register[wert].beschriftung;
    if (eigenschaft == "funktion") wert_formatiert = VORGEGEBENE_WERTE[liste].funktion[wert].beschriftung;
    if (eigenschaft == "vorstandschaft") wert_formatiert = JANEIN[wert].beschriftung;
    if (eigenschaft == "aktiv") wert_formatiert = JANEIN[wert].beschriftung;
    if (eigenschaft == "start") wert_formatiert = WOCHENTAGE[wert.weekday].kurz + ", " + wert.toFormat("dd.MM.yyyy HH:mm");
    if (eigenschaft == "ende") wert_formatiert = WOCHENTAGE[wert.weekday].kurz + ", " + wert.toFormat("dd.MM.yyyy HH:mm");
    if (eigenschaft == "kategorie") wert_formatiert = VORGEGEBENE_WERTE[liste].kategorie[wert].beschriftung;
    if (eigenschaft == "anzahl_noten") wert_formatiert = wert + '<i class="bi bi-' + SYMBOLE["noten"]["bootstrap"] + '">';
    if (eigenschaft == "anzahl_audio") wert_formatiert = wert + '<i class="bi bi-' + SYMBOLE["audio"]["bootstrap"] + '">';
    if (eigenschaft == "anzahl_verzeichnis") wert_formatiert = wert + '<i class="bi bi-' + SYMBOLE["verzeichnis"]["bootstrap"] + '">';
    return wert_formatiert;
}
