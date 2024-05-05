function Liste_SortierenLoeschen($btn) {
    const $element = $btn.closest(".sortieren_element");

    $element.remove();
}
