function Liste_SortierenRichtungAendern($richtung, instanz, liste) {
    const richtung = $richtung.attr("data-richtung");
    if (richtung == SORT_ASC)
        $richtung
            .attr("data-richtung", SORT_DESC)
            .removeClass("bi-" + SYMBOLE.asc.bootstrap)
            .addClass("bi-" + SYMBOLE.desc.bootstrap);
    else if (richtung == SORT_DESC)
        $richtung
            .attr("data-richtung", SORT_ASC)
            .removeClass("bi-" + SYMBOLE.desc.bootstrap)
            .addClass("bi-" + SYMBOLE.asc.bootstrap);

    Liste_SortierenSpeichern($richtung.closest(".modal.sortieren").find(".sortieren"), instanz, liste);
}
