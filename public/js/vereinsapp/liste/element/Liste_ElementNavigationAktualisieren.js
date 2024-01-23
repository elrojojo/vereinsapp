function Liste_ElementNavigationAktualisieren($element_navigation, $element, liste) {
    const $vorheriges_element = $element_navigation.find(".vorheriges_element");
    const $naechstes_element = $element_navigation.find(".naechstes_element");
    const instanz = $element_navigation.attr("data-instanz");

    // TABELLE FILTERN
    let filtern = $element_navigation.attr("data-filtern");
    if (typeof filtern !== "undefined") filtern = Liste_SqlFiltern2FilternZurueck(JSON.parse(filtern), liste);
    else filtern = new Array();
    // filtern wird aus dem Localstorage geholt und in der Variable gespeichert
    let filtern_LocalStorage = Schnittstelle_LocalstorageRausZurueck(liste + "_" + instanz + "_filtern");
    if (typeof filtern_LocalStorage === "undefined") filtern_LocalStorage = new Array();
    function LOC_upd_VAR_filtern(filtern, liste) {
        $.each(filtern, function (index, knoten) {
            if ("verknuepfung" in knoten) LOC_upd_VAR_filtern(knoten.filtern, liste);
            else if ("operator" in knoten) knoten.wert = Schnittstelle_VariableWertBereinigtZurueck(knoten.wert);
        });
    }
    LOC_upd_VAR_filtern(filtern_LocalStorage, liste);
    if (filtern_LocalStorage.length > 0) {
        if (liste == "termine") {
            // && G.LISTEN.termine.tabelle.length > 1 && "start" in G.LISTEN.termine.tabelle[1]) { erzeugt Fehler, weil ID 1 evtl. nicht belegt ist
            const start_position = Liste_FilternEigenschaftPositionZurueck(filtern, "start");
            if (start_position.length > 1 && Liste_FilternEigenschaftPositionZurueck(filtern_LocalStorage, "start").length > 1)
                filtern = Liste_FilternPositionGeloeschtZurueck(filtern, start_position);
        }
        if (filtern.length == 0) filtern = filtern_LocalStorage;
        else filtern = [{ verknuepfung: "&&", filtern: filtern.concat(filtern_LocalStorage) }];
    }
    const tabelle_gefiltert = Liste_TabelleGefiltertZurueck(filtern, liste);

    // TABELLE SORTIEREN
    let sortieren = $element_navigation.attr("data-sortieren");
    if (typeof sortieren !== "undefined") sortieren = JSON.parse(sortieren);
    else sortieren = new Array();
    // sortieren wird aus dem Localstorage geholt und in der Variable gespeichert
    let sortieren_LocalStorage = Schnittstelle_LocalstorageRausZurueck(liste + "_" + instanz + "_sortieren");
    if (typeof sortieren_LocalStorage === "undefined") sortieren_LocalStorage = new Array();
    if (sortieren_LocalStorage.length > 0) sortieren = sortieren_LocalStorage;
    const tabelle_gefiltert_sortiert = Liste_ArraySortiertZurueck(tabelle_gefiltert, sortieren);

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
