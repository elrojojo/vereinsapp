function Liste_$Sortieren2SortierenZurueck($sortieren) {
    const sortieren = new Array();

    $sortieren.children(".sortieren_element").each(function () {
        const $element = $(this);
        sortieren.push({ richtung: Number($element.find(".richtung").attr("data-richtung")), eigenschaft: $element.find(".eigenschaft").attr("data-eigenschaft") });
    });

    return sortieren;
}
