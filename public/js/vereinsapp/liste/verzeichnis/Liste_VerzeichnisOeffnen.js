function Liste_VerzeichnisOeffnen($btn) {
    const liste = $btn.attr("data-liste");
    const $verzeichnis = $btn.closest(".verzeichnis");

    let verzeichnis_pfad = $verzeichnis.attr("data-verzeichnis_pfad");
    if (typeof verzeichnis_pfad !== "undefined") verzeichnis_pfad = JSON.parse(verzeichnis_pfad);
    else verzeichnis_pfad = new Array();

    verzeichnis_pfad.push($btn.siblings(".beschriftung").first().text());

    $verzeichnis.attr("data-verzeichnis_pfad", JSON.stringify(verzeichnis_pfad));

    Schnittstelle_EventVariableUpdDom(liste);
}
