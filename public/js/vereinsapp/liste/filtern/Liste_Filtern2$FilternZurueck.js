function Liste_Filtern2$FilternZurueck(filtern, instanz, liste) {
    let $filtern = $();

    $.each(filtern, function (index, knoten) {
        if ("verknuepfung" in knoten) {
            const verknuepfung = knoten.verknuepfung;
            const $neue_filtern_sammlung = FILTERN.$blanko_filtern_sammlung.clone().removeClass("blanko invisible").first();
            const $verknuepfung = $neue_filtern_sammlung.find(".verknuepfung");

            $verknuepfung.attr("data-verknuepfung", verknuepfung);

            if (verknuepfung == "&&") $verknuepfung.text("UND");
            else if (verknuepfung == "||") $verknuepfung.text("ODER");

            $neue_filtern_sammlung.find(".filtern_kind").append(Liste_Filtern2$FilternZurueck(knoten.filtern, instanz, liste));

            $filtern = $filtern.add($neue_filtern_sammlung);
        } else {
            const operator = knoten.operator;
            const eigenschaft = knoten.eigenschaft;
            const wert = knoten.wert;

            const $neues_filtern_element = FILTERN.$blanko_filtern_element.clone().removeClass("blanko invisible");
            $neues_filtern_element.find(".eigenschaft").attr("data-eigenschaft", eigenschaft).text(EIGENSCHAFTEN[liste][eigenschaft].beschriftung);
            $neues_filtern_element.find(".operator").attr("data-operator", operator).text(operator);
            $neues_filtern_element
                .find(".wert")
                .attr("data-wert", Schnittstelle_LocalstorageWertBereinigtZurueck(wert))
                .html(Liste_WertFormatiertZurueck(wert, eigenschaft, liste));

            $filtern = $filtern.add($neues_filtern_element);
        }
    });

    $filtern.find(".btn_filtern_loeschen, .btn_filtern_aendern").attr("data-liste", liste).attr("data-instanz", instanz);

    return $filtern;
}
