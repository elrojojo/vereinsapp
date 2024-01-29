function Liste_FilternFormularOeffnen($formular, $btn_oeffnend) {
    const liste = $btn_oeffnend.attr("data-liste");
    const instanz = $btn_oeffnend.attr("data-instanz");
    const eigenschaft = $btn_oeffnend.attr("data-eigenschaft");
    let filtern_liste = $btn_oeffnend.attr("data-filtern_liste");
    const element_id = $btn_oeffnend.attr("data-element_id");

    $formular.find(".filtern, .filtern_definitionen").attr("data-liste", liste);
    if (typeof instanz !== "undefined") $formular.find(".filtern, .filtern_definitionen").attr("data-instanz", instanz);
    else $formular.find(".filtern, .filtern_definitionen").removeAttr("data-instanz");
    if (typeof eigenschaft !== "undefined") $formular.find(".filtern, .filtern_definitionen").attr("data-eigenschaft", eigenschaft);
    else $formular.find(".filtern, .filtern_definitionen").removeAttr("data-eigenschaft");
    if (typeof filtern_liste !== "undefined") $formular.find(".filtern, .filtern_definitionen").attr("data-filtern_liste", filtern_liste);
    else {
        $formular.find(".filtern, .filtern_definitionen").removeAttr("data-filtern_liste");
        filtern_liste = liste;
    }
    if (typeof element_id !== "undefined") $formular.find(".filtern, .filtern_definitionen").attr("data-element_id", element_id);
    else $formular.find(".filtern, .filtern_definitionen").removeAttr("data-element_id");

    $(".filtern_definitionen").empty();
    $.each(FILTERBARE_EIGENSCHAFTEN[filtern_liste], function (index, eigenschaft_) {
        const typ = EIGENSCHAFTEN[filtern_liste][eigenschaft_].typ;
        const beschriftung = EIGENSCHAFTEN[filtern_liste][eigenschaft_].beschriftung;

        const $neue_filtern_definition = FILTERN.$blanko_filtern_definition[typ]
            .clone()
            .removeClass("blanko invisible")
            .addClass("filtern_definition")
            .attr("data-eigenschaft", eigenschaft_);

        $neue_filtern_definition
            .find(".accordion-button")
            .attr("data-bs-target", "#filtern_" + eigenschaft_)
            .text(beschriftung);

        $neue_filtern_definition.find(".accordion-collapse").attr("id", "filtern_" + eigenschaft_);

        if (typ == "vorgegebene_werte") {
            $neue_filtern_definition.find(".filtern_wert").empty();
            $.each(VORGEGEBENE_WERTE[filtern_liste][eigenschaft_], function (wert, eigenschaften) {
                $('<option value="' + wert + '">' + eigenschaften.beschriftung + "</option>").appendTo(
                    $neue_filtern_definition.find(".filtern_wert")
                );
            });
        }

        $neue_filtern_definition.find(".btn_filtern_erstellen").first().attr("data-liste", liste);
        if (typeof instanz !== "undefined") $neue_filtern_definition.find(".btn_filtern_erstellen").first().attr("data-instanz", instanz);
        if (typeof eigenschaft !== "undefined") $neue_filtern_definition.find(".btn_filtern_erstellen").first().attr("data-eigenschaft", eigenschaft);
        if (typeof filtern_liste !== "undefined")
            $neue_filtern_definition.find(".btn_filtern_erstellen").first().attr("data-filtern_liste", filtern_liste);
        if (typeof element_id !== "undefined") $neue_filtern_definition.find(".btn_filtern_erstellen").first().attr("data-element_id", element_id);

        $neue_filtern_definition.appendTo($formular.find(".filtern_definitionen"));
    });

    Liste_FilternAktualisieren($formular, liste);
}
