function Liste_Filtern2$FilternZurueck(filtern, $blanko_filtern_sammlung, $blanko_filtern_element, klasse, liste) {
    const $filtern = new Array();

    $.each(filtern, function (index, knoten) {
        if ("verknuepfung" in knoten) {
            const verknuepfung = knoten.verknuepfung;
            const $neue_filtern_sammlung = $blanko_filtern_sammlung
                .clone()
                .removeClass("blanko invisible")
                .addClass(klasse + "_sammlung");
            const $verknuepfung = $neue_filtern_sammlung.find(".verknuepfung");

            $verknuepfung.attr("data-verknuepfung", verknuepfung);

            if (verknuepfung == "&&") $verknuepfung.text("UND");
            else if (verknuepfung == "||") $verknuepfung.text("ODER");

            $.each(
                Liste_Filtern2$FilternZurueck(knoten.filtern, $blanko_filtern_sammlung, $blanko_filtern_element, klasse, liste),
                function (index, $filtern) {
                    $filtern.appendTo($neue_filtern_sammlung.find("." + klasse + "_kind").first());
                }
            );

            $filtern.push($neue_filtern_sammlung);
        } else {
            const operator = knoten.operator;
            const eigenschaft = knoten.eigenschaft;
            const wert = knoten.wert;

            const $neues_filtern_element = $blanko_filtern_element
                .clone()
                .removeClass("blanko invisible")
                .addClass(klasse + "_element");
            $neues_filtern_element
                .find(".eigenschaft")
                .attr("data-eigenschaft", eigenschaft)
                .text(EIGENSCHAFTEN[G.LISTEN[liste].controller][liste][eigenschaft].beschriftung);
            $neues_filtern_element.find(".operator").attr("data-operator", operator).text(operator);
            $neues_filtern_element
                .find(".wert")
                .attr("data-wert", Schnittstelle_DomWertBereinigtZurueck(wert))
                .html(Liste_WertFormatiertZurueck(wert, eigenschaft, liste));
            $neues_filtern_element.find(".btn_filtern_loeschen").attr("data-liste", liste);

            $filtern.push($neues_filtern_element);
        }
    });

    return $filtern;
}
