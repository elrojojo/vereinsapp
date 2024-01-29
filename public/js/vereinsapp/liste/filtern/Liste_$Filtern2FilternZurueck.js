function Liste_$Filtern2FilternZurueck($filtern, liste) {
    const filtern = new Array();

    $filtern.children(".filtern_element, .filtern_sammlung").each(function () {
        const $knoten = $(this);

        if ($knoten.hasClass("filtern_sammlung"))
            filtern.push({
                verknuepfung: $knoten.find(".verknuepfung").attr("data-verknuepfung"),
                filtern: Liste_$Filtern2FilternZurueck($knoten.find(".filtern_kind").first(), liste),
            });
        else if ($knoten.hasClass("filtern_element"))
            filtern.push({
                operator: $knoten.find(".operator").attr("data-operator"),
                eigenschaft: $knoten.find(".eigenschaft").attr("data-eigenschaft"),
                wert: Schnittstelle_VariableWertBereinigtZurueck($knoten.find(".wert").attr("data-wert")),
            });
    });

    return filtern;
}
