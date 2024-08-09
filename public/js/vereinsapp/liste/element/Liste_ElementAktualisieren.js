function Liste_ElementAktualisieren($element, liste) {
    const element_id = Number($element.attr("data-element_id"));
    const $liste = $element.closest('.liste[data-liste="' + liste + '"]');
    const gegen_liste = $element.attr("data-gegen_liste");
    const gegen_element_id = $element.attr("data-gegen_element_id");

    // ELEMENTE DISABLED
    let disabled = $element.attr("data-disabled");
    if (typeof disabled !== "undefined") {
        disabled = JSON.parse(disabled);
        if (
            Liste_TabelleGefiltertZurueck(
                [
                    {
                        verknuepfung: "&&",
                        filtern: [{ operator: "==", eigenschaft: "id", wert: element_id }, disabled.filtern[0]],
                    },
                ],
                disabled.liste
            ).length > 0
        )
            disabled = true;
        else disabled = false;
    } else disabled = false;

    // BEDINGTE FORMATIERUNG
    let bedingte_formatierung = $element.attr("data-bedingte_formatierung");
    if (typeof bedingte_formatierung !== "undefined") bedingte_formatierung = JSON.parse(bedingte_formatierung);
    else bedingte_formatierung = new Object();

    // LINK AKTUALISIEREN ODER ELEMENT DEAKTIVIEREN (FALLS ES EINE ZUGEHÖRIGE LISTE GIBT)
    let hatKlasseId = false;
    if ($liste.exists()) hatKlasseId = $liste.hasClass("klasse_id");

    if (!$element.find("a.stretched-link").exists() && !$element.find(".check").exists() && !hatKlasseId) {
        $element.removeClass("list-group-item-action");
        $element.removeAttr("role");
        $element.find(".beschriftung").removeClass("text-secondary");
        $element.find("a.stretched-link").removeAttr("href");
    } else {
        $element.addClass("list-group-item-action");
        $element.attr("role", "button");
        $element.find(".beschriftung").removeClass("text-secondary");
        $element.find("a.stretched-link").attr("href", BASE_URL + LISTEN[liste].controller + "/" + element_id);
    }

    // ELEMENT DISABLED FORMATIEREN
    if (disabled) {
        $element.removeClass("list-group-item-action");
        $element.removeAttr("role");
        $element.find(".beschriftung").addClass("text-secondary");
        $element.find("a.stretched-link").removeAttr("href");
    } else $element.find(".beschriftung").removeClass("text-secondary");

    // ELEMENT BEDINGT FORMATIEREN
    if (
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

    // EIGENSCHAFTEN AKTUALISIEREN
    $element.find(".eigenschaft").each(function () {
        const $eigenschaft = $(this);
        const eigenschaft = $eigenschaft.attr("data-eigenschaft");
        const wert = Schnittstelle_VariableRausZurueck(eigenschaft, Number($element.attr("data-element_id")), liste);
        $eigenschaft.html(Liste_WertFormatiertZurueck(wert, eigenschaft, liste));
    });

    // CHECK AKTUALISIEREN
    $element.find(".check").each(function () {
        Liste_CheckAktualisieren($(this), element_id, disabled, liste);
    });

    // WERKZEUGKASTEN AKTUALISIEREN
    $element.find('[data-bs-toggle="offcanvas"][data-bs-target="#werkzeugkasten"]').attr("data-element_id", element_id);

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
