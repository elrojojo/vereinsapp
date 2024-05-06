function Liste_SortierenLoeschen($btn) {
    const liste = $btn.attr("data-liste");
    const instanz = $btn.attr("data-instanz");
    const $formular = $btn.closest(".modal.sortieren");

    const $element = $btn.closest(".sortieren_element");

    $element.remove();

    Liste_SortierenSpeichern($formular, instanz, liste);
}
