function Liste_ElementAktualisieren($element, liste) {
    const element_id = Number($element.attr("data-element_id"));
    const $liste = $element.closest('.liste[data-liste="' + liste + '"]');

    // EIGENSCHAFTEN AKTUALISIEREN
    $element.find(".eigenschaft").each(function () {
        const $eigenschaft = $(this);
        const eigenschaft = $eigenschaft.attr("data-eigenschaft");
        const wert = Schnittstelle_VariableRausZurueck(eigenschaft, Number($element.attr("data-element_id")), liste);
        $eigenschaft.html(Liste_WertFormatiertZurueck(wert, eigenschaft, liste));
    });

    // WERKZEUGKASTEN AKTUALISIEREN
    $element.find('[data-bs-toggle="offcanvas"][data-bs-target="#werkzeugkasten"]').attr("data-element_id", element_id);

    // LINK AKTUALISIEREN ODER ELEMENT DEAKTIVIEREN (FALLS ES EINE ZUGEHÖRIGE LISTE GIBT)
    let elemente_disabled = new Array();
    if ($liste.exists()) {
        const elemente_disabled_data = $liste.attr("data-elemente_disabled");
        if (typeof elemente_disabled_data !== "undefined") elemente_disabled = JSON.parse(elemente_disabled_data);
    }
    if (elemente_disabled.length > 0 && elemente_disabled.includes(element_id)) {
        $element.removeClass("list-group-item-action");
        $element.removeAttr("role");
        $element.find(".beschriftung").addClass("text-secondary");
        $element.find("a.stretched-link").removeAttr("href");
    } else {
        $element.addClass("list-group-item-action");
        $element.attr("role", "button");
        $element.find(".beschriftung").removeClass("text-secondary");
        $element.find("a.stretched-link").attr("href", BASE_URL + LISTEN[liste].controller + "/" + element_id);
    }

    // CHECK AKTUALISIEREN
    $element.find(".check").each(function () {
        Liste_CheckAktualisieren($(this), element_id, elemente_disabled, liste);
    });

    // ZUSATZSYMBOLE AKTUALISIEREN
    $element.find(".zusatzsymbol").each(function () {
        Liste_ElementZusatzsymbolAktualisieren($(this), $element, liste);
    });

    // LETZTEN SPACER AUS DER VORSCHAU LÖSCHEN (UND GGF. VORHER NOCH DAS LETZTE LEERE VORSCHAU-ELEMENT LÖSCHEN)
    let $letztes_vorschau_element = $element.find(".vorschau").children().last();
    if ($letztes_vorschau_element.text().trim() == "") {
        $letztes_vorschau_element.remove();
        $letztes_vorschau_element = $element.find(".vorschau").children().last();
    }
    if ($letztes_vorschau_element.hasClass("spacer")) $letztes_vorschau_element.remove();

    // NAVIGATION AKTUALISIEREN
    $element.find(".element_navigation").each(function () {
        Liste_ElementNavigationAktualisieren($(this), $element, liste);
    });
}
