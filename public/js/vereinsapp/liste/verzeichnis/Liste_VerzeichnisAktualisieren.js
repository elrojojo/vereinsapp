function Liste_VerzeichnisAktualisieren($verzeichnis, liste) {
    const verzeichnis_instanz = $verzeichnis.attr("id");
    const element_id = Number($verzeichnis.attr("data-element_id"));
    const $verzeichnis_pfad = G.LISTEN[liste].verzeichnis[verzeichnis_instanz].$verzeichnis_pfad;

    let verzeichnis_pfad = $verzeichnis.attr("data-verzeichnis_pfad");
    if (typeof verzeichnis_pfad !== "undefined") verzeichnis_pfad = JSON.parse(verzeichnis_pfad);
    else verzeichnis_pfad = new Array();
    $verzeichnis.attr("data-verzeichnis_pfad", JSON.stringify(verzeichnis_pfad));

    $verzeichnis_pfad.html(
        Liste_VerzeichnisPfad2$VerzeichnisPfadZurueck(
            verzeichnis_pfad,
            G.LISTEN[liste].verzeichnis[verzeichnis_instanz].$blanko_verzeichnis_pfad_element,
            liste
        )
    );

    const verzeichnis_basis = BASE_URL + "storage/" + liste + "/" + G.LISTEN[liste].tabelle[element_id].verzeichnis_basis + verzeichnis_pfad.join("");
    $verzeichnis.html(
        Liste_Verzeichnis2$VerzeichnisZurueck(
            Liste_VerzeichnisPfad2Verzeichnis(G.LISTEN[liste].tabelle[element_id].verzeichnis, verzeichnis_pfad),
            verzeichnis_basis,
            G.LISTEN[liste].verzeichnis[verzeichnis_instanz].$blanko_verzeichnis_element,
            liste
        )
    );
}
