function Liste_SortierenRichtungAendern($btn) {
    const richtung = $btn.attr("data-richtung");
    if (richtung == SORT_ASC)
        $btn.attr("data-richtung", SORT_DESC)
            .removeClass("bi-" + SYMBOLE.asc.bootstrap)
            .addClass("bi-" + SYMBOLE.desc.bootstrap);
    else if (richtung == SORT_DESC)
        $btn.attr("data-richtung", SORT_ASC)
            .removeClass("bi-" + SYMBOLE.desc.bootstrap)
            .addClass("bi-" + SYMBOLE.asc.bootstrap);
}
