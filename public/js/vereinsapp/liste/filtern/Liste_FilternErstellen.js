function Liste_FilternErstellen($btn) {
    const liste = $btn.attr("data-liste");
    const instanz = $btn.attr("data-instanz");
    const $formular = $btn.closest(".modal.filtern");

    const $filtern = $formular.find(".filtern");
    const $filtern_definition = $btn.closest(".filtern_definition");

    const filtern = new Array();
    $filtern_definition.find(".filtern_wert").each(function () {
        const $filtern_wert = $(this);
        if ($filtern_wert.val())
            filtern.push({
                operator: $filtern_wert.attr("data-operator"),
                eigenschaft: $filtern_definition.attr("data-eigenschaft"),
                wert: Schnittstelle_VariableWertBereinigtZurueck($filtern_wert.val()),
            });
    });

    let filtern_knoten = filtern;
    if (filtern.length > 1) filtern_knoten = [{ verknuepfung: "&&", filtern: filtern }];

    const $filtern_knoten = Liste_Filtern2$FilternZurueck(filtern_knoten, liste);

    if ($filtern.find(".filtern_sammlung").length == 0 && $filtern.find(".filtern_element").length == 0) $filtern.append($filtern_knoten);
    else if ($filtern.find(".filtern_kind").length > 0) $filtern.find(".filtern_kind").first().append($filtern_knoten);
    else {
        const $filtern_zwischenspeicher = $filtern.html();
        const $filtern_sammlung = Liste_Filtern2$FilternZurueck([{ verknuepfung: "&&", filtern: new Array() }], liste);
        $filtern.html($filtern_sammlung);
        $filtern.find(".filtern_kind").first().html($filtern_zwischenspeicher).append($filtern_knoten);
    }

    // if (typeof instanz !== "undefined") {
    G.LISTEN[liste].instanz[instanz].filtern = Liste_$Filtern2FilternZurueck($filtern, liste);
    Schnittstelle_EventVariableUpdLocalstorage(liste, [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);
    // }

    Liste_FilternAktualisieren($formular, liste);
}
