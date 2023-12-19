function Liste_SortierenFormularOeffnen($formular, $btn_oeffnend) {
    const aktion = $btn_oeffnend.attr("data-aktion");
    const liste = $btn_oeffnend.attr("data-liste");
    const liste_id = $btn_oeffnend.attr("data-liste_id");
    // const element = G.LISTEN[liste].element;
    // let element_id = $btn_oeffnend.attr("data-element_id");

    $formular.find(".modal-title").text(bezeichnung_kapitalisieren(unix2umlaute(liste_id)) + " " + unix2umlaute(aktion));
    $formular.find(".sortieren, .sortieren_definitionen").attr("data-liste_id", liste_id);
    const $sortieren_definitionen = $formular.find(".sortieren_definitionen");
    $sortieren_definitionen.find(".sortieren_eigenschaft").empty();
    $.each(SORTIERBARE_EIGENSCHAFTEN[liste], function (index, eigenschaft) {
        $('<option value="' + eigenschaft + '">' + EIGENSCHAFTEN[G.LISTEN[liste].controller][liste][eigenschaft].beschriftung + "</option>").appendTo(
            $sortieren_definitionen.find(".sortieren_eigenschaft")
        );
    });

    $sortieren_definitionen.find(".btn_sortieren_erstellen").first().attr("data-liste", liste).attr("data-liste_id", liste_id);

    Schnittstelle_EventVariableUpdDom();
}
