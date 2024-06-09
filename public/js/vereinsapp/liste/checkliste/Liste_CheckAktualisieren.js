function Liste_CheckAktualisieren($check, element_id, elemente_disabled, liste) {
    const $checkliste = $check.closest('.checkliste[data-liste="' + liste + '"]');
    const $label = $check.closest("label");

    $check.attr("id", element_id).val(element_id);

    let check_element_array = new Array();
    if ($checkliste.exists()) {
        const gegen_liste = $checkliste.attr("data-gegen_liste");
        const gegen_element_id = Number($checkliste.attr("data-gegen_element_id"));

        check_element_array = Liste_TabelleGefiltertZurueck(
            [
                {
                    verknuepfung: "&&",
                    filtern: [
                        { operator: "==", eigenschaft: LISTEN[gegen_liste].element + "_id", wert: gegen_element_id },
                        { operator: "==", eigenschaft: LISTEN[liste].element + "_id", wert: element_id },
                    ],
                },
            ],
            $checkliste.attr("data-checkliste")
        );

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
                                { operator: "==", eigenschaft: LISTEN[gegen_liste].element + "_id", wert: gegen_element_id },
                                { operator: "==", eigenschaft: LISTEN[liste].element + "_id", wert: element_id },
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
    }

    // Check setzen
    $check.attr("checked", check_element_array.length > 0);

    // Label mit dem Check verknüpfen
    $label.attr("for", element_id);

    // Check ggf. ausgrauen
    if (elemente_disabled.length > 0 && elemente_disabled.includes(element_id)) {
        $check.attr("disabled", true);
        $label.removeAttr("role");
    } else {
        $check.attr("disabled", false);
        $label.attr("role", "button");
    }
}
