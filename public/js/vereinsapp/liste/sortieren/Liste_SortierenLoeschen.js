function Liste_SortierenLoeschen($btn_loeschen, liste) {
    const $sortieren = $btn_loeschen.parents(".sortieren").first();
    const $element = $btn_loeschen.parents(".sortieren_element").first();

    $element.remove();

    G.LISTEN[liste].sortieren = Liste_Gib$Sortieren2Sortieren($sortieren, liste);

    Schnittstelle_EventVariableUpdLocalstorage(liste); // impliziert auch ein Schnittstelle_EventLocalstorageUpdVariable
}
