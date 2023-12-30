function Liste_ElementAktualisieren($element, liste) {
    // EIGENSCHAFTEN AKTUALISIEREN
    $element.find(".eigenschaft").each(function () {
        const $eigenschaft = $(this);
        const eigenschaft = $eigenschaft.attr("data-eigenschaft");
        const wert = G.LISTEN[liste].tabelle[Number($element.attr("data-element_id"))][eigenschaft];
        $eigenschaft.html(Liste_WertFormatiertZurueck(wert, eigenschaft, liste));
    });

    // CHECK AKTUALISIEREN
    $element.find(".check").each(function () {
        $check = $(this);
        const $liste = $check.closest(".liste");
        const filtern = [
            {
                verknuepfung: "&&",
                filtern: [
                    { operator: "==", eigenschaft: $liste.attr("data-gegen_element") + "_id", wert: Number($liste.attr("data-gegen_element_id")) },
                    { operator: "==", eigenschaft: G.LISTEN[$element.attr("data-liste")].element + "_id", wert: Number($check.val()) },
                ],
            },
        ];
        const gefilterte_tabelle = Liste_TabelleGefiltertZurueck(filtern, $check.attr("name"));
        $check.attr("checked", gefilterte_tabelle.length > 0);
    });

    // ZUSATZSYMBOLE AKTUALISIEREN
    $element.find(".zusatzsymbol").each(function () {
        Liste_ElementZusatzsymbolAktualisieren($(this), $element, liste);
    });

    // LETZTEN SPACER AUS DER VORSCHAU LÖSCHEN
    const $letztes_vorschau_element = $element.find(".vorschau").children().last();
    if ($letztes_vorschau_element.hasClass("spacer")) $letztes_vorschau_element.remove();
}
