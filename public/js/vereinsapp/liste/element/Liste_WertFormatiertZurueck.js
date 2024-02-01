function Liste_WertFormatiertZurueck(wert, eigenschaft, liste) {
    switch (eigenschaft) {
        case "geburt":
            wert_formatiert = wert.toFormat("dd.MM.yyyy");
            break;
        case "geburtstag":
            wert_formatiert = wert.toFormat("dd.MM.");
            break;
        case "alter":
            wert_formatiert = Math.floor(wert) + " Jahre";
            break;
        case "alter_geburtstag":
            wert_formatiert = Math.floor(wert) + " Jahre";
            break;
        case "geschlecht":
            wert_formatiert = VORGEGEBENE_WERTE[liste].geschlecht[wert].beschriftung;
            break;
        case "register":
            wert_formatiert = VORGEGEBENE_WERTE[liste].register[wert].beschriftung;
            break;
        case "funktion":
            wert_formatiert = VORGEGEBENE_WERTE[liste].funktion[wert].beschriftung;
            break;
        case "vorstandschaft":
            wert_formatiert = JANEIN[wert].beschriftung;
            break;
        case "aktiv":
            wert_formatiert = JANEIN[wert].beschriftung;
            break;
        case "erstellung":
        case "letzte_aktivitaet":
            if (wert == null) wert_formatiert = "nie";
            else wert_formatiert = wert.toFormat("dd.MM.yyyy HH:mm");
            break;
        case "start":
            wert_formatiert = WOCHENTAGE_KURZ[wert.weekday].beschriftung + ", " + wert.toFormat("dd.MM.yyyy HH:mm");
            break;
        case "ende":
            wert_formatiert = WOCHENTAGE_KURZ[wert.weekday].beschriftung + ", " + wert.toFormat("dd.MM.yyyy HH:mm");
            break;
        case "kategorie":
            wert_formatiert = VORGEGEBENE_WERTE[liste].kategorie[wert].beschriftung;
            break;
        case "anzahl_noten":
            wert_formatiert = wert + '<i class="bi bi-' + SYMBOLE["noten"]["bootstrap"] + '">';
            break;
        case "anzahl_audio":
            wert_formatiert = wert + '<i class="bi bi-' + SYMBOLE["audio"]["bootstrap"] + '">';
            break;
        case "anzahl_verzeichnis":
            wert_formatiert = wert + '<i class="bi bi-' + SYMBOLE["verzeichnis"]["bootstrap"] + '">';
            break;
        default:
            wert_formatiert = wert;
    }

    return wert_formatiert;
}
