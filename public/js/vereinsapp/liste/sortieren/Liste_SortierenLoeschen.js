function Liste_SortierenLoeschen($element, instanz, liste) {
    const $sortieren = $element.closest(".modal.sortieren").find(".sortieren");

    $element.remove();

    Liste_SortierenSpeichern($sortieren, instanz, liste);
}
