function Schnittstelle_EventElementErgaenzenNotenbank(titel) {
    function anzahl_dateien(verzeichnis) {
        const anzahl = { noten: 0, audio: 0, verzeichnis: 0 };
        $.each(verzeichnis, function (index, datei) {
            if (typeof datei == "array" || typeof datei == "object") {
                const unterverzeichnis = datei;
                anzahl.verzeichnis++;
                const anzahl_unterverzeichnis = anzahl_dateien(unterverzeichnis);
                anzahl.noten += anzahl_unterverzeichnis.noten;
                anzahl.audio += anzahl_unterverzeichnis.audio;
            } else if (datei.substring(datei.length - 4, datei.length) == ".pdf") anzahl.noten++;
            else if (datei.substring(datei.length - 4, datei.length) == ".m4a") anzahl.audio++;
        });
        return anzahl;
    }

    titel["anzahl_noten"] = anzahl_dateien(titel["verzeichnis"]).noten;
    titel["anzahl_audio"] = anzahl_dateien(titel["verzeichnis"]).audio;
    titel["anzahl_verzeichnis"] = anzahl_dateien(titel["verzeichnis"]).verzeichnis;
}
