function Schnittstelle_EventElementErgaenzenNotenbank(titel) {
    titel["anzahl_noten"] = 0;
    $.each(NOTENBANK_ERLAUBTE_DATEITYPEN_NOTEN, function (index, typ) {
        titel["anzahl_noten"] += Liste_VerzeichnisAnzahlZurueck(titel["verzeichnis"], typ);
    });

    titel["anzahl_audio"] = 0;
    $.each(NOTENBANK_ERLAUBTE_DATEITYPEN_AUDIO, function (index, typ) {
        titel["anzahl_audio"] += Liste_VerzeichnisAnzahlZurueck(titel["verzeichnis"], typ);
    });

    titel["anzahl_verzeichnis"] = Liste_VerzeichnisAnzahlZurueck(titel["verzeichnis"]);
}
