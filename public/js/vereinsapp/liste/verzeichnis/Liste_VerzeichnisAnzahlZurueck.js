function Liste_VerzeichnisAnzahlZurueck(verzeichnis, typ) {
    if (typeof verzeichnis === "undefined") return 0;
    if (typeof typ === "undefined") typ = "verzeichnis";
    let anzahl = 0;

    $.each(verzeichnis.unterverzeichnisse, function (position, unterverzeichnis) {
        if (typ == "verzeichnis") anzahl++;
        anzahl += Liste_VerzeichnisAnzahlZurueck(unterverzeichnis, typ);
    });

    $.each(verzeichnis.dateien, function (position, datei) {
        const punkt = datei.lastIndexOf(".");
        if (typ == datei.slice(punkt + 1)) anzahl++;
    });

    return anzahl;
}
