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
    let istCheckliste = false;
    let hatKlasseId = false;
    let gegen_liste = undefined;
    let gegen_element_id = undefined;
    let bedingte_formatierung = new Object();
    let elemente_disabled = new Array();
    if ($liste.exists()) {
        istCheckliste = $liste.hasClass("checkliste");
        hatKlasseId = $liste.hasClass("klasse_id");
        const gegen_liste_data = $liste.attr("data-gegen_liste");
        if (typeof gegen_liste_data !== "undefined") gegen_liste = gegen_liste_data;
        const gegen_element_id_data = $liste.attr("data-gegen_element_id");
        if (typeof gegen_element_id_data !== "undefined") gegen_element_id = gegen_element_id_data;
        const bedingte_formatierung_data = $liste.attr("data-bedingte_formatierung");
        if (typeof bedingte_formatierung_data !== "undefined") bedingte_formatierung = JSON.parse(bedingte_formatierung_data);
        const elemente_disabled_data = $liste.attr("data-elemente_disabled");
        if (typeof elemente_disabled_data !== "undefined") elemente_disabled = JSON.parse(elemente_disabled_data);
    }

    if (!$element.find("a.stretched-link").exists() && !istCheckliste && !hatKlasseId) {
        $element.removeClass("list-group-item-action");
        $element.removeAttr("role");
        $element.find(".beschriftung").removeClass("text-secondary");
        $element.find("a.stretched-link").removeAttr("href");
    } else if (Array.isArray(elemente_disabled) && elemente_disabled.length > 0 && elemente_disabled.includes(element_id)) {
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
    // BESCHRIFTUNG BEDINGT FORMATIEREN (FALLS ES EINE ZUGEHÖRIGE LISTE GIBT)
    if (
        isObject(bedingte_formatierung) &&
        "liste" in bedingte_formatierung &&
        "klasse" in bedingte_formatierung &&
        typeof gegen_liste !== "undefined" &&
        typeof gegen_element_id !== "undefined"
    )
        $.each(bedingte_formatierung.klasse, function (klasse, filtern) {
            if (
                Liste_TabelleGefiltertZurueck(
                    [
                        {
                            verknuepfung: "&&",
                            filtern: [
                                { operator: "==", eigenschaft: LISTEN[gegen_liste].element + "_id", wert: gegen_element_id },
                                { operator: "==", eigenschaft: LISTEN[liste].element + "_id", wert: element_id },
                                { operator: filtern.operator, eigenschaft: filtern.eigenschaft, wert: filtern.wert },
                            ],
                        },
                    ],
                    bedingte_formatierung.liste
                ).length > 0
            )
                $element.find(".beschriftung").addClass(klasse);
            else $element.find(".beschriftung").removeClass(klasse);
        });

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
