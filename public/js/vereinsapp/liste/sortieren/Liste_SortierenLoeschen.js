function Liste_SortierenLoeschen($btn) {
    const liste = $btn.attr("data-liste");
    const instanz = $btn.attr("data-instanz");
    // const eigenschaft = $btn.attr("data-eigenschaft");
    // const sortieren_liste = $btn.attr("data-sortieren_liste");
    // const element_id = $btn.attr("data-element_id");
    const $formular = $btn.closest(".modal");

    const $sortieren = $btn.closest(".sortieren");
    $btn.closest(".sortieren_element").remove();

    if (typeof instanz !== "undefined") {
        G.LISTEN[liste].instanz[instanz].sortieren = Liste_$Sortieren2SortierenZurueck($sortieren, liste);
        Schnittstelle_EventVariableUpdLocalstorage(liste, [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);
    }
    if (typeof eigenschaft !== "undefined")
        Schnittstelle_VariableRein(Liste_$Sortieren2SortierenZurueck($filtern, filtern_liste), eigenschaft, element_id, liste, "tmp");

    Liste_FilternAktualisieren($formular, liste);
}
