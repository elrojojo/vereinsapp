function Liste_DateiAktualisieren($datei, liste) {
    const datei = $datei.attr("data-datei");
    const $verzeichnis = $datei.closest(".verzeichnis");
    const element_id = Number($verzeichnis.attr("data-element_id"));

    let basis = $verzeichnis.attr("data-basis");
    if (typeof basis !== "undefined") basis = JSON.parse(basis);
    else basis = new Array();

    link = BASE_URL + "storage/" + liste + "/" + Schnittstelle_VariableRausZurueck("verzeichnis_basis", element_id, liste, "tabelle");
    $.each(basis, function (position, unterverzeichnis) {
        link += unterverzeichnis;
    });
    link += datei;

    // EIGENSCHAFTEN AKTUALISIEREN
    $datei.find(".beschriftung").text(datei);

    // WERKZEUGKASTEN AKTUALISIEREN
    // $datei.find('[data-bs-toggle="offcanvas"][data-bs-target="#werkzeugkasten"]').attr("data-datei", datei);

    // LINK AKTUALISIEREN
    $datei.find("a.stretched-link").attr("href", link);

    // ZUSATZSYMBOLE AKTUALISIEREN
    $datei.find(".zusatzsymbol").each(function () {
        Liste_ElementZusatzsymbolAktualisieren($(this), $datei, liste);
    });
}
