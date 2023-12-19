function Liste_SortierenLoeschen($btn) {
    const liste = $btn.attr("data-liste");
    const liste_id = $btn.attr("data-liste_id");

    const $sortieren = $btn.closest(".sortieren");
    $btn.closest(".sortieren_element").remove();
    G.LISTEN[liste].instanz[liste_id].sortieren = Liste_$Sortieren2SortierenZurueck($sortieren, liste);

    Schnittstelle_EventVariableUpdLocalstorage(liste, [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);
}
