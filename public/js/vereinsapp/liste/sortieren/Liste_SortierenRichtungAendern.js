function Liste_SortierenRichtungAendern($btn) {
    const liste = $btn.attr("data-liste");
    const instanz = $btn.attr("data-instanz");
    const $formular = $btn.closest(".modal");

    const $sortieren = $formular.find(".sortieren");
    const richtung = $btn.attr("data-richtung");
    if (richtung == SORT_ASC) $btn.attr("data-richtung", SORT_DESC);
    else if (richtung == SORT_DESC) $btn.attr("data-richtung", SORT_ASC);

    // if (typeof instanz !== "undefined") {
    G.LISTEN[liste].instanz[instanz].sortieren = Liste_$Sortieren2SortierenZurueck($sortieren);
    Schnittstelle_EventVariableUpdLocalstorage(liste, [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);
    // }

    Liste_SortierenAktualisieren($formular, liste);
}
