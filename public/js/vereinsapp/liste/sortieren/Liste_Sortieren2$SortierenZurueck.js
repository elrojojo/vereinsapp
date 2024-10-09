function Liste_Sortieren2$SortierenZurueck(sortieren, instanz, liste) {
    let $sortieren = $();

    $.each(sortieren, function (index, element) {
        const richtung = element.richtung;
        const eigenschaft = element.eigenschaft;

        const $neues_sortieren_element = SORTIEREN.$blanko_sortieren_element.clone().removeClass("blanko invisible");
        $neues_sortieren_element.find(".eigenschaft").attr("data-eigenschaft", eigenschaft).text(EIGENSCHAFTEN[liste][eigenschaft].beschriftung);
        $neues_sortieren_element.find(".richtung").attr("data-richtung", richtung);
        if (richtung == SORT_ASC) $neues_sortieren_element.find(".richtung").addClass("bi-" + SYMBOLE.asc.bootstrap);
        else if (richtung == SORT_DESC) $neues_sortieren_element.find(".richtung").addClass("bi-" + SYMBOLE.desc.bootstrap);

        $sortieren = $sortieren.add($neues_sortieren_element);
    });

    $sortieren.find(".btn_sortieren_loeschen, .btn_sortieren_aendern").attr("data-liste", liste).attr("data-instanz", instanz);

    return $sortieren;
}
