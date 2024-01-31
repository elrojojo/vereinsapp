function Liste_ElementAktualisieren($element, liste) {
    const element_id = Number($element.attr("data-element_id"));

    // EIGENSCHAFTEN AKTUALISIEREN
    $element.find(".eigenschaft").each(function () {
        const $eigenschaft = $(this);
        const eigenschaft = $eigenschaft.attr("data-eigenschaft");
        const wert = Schnittstelle_VariableRausZurueck(eigenschaft, Number($element.attr("data-element_id")), liste, "tabelle");
        $eigenschaft.html(Liste_WertFormatiertZurueck(wert, eigenschaft, liste));
    });

    // CHECK AKTUALISIEREN
    $element.find(".check").each(function () {
        const $check = $(this);
        const $checkliste = $check.closest(".checkliste");

        if ($checkliste.exists()) {
            const checkliste = $check.attr("name");
            const element = G.LISTEN[liste].element;
            const gegen_liste = $checkliste.attr("data-gegen_liste");
            const gegen_element = G.LISTEN[gegen_liste].element;
            const gegen_element_id = Number($checkliste.attr("data-gegen_element_id"));

            const check_element_array = Liste_TabelleGefiltertZurueck(
                [
                    {
                        verknuepfung: "&&",
                        filtern: [
                            { operator: "==", eigenschaft: gegen_element + "_id", wert: gegen_element_id },
                            { operator: "==", eigenschaft: element + "_id", wert: element_id },
                        ],
                    },
                ],
                checkliste
            );

            // Check setzen
            $check.attr("checked", check_element_array.length > 0);

            // Check bedingt formatieren
            let bedingte_formatierung = $checkliste.attr("data-bedingte_formatierung");
            if (typeof bedingte_formatierung !== "undefined") bedingte_formatierung = JSON.parse(bedingte_formatierung);
            else bedingte_formatierung = new Object();
            let bedingte_formatierung_klasse = undefined;
            if ("klasse" in bedingte_formatierung) {
                $.each(bedingte_formatierung.klasse, function (klasse, filtern) {
                    const bedingte_formatierung_element_array = Liste_TabelleGefiltertZurueck(
                        [
                            {
                                verknuepfung: "&&",
                                filtern: [
                                    { operator: "==", eigenschaft: gegen_element + "_id", wert: gegen_element_id },
                                    { operator: "==", eigenschaft: element + "_id", wert: element_id },
                                    { operator: filtern.operator, eigenschaft: filtern.eigenschaft, wert: filtern.wert },
                                ],
                            },
                        ],
                        bedingte_formatierung.liste
                    );

                    if (bedingte_formatierung_element_array.length > 0) {
                        bedingte_formatierung_klasse = klasse;
                        return false;
                    }
                });

                $.each(bedingte_formatierung.klasse, function (klasse) {
                    if (bedingte_formatierung_klasse == klasse) $check.siblings(".beschriftung").first().addClass(klasse);
                    else $check.siblings(".beschriftung").first().removeClass(klasse);
                });
            }

            // Check ausgrauen
            let elemente_disabled = $checkliste.attr("data-elemente_disabled");
            if (typeof elemente_disabled !== "undefined") elemente_disabled = JSON.parse(elemente_disabled);
            else elemente_disabled = new Array();
            if (elemente_disabled.length > 0 && elemente_disabled.includes(element_id))
                $check.attr("disabled", true).siblings(".beschriftung").first().addClass("text-secondary");
            else $check.attr("disabled", false).siblings(".beschriftung").first().removeClass("text-secondary");
        }
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
