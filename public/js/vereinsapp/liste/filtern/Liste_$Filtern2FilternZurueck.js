function Liste_$Filtern2FilternZurueck($filtern, klasse, liste) {
    const filtern = new Array();

    $filtern.children("." + klasse + "_element, ." + klasse + "_sammlung").each(function () {
        const $knoten = $(this);

        if ($knoten.hasClass("" + klasse + "_sammlung"))
            filtern.push({
                verknuepfung: $knoten.find(".verknuepfung").attr("data-verknuepfung"),
                filtern: Liste_$Filtern2FilternZurueck($knoten.find("." + klasse + "_kind").first(), klasse, liste),
            });
        else if ($knoten.hasClass("" + klasse + "_element"))
            filtern.push({
                operator: $knoten.find(".operator").attr("data-operator"),
                eigenschaft: $knoten.find(".eigenschaft").attr("data-eigenschaft"),
                wert: Schnittstelle_VariableWertBereinigtZurueck($knoten.find(".wert").attr("data-wert")),
            });
    });

    return filtern;
}
