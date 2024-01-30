function Liste_ElementAktualisieren($element, liste) {
    // EIGENSCHAFTEN AKTUALISIEREN
    $element.find(".eigenschaft").each(function () {
        const $eigenschaft = $(this);
        const eigenschaft = $eigenschaft.attr("data-eigenschaft");
        const wert = Schnittstelle_VariableRausZurueck(eigenschaft, Number($element.attr("data-element_id")), liste, "tabelle");
        $eigenschaft.html(Liste_WertFormatiertZurueck(wert, eigenschaft, liste));
    });

    // CHECK AKTUALISIEREN verschieben in Liste_Aktualisieren()
    $element.find(".check").each(function () {
        $check = $(this);
        const $liste = $check.closest(".liste");
        const gegen_element = G.LISTEN[$liste.attr("data-gegen_liste")].element;
        const filtern = [
            {
                verknuepfung: "&&",
                filtern: [
                    { operator: "==", eigenschaft: gegen_element + "_id", wert: Number($liste.attr("data-gegen_element_id")) },
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

    // NAVIGATION AKTUALISIEREN
    $element.find(".element_navigation").each(function () {
        Liste_ElementNavigationAktualisieren($(this), $element, liste);
    });
}
