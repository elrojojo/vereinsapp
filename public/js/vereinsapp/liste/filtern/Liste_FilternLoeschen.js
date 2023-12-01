function Liste_FilternLoeschen($btn, liste) {
    const $filtern = $btn.parents(".filtern").first();
    const $element = $btn.parents(".filtern_element").first();
    const $sammlung = $btn.parents(".filtern_sammlung").first();

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

    G.LISTEN[liste].filtern = Liste_$Filtern2FilternZurueck($filtern, "filtern", liste);

    Schnittstelle_EventVariableUpdLocalstorage(liste, [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);
}
