function Termine_FilternMitglieder2$PersonenkreisBeschraenken(filtern, liste) {
    const LISTE = LISTEN[liste];
    const $filtern = new Array();

    $.each(filtern, function (index, knoten) {
        if ("verknuepfung" in knoten) {
            const verknuepfung = knoten.verknuepfung;
            const $neue_filtern_sammlung =
                PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_sammlung
                    .clone()
                    .removeClass("blanko invisible")
                    .addClass("personenkreis_beschraenken_sammlung");
            const $verknuepfung = $neue_filtern_sammlung.find(".verknuepfung");
            $verknuepfung.attr("data-verknuepfung", verknuepfung);

            if (verknuepfung == "&&") $verknuepfung.text("UND");
            else if (verknuepfung == "||") $verknuepfung.text("ODER");
            $.each(
                Termine_FilternMitglieder2$PersonenkreisBeschraenken(knoten.filtern, liste),
                function (index, $filtern) {
                    $filtern.appendTo(
                        $neue_filtern_sammlung.find(".personenkreis_beschraenken_kind").first()
                    );
                }
            );
            $filtern.push($neue_filtern_sammlung);
        } else {
            const operator = knoten.operator;
            const eigenschaft = knoten.eigenschaft;
            const wert = knoten.wert;

            const $neues_filtern_element =
                PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_element
                    .clone()
                    .removeClass("blanko invisible")
                    .addClass("personenkreis_beschraenken_element");
            $neues_filtern_element
                .find(".eigenschaft")
                .attr("data-eigenschaft", eigenschaft)
                .text(EIGENSCHAFTEN[LISTE.controller][liste][eigenschaft].beschriftung);
            $neues_filtern_element.find(".operator").attr("data-operator", operator).text(operator);

            let data_wert = wert;
            if (EIGENSCHAFTEN[LISTE.controller][liste][eigenschaft].typ == "zeitpunkt")
                data_wert = wert.toFormat(SQL_DATETIME);
            $neues_filtern_element
                .find(".wert")
                .attr("data-wert", data_wert)
                .html(Liste_WertFormatieren(wert, eigenschaft, liste));
            $neues_filtern_element.find(".btn_filtern_loeschen").attr("data-liste", liste);

            $filtern.push($neues_filtern_element);
        }
    });

    return $filtern;
}
