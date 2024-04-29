function Liste_SortierenLoeschen($btn) {
    const liste = $btn.attr("data-liste");
    const instanz = $btn.attr("data-instanz");
    const $formular = $btn.closest(".modal");

    const $sortieren = $formular.find(".sortieren");
    $btn.closest(".sortieren_element").remove();

    // if (typeof instanz !== "undefined") {
    G.LISTEN[liste].instanz[instanz].sortieren = Liste_$Sortieren2SortierenZurueck($sortieren);
    Schnittstelle_EventVariableUpdLocalstorage(liste, [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);
    // }

    Liste_SortierenAktualisieren($formular, liste);
}
