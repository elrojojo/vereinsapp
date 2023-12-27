function Liste_VerzeichnisPfad2Verzeichnis(aktuelles_verzeichnis, verzeichnis_pfad, verzeichnis_pfad_uebrig) {
    if (typeof verzeichnis_pfad_uebrig === "undefined" || !Array.isArray(verzeichnis_pfad_uebrig)) {
        verzeichnis_pfad_uebrig = verzeichnis_pfad;
        verzeichnis_pfad_uebrig.reverse();
    }

    if (verzeichnis_pfad_uebrig.length > 0) {
        const verzeichnis_pfad_element = verzeichnis_pfad_uebrig.pop();
        aktuelles_verzeichnis = Liste_VerzeichnisPfad2Verzeichnis(
            aktuelles_verzeichnis[verzeichnis_pfad_element],
            verzeichnis_pfad,
            verzeichnis_pfad_uebrig
        );
    }

    return aktuelles_verzeichnis;
}
