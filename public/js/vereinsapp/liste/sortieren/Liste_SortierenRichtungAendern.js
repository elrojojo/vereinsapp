function Liste_SortierenRichtungAendern($btn) {
    const liste = $btn.attr("data-liste");
    const instanz = $btn.attr("data-instanz");
    const $formular = $btn.closest(".modal.sortieren");

    const richtung = $btn.attr("data-richtung");
    if (richtung == SORT_ASC)
        $btn.attr("data-richtung", SORT_DESC)
            .removeClass("bi-" + SYMBOLE.asc.bootstrap)
            .addClass("bi-" + SYMBOLE.desc.bootstrap);
    else if (richtung == SORT_DESC)
        $btn.attr("data-richtung", SORT_ASC)
            .removeClass("bi-" + SYMBOLE.desc.bootstrap)
            .addClass("bi-" + SYMBOLE.asc.bootstrap);

    Liste_SortierenSpeichern($formular, instanz, liste);
}
