function Liste_Sortieren2$SortierenZurueck(sortieren, liste) {
    const $sortieren = new Array();

    $.each(sortieren, function (index, element) {
        const richtung = element.richtung;
        const eigenschaft = element.eigenschaft;
        const $neues_sortieren_element = SORTIEREN.$blanko_sortieren_element.clone().removeClass("blanko invisible").addClass("sortieren_element");

        $neues_sortieren_element.find(".eigenschaft").attr("data-eigenschaft", eigenschaft).text(EIGENSCHAFTEN[liste][eigenschaft].beschriftung);

        $neues_sortieren_element.find(".richtung").attr("data-richtung", richtung);
        if (richtung == SORT_ASC) $neues_sortieren_element.find(".richtung").addClass("bi-" + SYMBOLE.asc.bootstrap);
        else if (richtung == SORT_DESC) $neues_sortieren_element.find(".richtung").addClass("bi-" + SYMBOLE.desc.bootstrap);

        $neues_sortieren_element.find(".btn_sortieren_loeschen").attr("data-liste", liste);

        $sortieren.push($neues_sortieren_element);
    });

    return $sortieren;
}
