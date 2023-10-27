function Liste_SortierenLoeschen($btn_loeschen, liste) {
    const $sortieren = $btn_loeschen.parents(".sortieren").first();
    const $element = $btn_loeschen.parents(".sortieren_element").first();

    $element.remove();

    LISTEN[liste].sortieren = Liste_$Sortieren2Sortieren($sortieren, liste);

    $(document).trigger("VAR_upd_LOC", [liste]); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR' );
}
