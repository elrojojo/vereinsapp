function Liste_FilternVerknuepfungAendern($btn, liste) {
    const $filtern = $btn.parents(".filtern").first();
    const $verknuepfung = $btn.parents(".filtern_sammlung").first().find(".verknuepfung").first();
    const verknuepfung = $verknuepfung.attr("data-verknuepfung");

    if (verknuepfung == "&&") $verknuepfung.attr("data-verknuepfung", "||");
    else if (verknuepfung == "||") $verknuepfung.attr("data-verknuepfung", "&&");

    G.LISTEN[liste].filtern = Liste_$Filtern2FilternZurueck($filtern, "filtern", liste);
    Schnittstelle_EventVariableUpdLocalstorage(liste, [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);
}
