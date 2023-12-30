function Liste_Aktualisieren($liste) {
    const liste = $liste.attr("data-liste");
    const instanz = $liste.attr("id");

    // TABELLE FILTERN
    let filtern = $liste.attr("data-filtern");
    if (typeof filtern !== "undefined") filtern = Liste_SqlFiltern2FilternZurueck(JSON.parse(filtern), liste);
    else filtern = new Array();
    const filtern_LocalStorage = G.LISTEN[liste].instanz[instanz].filtern;
    if (filtern_LocalStorage.length > 0) {
        if (liste == "termine" && G.LISTEN.termine.tabelle.length > 1 && "start" in G.LISTEN.termine.tabelle[1]) {
            const start_position = Liste_FilternEigenschaftPositionZurueck(filtern, "start");
            if (start_position.length > 1 && Liste_FilternEigenschaftPositionZurueck(filtern_LocalStorage, "start").length > 1)
                filtern = Liste_FilternPositionGeloeschtZurueck(filtern, start_position);
        }
        if (filtern.length == 0) filtern = filtern_LocalStorage;
        else filtern = [{ verknuepfung: "&&", filtern: filtern.concat(filtern_LocalStorage) }];
    }
    const tabelle_gefiltert = Liste_TabelleGefiltertZurueck(filtern, liste);

    // TABELLE SORTIEREN
    let sortieren = $liste.attr("data-sortieren");
    if (typeof sortieren !== "undefined") sortieren = JSON.parse(sortieren);
    else sortieren = new Array();
    const sortieren_LocalStorage = G.LISTEN[liste].instanz[instanz].sortieren;
    if (sortieren_LocalStorage.length > 0) sortieren = sortieren_LocalStorage;
    const tabelle_gefiltert_sortiert = Liste_ArraySortiertZurueck(tabelle_gefiltert, sortieren);

    // ELEMENTE IM DOM LÖSCHEN
    $liste.find(".element").each(function () {
        const $element = $(this);
        if (!tabelle_gefiltert_sortiert.includes(G.LISTEN[liste].tabelle[Number($element.attr("data-element_id"))])) $element.remove();
    });

    // ELEMENTE IM DOM ERGÄNZEN
    $.each(tabelle_gefiltert_sortiert, function (position, element) {
        const element_id = element["id"];
        const $element = $liste.find('.element[data-element_id="' + element_id + '"]');

        // Element wird nur hinzugefügt, falls es noch nicht existiert
        if (!$element.exists()) {
            // Blanko-Element wird geklont
            const $neues_element = G.LISTEN[liste].instanz[instanz].$blanko_element
                .clone()
                .removeClass("blanko invisible")
                .addClass("element")
                .attr("data-liste", liste)
                .attr("data-element_id", element_id);

            // Element hat einen Werkzeugkasten
            $neues_element
                .find('[data-bs-target="#werkzeugkasten_element_"]')
                .attr("data-bs-target", "#werkzeugkasten_element_" + G.LISTEN[liste].element + "_" + element_id);
            $neues_element
                .find(".werkzeugkasten_element")
                .attr("id", "werkzeugkasten_element_" + G.LISTEN[liste].element + "_" + element_id)
                .attr("data-bs-parent", '.liste[data-liste="' + liste + '"]');
            $neues_element.find(".werkzeug").attr("data-element_id", element_id);

            // Element hat Modal
            $neues_element.find('[data-bs-toggle="modal"]').attr("data-element_id", element_id);

            // Element hat einen Link
            $neues_element.find("a.stretched-link").attr("href", $neues_element.find(".stretched-link").attr("href") + "/" + element_id);

            // Element ist ein Check
            $neues_element.find("label").attr("for", element_id);
            $neues_element.find(".check").attr("id", element_id).val(element_id);

            let elemente_disabled = $liste.attr("data-elemente_disabled");
            if (typeof elemente_disabled !== "undefined") elemente_disabled = JSON.parse(elemente_disabled);
            else elemente_disabled = new Array();
            if (elemente_disabled.length > 0 && elemente_disabled.includes(element_id))
                $neues_element.find(".check").attr("disabled", true).siblings(".beschriftung").first().addClass("text-secondary");
            else $neues_element.find(".check").attr("disabled", false).siblings(".beschriftung").first().removeClass("text-secondary");

            // Element wird hinzugefügt (je nachdem, wo es in der Liste positioniert ist)
            if (position == 0) $neues_element.appendTo($liste);
            else $neues_element.insertAfter($liste.find('.element[data-element_id="' + tabelle_gefiltert_sortiert[position - 1]["id"] + '"]'));
        }
    });

    // ELEMENTE IM DOM SORTIEREN
    $.each(tabelle_gefiltert_sortiert, function (position, element) {
        const element_id = element["id"];
        const $element = $liste.find('.element[data-element_id="' + element_id + '"]');

        if (position == 0) $element.appendTo($liste);
        else $element.insertAfter($liste.find('.element[data-element_id="' + tabelle_gefiltert_sortiert[position - 1]["id"] + '"]'));
    });

    // LETZTEN SPACER AUS DER LISTE LÖSCHEN
    const $letztes_element = $liste.children().last();
    const $moeglicher_spacer = $letztes_element.children().last();
    if ($moeglicher_spacer.hasClass("spacer")) $moeglicher_spacer.remove();

    // ÜBERSCHRIFTEN EIN-/AUSBLENDEN
    if ($liste.children().length == 0) $liste.prev('.ueberschrift[data-instanz="' + instanz + '"]').addClass("invisible");
    else $liste.prev('.ueberschrift[data-instanz="' + instanz + '"]').removeClass("invisible");
}
