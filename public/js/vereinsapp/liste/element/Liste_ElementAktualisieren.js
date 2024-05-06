function Liste_ElementAktualisieren($element, liste) {
    const element_id = Number($element.attr("data-element_id"));

    // EIGENSCHAFTEN AKTUALISIEREN
    $element.find(".eigenschaft").each(function () {
        const $eigenschaft = $(this);
        const eigenschaft = $eigenschaft.attr("data-eigenschaft");
        const wert = Schnittstelle_VariableRausZurueck(eigenschaft, Number($element.attr("data-element_id")), liste);
        $eigenschaft.html(Liste_WertFormatiertZurueck(wert, eigenschaft, liste));
    });

    // WERKZEUGKASTEN AKTUALISIEREN
    $element.find('[data-bs-toggle="offcanvas"][data-bs-target="#werkzeugkasten"]').attr("data-element_id", element_id);

    // LINK AKTUALISIEREN
    $element.find("a.stretched-link").attr("href", BASE_URL + LISTEN[liste].controller + "/" + element_id);

    // CHECK AKTUALISIEREN
    $element.find("label").attr("for", element_id);
    $element.find(".check").each(function () {
        Liste_CheckAktualisieren($(this), element_id, liste);
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
