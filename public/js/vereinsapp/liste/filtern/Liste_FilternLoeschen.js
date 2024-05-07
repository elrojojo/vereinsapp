function Liste_FilternLoeschen($knoten, instanz, liste) {
    let $knoten_parallel = $knoten.siblings(".filtern_element, .filtern_sammlung");
    let $sammlung_ebene_hoeher = $knoten.parents(".filtern_sammlung").first();

    $knoten.remove();
    while ($knoten_parallel.length == 1) {
        const $knoten_ebene_hoeher = $sammlung_ebene_hoeher.siblings(".filtern_element, .filtern_sammlung");
        $sammlung_ebene_hoeher.replaceWith($knoten_parallel);
        $knoten_parallel = $knoten_ebene_hoeher;
        $sammlung_ebene_hoeher = $knoten_parallel.first().parents(".filtern_sammlung").first();
    }

    Liste_FilternSpeichern($knoten.closest(".modal.filtern").find(".filtern"), instanz, liste);
}
