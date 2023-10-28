function Liste_FilternLoeschen($btn_loeschen, liste) {
    const $filtern = $btn_loeschen.parents(".filtern").first();
    const $element = $btn_loeschen.parents(".filtern_element").first();
    const $sammlung = $btn_loeschen.parents(".filtern_sammlung").first();

    let $knoten;
    if ($element.exists()) {
        $knoten = $element;
    } else $knoten = $sammlung;

    let $knoten_parallel = $knoten.siblings(".filtern_element, .filtern_sammlung");
    let $sammlung_ebene_hoeher = $knoten.parents(".filtern_sammlung").first();

    $knoten.remove();
    while ($knoten_parallel.length == 1) {
        const $knoten_ebene_hoeher = $sammlung_ebene_hoeher.siblings(".filtern_element, .filtern_sammlung");
        $sammlung_ebene_hoeher.replaceWith($knoten_parallel);
        $knoten_parallel = $knoten_ebene_hoeher;
        sammlung_ebene_hoeher = $knoten_parallel.first().parents(".filtern_sammlung").first();
    }

    LISTEN[liste].filtern = Liste_Gib$Filtern2Filtern($filtern, "filtern", liste);

    $(document).trigger("VAR_upd_LOC", [liste]); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR' );
}
