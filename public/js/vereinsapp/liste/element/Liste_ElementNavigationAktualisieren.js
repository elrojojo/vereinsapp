function Liste_ElementNavigationAktualisieren($element_navigation, $element, liste) {
    const $vorheriges_element = $element_navigation.find(".vorheriges_element");
    const $naechstes_element = $element_navigation.find(".naechstes_element");
    const instanz = $element_navigation.attr("data-instanz");

    // TABELLE FILTERN
    // filtern aus data
    let filtern_data = $element_navigation.attr("data-filtern");
    if (typeof filtern_data !== "undefined") filtern_data = Schnittstelle_VariableArrayBereinigtZurueck(JSON.parse(filtern_data));
    else filtern_data = new Array();
    // filtern aus LocalStorage (Problem: LISTEN[liste].instanz[instanz].filtern existiert nicht, weil keine .liste mit dieser instanz existiert)
    let filtern_LocalStorage = Schnittstelle_LocalstorageRausZurueck(liste + "_" + instanz + "_filtern");
    if (typeof filtern_LocalStorage === "undefined") filtern_LocalStorage = new Array();
    function LOC_upd_VAR_filtern(filtern, liste) {
        $.each(filtern, function (index, knoten) {
            if ("verknuepfung" in knoten) LOC_upd_VAR_filtern(knoten.filtern, liste);
            else if ("operator" in knoten) knoten.wert = Schnittstelle_VariableWertBereinigtZurueck(knoten.wert);
        });
    }
    LOC_upd_VAR_filtern(filtern_LocalStorage, liste);
    // data und LocalStorage kombinieren
    let filtern_kombiniert;
    if (filtern_LocalStorage.length == 0) filtern_kombiniert = filtern_data;
    else if (filtern_data.length == 0) filtern_kombiniert = filtern_LocalStorage;
    else {
        if (liste == "termine" && Liste_FilternEigenschaftPositionZurueck(filtern_LocalStorage, "start").length > 1) {
            const start_position = Liste_FilternEigenschaftPositionZurueck(filtern_data, "start");
            if (start_position.length > 1) filtern_data = Liste_FilternPositionGeloeschtZurueck(filtern_data, start_position);
        }
        filtern_kombiniert = [{ verknuepfung: "&&", filtern: [filtern_data[0], filtern_LocalStorage[0]] }];
    }
    const tabelle_gefiltert = Liste_TabelleGefiltertZurueck(filtern_kombiniert, liste);

    // TABELLE SORTIEREN
    // sortieren aus data
    let sortieren_data = $element_navigation.attr("data-sortieren");
    if (typeof sortieren_data !== "undefined") sortieren_data = JSON.parse(sortieren_data);
    else sortieren_data = new Array();
    // sortieren aus LocalStorage (Problem: LISTEN[liste].instanz[instanz].sortieren existiert nicht, weil keine .liste mit dieser instanz existiert)
    let sortieren_LocalStorage = Schnittstelle_LocalstorageRausZurueck(liste + "_" + instanz + "_sortieren");
    if (typeof sortieren_LocalStorage === "undefined") sortieren_LocalStorage = new Array();
    // data und LocalStorage kombinieren
    let sortieren_kombiniert;
    if (sortieren_LocalStorage.length == 0) sortieren_kombiniert = sortieren_data;
    else sortieren_kombiniert = sortieren_LocalStorage;
    const tabelle_gefiltert_sortiert = Liste_ArraySortiertZurueck(tabelle_gefiltert, sortieren_kombiniert);

    let vorherige_element_id = undefined;
    let naechste_element_id = undefined;
    $.each(tabelle_gefiltert_sortiert, function (position, element) {
        if (element["id"] == Number($element.attr("data-element_id"))) {
            if (position > 0) vorherige_element_id = tabelle_gefiltert_sortiert[position - 1]["id"];
            if (position < tabelle_gefiltert_sortiert.length - 1) naechste_element_id = tabelle_gefiltert_sortiert[position + 1]["id"];
        }
    });

    if (typeof vorherige_element_id === "undefined") $vorheriges_element.addClass("invisible").removeAttr("href");
    else $vorheriges_element.removeClass("invisible").attr("href", BASE_URL + liste + "/details/" + vorherige_element_id);

    if (typeof naechste_element_id === "undefined") $naechstes_element.addClass("invisible").removeAttr("href");
    else $naechstes_element.removeClass("invisible").attr("href", BASE_URL + liste + "/details/" + naechste_element_id);
}
