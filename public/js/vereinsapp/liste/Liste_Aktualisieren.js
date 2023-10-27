function Liste_Aktualisieren($liste, liste) {
    // TABELLE FILTERN
    let filtern = $liste.attr("data-filtern");
    if (typeof filtern !== "undefined") filtern = Liste_PhpFiltern2Filtern(JSON.parse(filtern), liste);
    else filtern = new Array();
    if (LISTEN[liste].filtern.length >= 1) filtern = [{ verknuepfung: "&&", filtern: filtern.concat(LISTEN[liste].filtern) }];
    const tabelle_gefiltert = Liste_TabelleFiltern(filtern, liste);

    // TABELLE SORTIEREN
    let sortieren = $liste.attr("data-sortieren");
    if (typeof sortieren !== "undefined") sortieren = JSON.parse(sortieren);
    else sortieren = new Array();
    if (LISTEN[liste].sortieren.length >= 1) sortieren = LISTEN[liste].sortieren.concat(sortieren);
    const tabelle_gefiltert_sortiert = Liste_ArraySortieren(tabelle_gefiltert, sortieren);

    // DOM LÖSCHEN
    $liste.find('.element[data-element="' + LISTEN[liste].element + '"]').each(function () {
        const $element = $(this);
        if (!tabelle_gefiltert_sortiert.includes(LISTEN[liste].tabelle[Number($element.attr("data-element_id"))])) $element.remove();
    });

    // DOM ERGÄNZEN
    $.each(tabelle_gefiltert_sortiert, function (position, element) {
        const element_id = element["id"];
        const $element = $liste.find('.element[data-element="' + LISTEN[liste].element + '"][data-element_id="' + element_id + '"]');

        if (!$element.exists()) {
            const $neues_element = LISTEN[liste].$blanko_element[$liste.attr("id")]
                .clone()
                .removeClass("blanko invisible")
                .addClass("element")
                .attr("data-element", LISTEN[liste].element)
                .attr("data-element_id", element_id);

            // Werkzeugkasten
            $neues_element
                .find('[data-bs-target="#werkzeugkasten_"]')
                .attr("data-bs-target", "#werkzeugkasten_" + LISTEN[liste].element + "_" + element_id);
            $neues_element
                .find("#werkzeugkasten_")
                .attr("id", "werkzeugkasten_" + LISTEN[liste].element + "_" + element_id)
                .attr("data-bs-parent", '.liste[data-liste="' + liste + '"]');

            // link
            $neues_element.find("a.stretched-link").attr("href", $neues_element.find(".stretched-link").attr("href") + "/" + element_id);

            // check
            $neues_element.find("label").attr("for", element_id);
            $neues_element.find(".check").attr("id", element_id).val(element_id);

            if (position == 0) $neues_element.appendTo($liste);
            else
                $neues_element.insertAfter(
                    $liste.find(
                        '.element[data-element="' +
                            LISTEN[liste].element +
                            '"][data-element_id="' +
                            tabelle_gefiltert_sortiert[position - 1]["id"] +
                            '"]'
                    )
                );
        }
    });

    // DOM SORTIEREN
    $.each(tabelle_gefiltert_sortiert, function (position, element) {
        const element_id = element["id"];
        const $element = $liste.find('.element[data-element="' + LISTEN[liste].element + '"][data-element_id="' + element_id + '"]');

        if (position == 0) $element.appendTo($liste);
        else
            $element.insertAfter(
                $liste.find(
                    '.element[data-element="' + LISTEN[liste].element + '"][data-element_id="' + tabelle_gefiltert_sortiert[position - 1]["id"] + '"]'
                )
            );
    });

    // LETZTEN SPACER AUS DER LISTE LÖSCHEN
    const $letztes_element = $liste.children().last();
    if ($letztes_element.children().last().hasClass("spacer")) $letztes_element.children().last().remove();

    // ÜBERSCHRIFTEN EIN-/AUSBLENDEN
    if ($liste.children().length == 0) $liste.prev('.ueberschrift[data-liste_id="' + $liste.attr("id") + '"]').addClass("invisible");
    else $liste.prev('.ueberschrift[data-liste_id="' + $liste.attr("id") + '"]').removeClass("invisible");
}
