function Liste_FilternVerknuepfungAendern($btn) {
    const liste = $btn.attr("data-liste");
    const liste_id = $btn.attr("data-liste_id");

    const $filtern = $btn.closest(".filtern");
    const $verknuepfung = $btn.closest(".filtern_sammlung").find(".verknuepfung").first();
    const verknuepfung = $verknuepfung.attr("data-verknuepfung");

    if (verknuepfung == "&&") $verknuepfung.attr("data-verknuepfung", "||");
    else if (verknuepfung == "||") $verknuepfung.attr("data-verknuepfung", "&&");

    G.LISTEN[liste].instanz[liste_id].filtern = Liste_$Filtern2FilternZurueck($filtern, "filtern", liste);
    Schnittstelle_EventVariableUpdLocalstorage(liste, [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);
}
