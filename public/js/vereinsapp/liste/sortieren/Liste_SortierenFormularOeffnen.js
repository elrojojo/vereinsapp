function Liste_SortierenFormularOeffnen($formular, $btn_oeffnend, liste) {
    let titel_beschriftung;
    if (typeof element !== "undefined") titel_beschriftung = element;
    else titel_beschriftung = liste;
    $formular
        .find(".modal-title")
        .text(bezeichnung_kapitalisieren(unix2umlaute(titel_beschriftung)) + " " + unix2umlaute($btn_oeffnend.attr("data-aktion")));

    $formular.find(".sortieren, .sortieren_definitionen").attr("data-liste", liste);
    const $sortieren_definitionen = $formular.find(".sortieren_definitionen");
    $sortieren_definitionen.find(".sortieren_eigenschaft").empty();
    $.each(SORTIERBARE_EIGENSCHAFTEN[liste], function (index, eigenschaft) {
        $('<option value="' + eigenschaft + '">' + EIGENSCHAFTEN[LISTEN[liste].controller][liste][eigenschaft].beschriftung + "</option>").appendTo(
            $sortieren_definitionen.find(".sortieren_eigenschaft")
        );
    });

    $(document).trigger("VAR_upd_DOM", [liste]);
}
