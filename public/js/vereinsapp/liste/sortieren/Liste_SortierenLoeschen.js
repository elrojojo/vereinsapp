function Liste_SortierenLoeschen($btn) {
    const liste = $btn.attr("data-liste");
    const instanz = $btn.attr("data-instanz");
    // const eigenschaft = $btn.attr("data-eigenschaft");
    // const sortieren_liste = $btn.attr("data-sortieren_liste");
    // const element_id = $btn.attr("data-element_id");
    const $formular = $btn.closest(".modal");

    const $sortieren = $btn.closest(".sortieren");
    $btn.closest(".sortieren_element").remove();
    G.LISTEN[liste].instanz[instanz].sortieren = Liste_$Sortieren2SortierenZurueck($sortieren, liste);

    Schnittstelle_EventVariableUpdLocalstorage(liste, [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);

    Liste_FilternAktualisieren($formular, liste);
}
