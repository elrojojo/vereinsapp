function Liste_FilternVerknuepfungAendern($btn) {
    const liste = $btn.attr("data-liste");
    const instanz = $btn.attr("data-instanz");

    const $filtern = $btn.closest(".filtern");
    const $verknuepfung = $btn.closest(".filtern_sammlung").find(".verknuepfung").first();
    const verknuepfung = $verknuepfung.attr("data-verknuepfung");

    if (verknuepfung == "&&") $verknuepfung.attr("data-verknuepfung", "||");
    else if (verknuepfung == "||") $verknuepfung.attr("data-verknuepfung", "&&");

    G.LISTEN[liste].instanz[instanz].filtern = Liste_$Filtern2FilternZurueck($filtern, liste);
    Schnittstelle_EventVariableUpdLocalstorage(liste, [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);
}
