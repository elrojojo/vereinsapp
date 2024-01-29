function Liste_VerzeichnisPfadOeffnen($btn) {
    const liste = $btn.attr("data-liste");
    const instanz = $btn.attr("data-verzeichnis_instanz");
    const $verzeichnis_pfad = $btn.closest(".verzeichnis_pfad");
    const $verzeichnis = $verzeichnis_pfad.siblings('.verzeichnis[id="' + instanz + '"]').first();

    $btn.nextAll(".verzeichnis_pfad_element").remove();

    $verzeichnis.attr("data-verzeichnis_pfad", JSON.stringify(Liste_$VerzeichnisPfad2VerzeichnisPfadZurueck($verzeichnis_pfad, liste)));

    Schnittstelle_EventVariableUpdDom(liste);
}
