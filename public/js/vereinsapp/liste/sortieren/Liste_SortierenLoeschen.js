function Liste_SortierenLoeschen($btn, liste) {
    const $sortieren = $btn.parents(".sortieren").first();
    const $element = $btn.parents(".sortieren_element").first();

    $element.remove();

    G.LISTEN[liste].sortieren = Liste_$Sortieren2SortierenZurueck($sortieren, liste);

    Schnittstelle_EventVariableUpdLocalstorage(liste); // impliziert auch ein Schnittstelle_EventLocalstorageUpdVariable
}
