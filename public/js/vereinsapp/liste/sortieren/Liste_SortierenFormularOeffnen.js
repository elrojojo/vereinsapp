function Liste_SortierenFormularOeffnen($formular, $btn_oeffnend) {
    const liste = $btn_oeffnend.attr("data-liste");
    const instanz = $btn_oeffnend.attr("data-instanz");
    // const eigenschaft = $btn_oeffnend.attr("data-eigenschaft");
    // let sortieren_liste = $btn_oeffnend.attr("data-sortieren_liste");
    // const element_id = $btn_oeffnend.attr("data-element_id");

    $formular.find(".sortieren, .sortieren_definitionen").attr("data-instanz", instanz);
    const $sortieren_definitionen = $formular.find(".sortieren_definitionen");
    $sortieren_definitionen.find(".sortieren_eigenschaft").empty();
    $.each(SORTIERBARE_EIGENSCHAFTEN[liste], function (index, eigenschaft) {
        $('<option value="' + eigenschaft + '">' + EIGENSCHAFTEN[liste][eigenschaft].beschriftung + "</option>").appendTo(
            $sortieren_definitionen.find(".sortieren_eigenschaft")
        );
    });

    $sortieren_definitionen.find(".btn_sortieren_erstellen").first().attr("data-liste", liste).attr("data-instanz", instanz);

    Liste_SortierenAktualisieren($formular, liste);
}
