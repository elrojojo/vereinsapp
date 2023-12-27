function Schnittstelle_EventElementErgaenzenNotenbank(titel) {
    function anzahl_dateien(verzeichnis) {
        const anzahl = { noten: 0, audio: 0, verzeichnis: 0 };
        $.each(verzeichnis, function (index, unterverzeichnis) {
            if (isObject(unterverzeichnis)) {
                anzahl.verzeichnis++;
                const anzahl_unterverzeichnis = anzahl_dateien(unterverzeichnis);
                anzahl.noten += anzahl_unterverzeichnis.noten;
                anzahl.audio += anzahl_unterverzeichnis.audio;
                anzahl.verzeichnis += anzahl_unterverzeichnis.verzeichnis;
            } else if (unterverzeichnis.substring(unterverzeichnis.length - 4, unterverzeichnis.length) == ".pdf") anzahl.noten++;
            else if (unterverzeichnis.substring(unterverzeichnis.length - 4, unterverzeichnis.length) == ".m4a") anzahl.audio++;
        });
        return anzahl;
    }

    titel["anzahl_noten"] = anzahl_dateien(titel["verzeichnis"]).noten;
    titel["anzahl_audio"] = anzahl_dateien(titel["verzeichnis"]).audio;
    titel["anzahl_verzeichnis"] = anzahl_dateien(titel["verzeichnis"]).verzeichnis;
}
