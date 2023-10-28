function Liste_ElementAktualisieren($element, liste) {
    // EIGENSCHAFTEN AKTUALISIEREN
    $element.find(".eigenschaft").each(function () {
        const $eigenschaft = $(this);
        const eigenschaft = $eigenschaft.attr("data-eigenschaft");
        $eigenschaft.html(Liste_WertFormatieren(LISTEN[liste].tabelle[Number($element.attr("data-element_id"))][eigenschaft], eigenschaft, liste));
    });

    // CHECK AKTUALISIEREN
    $element.find(".check").each(function () {
        Liste_ElementCheckAktualisieren($(this), $element, liste);
    });

    // ZUSATZSYMBOLE AKTUALISIEREN
    $element.find(".zusatzsymbol").each(function () {
        Liste_ElementZusatzsymbolAktualisieren($(this), $element, liste);
    });

    // LETZTEN SPACER AUS DER VORSCHAU LÖSCHEN
    const $letztes_vorschau_element = $element.find(".vorschau").children().last();
    if ($letztes_vorschau_element.hasClass("spacer")) $letztes_vorschau_element.remove();
}
