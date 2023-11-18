function Liste_FilternFormularOeffnen($formular, $btn_oeffnend, liste) {
    let titel_beschriftung;
    if (typeof element !== "undefined") titel_beschriftung = element;
    else titel_beschriftung = liste;
    $formular
        .find(".modal-title")
        .text(bezeichnung_kapitalisieren(unix2umlaute(titel_beschriftung)) + " " + unix2umlaute($btn_oeffnend.attr("data-aktion")));

    $formular.find(".filtern, .filtern_definitionen").attr("data-liste", liste);
    $(".filtern_definitionen").empty();
    $.each(FILTERBARE_EIGENSCHAFTEN[liste], function (index, eigenschaft) {
        const EIGENSCHAFT = EIGENSCHAFTEN[G.LISTEN[liste].controller][liste][eigenschaft];
        const typ = EIGENSCHAFT.typ;
        const beschriftung = EIGENSCHAFT.beschriftung;

        const $neue_filtern_definition = FILTERN.$blanko_filtern_definition[typ]
            .clone()
            .removeClass("blanko invisible")
            .addClass("filtern_definition")
            .attr("data-eigenschaft", eigenschaft);

        $neue_filtern_definition
            .find(".accordion-button")
            .attr("data-bs-target", "#filtern_" + eigenschaft)
            .text(beschriftung);

        $neue_filtern_definition.find(".accordion-collapse").attr("id", "filtern_" + eigenschaft);

        if (typ == "vorgegebene_werte") {
            $neue_filtern_definition.find(".filtern_wert").empty();
            $.each(VORGEGEBENE_WERTE[liste][eigenschaft], function (wert, eigenschaften) {
                $('<option value="' + wert + '">' + eigenschaften.beschriftung + "</option>").appendTo(
                    $neue_filtern_definition.find(".filtern_wert")
                );
            });
        }

        $neue_filtern_definition.appendTo($formular.find(".filtern_definitionen"));
    });

    $(document).trigger("VAR_upd_DOM", [liste]);
}
