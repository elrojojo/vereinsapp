function Liste_SortierenLoeschen($element, instanz, liste) {
    const $sortieren = $element.closest(".sortieren_formular").find(".sortieren");

    $element.remove();

    Liste_SortierenSpeichern($sortieren, instanz, liste);
}
