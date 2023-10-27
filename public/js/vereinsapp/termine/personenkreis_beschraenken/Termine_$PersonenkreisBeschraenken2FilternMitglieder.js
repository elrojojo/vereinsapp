function Termine_$PersonenkreisBeschraenken2FilternMitglieder($personenkreis_beschraenken, liste) {
    const LISTE = LISTEN[liste];
    const filtern = new Array();

    $personenkreis_beschraenken
        .children(".personenkreis_beschraenken_element, .personenkreis_beschraenken_sammlung")
        .each(function () {
            const $knoten = $(this);

            if ($knoten.hasClass("personenkreis_beschraenken_sammlung")) {
                const verknuepfung = $knoten.find(".verknuepfung").attr("data-verknuepfung");
                filtern.push({
                    verknuepfung: verknuepfung,
                    filtern: Termine_$PersonenkreisBeschraenken2FilternMitglieder(
                        $knoten.find(".personenkreis_beschraenken_kind").first(),
                        liste
                    ),
                });
            } else if ($knoten.hasClass("personenkreis_beschraenken_element")) {
                const operator = $knoten.find(".operator").attr("data-operator");
                const eigenschaft = $knoten.find(".eigenschaft").attr("data-eigenschaft");
                let wert = $knoten.find(".wert").attr("data-wert");

                if (wert && !Number.isNaN(Number(wert)) && typeof wert !== "boolean")
                    wert = Number(wert);
                if (
                    typeof EIGENSCHAFTEN[LISTE.controller][liste][eigenschaft] !== "undefined" &&
                    EIGENSCHAFTEN[LISTE.controller][liste][eigenschaft]["typ"] == "zeitpunkt"
                )
                    wert = DateTime.fromFormat(wert, SQL_DATETIME);
                filtern.push({
                    operator: operator,
                    eigenschaft: eigenschaft,
                    wert: wert,
                });
            }
        });

    return filtern;
}
