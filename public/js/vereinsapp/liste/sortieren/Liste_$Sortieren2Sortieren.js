function Liste_$Sortieren2Sortieren($sortieren, liste) {
    const LISTE = LISTEN[liste];
    const sortieren = new Array();

    $sortieren.children(".sortieren_element").each(function () {
        const $element = $(this);
        const richtung = Number($element.find(".richtung").attr("data-richtung"));
        const eigenschaft = $element.find(".eigenschaft").attr("data-eigenschaft");

        sortieren.push({ richtung: richtung, eigenschaft: eigenschaft });
    });

    return sortieren;
}
