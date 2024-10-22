function Liste_Aktualisieren($liste, liste) {
    const instanz = $liste.attr("id");

    // TABELLE FILTERN
    // filtern aus data
    let filtern_data = $liste.attr("data-filtern");
    if (typeof filtern_data !== "undefined") filtern_data = Schnittstelle_VariableArrayBereinigtZurueck(JSON.parse(filtern_data));
    else filtern_data = new Array();
    // filtern aus LocalStorage
    const filtern_LocalStorage = LISTEN[liste].instanz[instanz].filtern;
    // data und LocalStorage kombinieren
    let filtern_kombiniert;
    if (filtern_LocalStorage.length === 0) filtern_kombiniert = filtern_data;
    else if (filtern_data.length === 0) filtern_kombiniert = filtern_LocalStorage;
    else {
        if (liste == "termine" && Liste_FilternEigenschaftPositionZurueck(filtern_LocalStorage, "start").length > 1)
            filtern_kombiniert = filtern_LocalStorage;
        else filtern_kombiniert = [{ verknuepfung: "&&", filtern: [filtern_data[0], filtern_LocalStorage[0]] }];
    }
    const tabelle_gefiltert = Liste_TabelleGefiltertZurueck(filtern_kombiniert, liste);

    // TABELLE SORTIEREN
    // sortieren aus data
    let sortieren_data = $liste.attr("data-sortieren");
    if (typeof sortieren_data !== "undefined") sortieren_data = JSON.parse(sortieren_data);
    else sortieren_data = new Array();
    // sortieren aus LocalStorage
    const sortieren_LocalStorage = LISTEN[liste].instanz[instanz].sortieren;
    // data und LocalStorage kombinieren
    let sortieren_kombiniert;
    if (sortieren_LocalStorage.length === 0) sortieren_kombiniert = sortieren_data;
    else sortieren_kombiniert = sortieren_LocalStorage;
    const tabelle_gefiltert_sortiert = Liste_ArraySortiertZurueck(tabelle_gefiltert, sortieren_kombiniert);

    // ELEMENTE IM DOM LÖSCHEN
    $liste.find(".element").each(function () {
        const $element = $(this);
        const element_id = Number($element.attr("data-element_id"));
        const element = LISTEN[liste].tabelle[element_id];
        if (!tabelle_gefiltert_sortiert.includes(element)) $element.remove();
    });

    // ELEMENTE IM DOM ERGÄNZEN
    $.each(tabelle_gefiltert_sortiert, function (position, element) {
        const element_id = element["id"];
        const $element = $liste.find('.element[data-element_id="' + element_id + '"]');

        // Element wird nur hinzugefügt, falls es noch nicht existiert
        if (!$element.exists()) {
            const $neues_element = LISTEN[liste].instanz[instanz].$blanko_element.clone().removeClass("blanko invisible");

            $neues_element.attr("data-liste", liste).attr("data-element_id", element_id);

            const gegen_liste = $liste.attr("data-gegen_liste");
            const gegen_element_id = $liste.attr("data-gegen_element_id");
            if (typeof $neues_element.attr("data-gegen_liste") === "undefined" && typeof gegen_liste !== "undefined")
                $neues_element.attr("data-gegen_liste", gegen_liste);
            if (typeof $neues_element.attr("data-gegen_element_id") === "undefined" && typeof gegen_element_id !== "undefined")
                $neues_element.attr("data-gegen_element_id", gegen_element_id);

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
}
