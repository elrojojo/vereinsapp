function Liste_FilternFormularOeffnen(instanz, liste, data) {
    if (typeof data === "undefined") data = new Object();

    // if (!("eigenschaft" in data)) data.eigenschaft = undefined;
    // const eigenschaft = data.eigenschaft;

    // if (!("element_id" in data)) data.element_id = undefined;
    // const element_id = data.element_id;

    if (!("title" in data)) data.title = undefined;
    const title = data.title;

    const $neues_filtern_formular = FILTERN.$blanko_filtern_modal.clone().removeClass("invisible");

    $neues_filtern_formular.find(".filtern, .filtern_definitionen").attr("data-liste", liste);
    // if (typeof instanz !== "undefined")
    $neues_filtern_formular.find(".filtern, .filtern_definitionen").attr("data-instanz", instanz);
    // else $neues_filtern_formular.find(".filtern, .filtern_definitionen").removeAttr("data-instanz");
    // if (typeof eigenschaft !== "undefined") $neues_filtern_formular.find(".filtern, .filtern_definitionen").attr("data-eigenschaft", eigenschaft);
    // else $neues_filtern_formular.find(".filtern, .filtern_definitionen").removeAttr("data-eigenschaft");
    // if (typeof element_id !== "undefined") $neues_filtern_formular.find(".filtern, .filtern_definitionen").attr("data-element_id", element_id);
    // else $neues_filtern_formular.find(".filtern, .filtern_definitionen").removeAttr("data-element_id");

    const $filtern_definitionen = $neues_filtern_formular.find(".filtern_definitionen");

    $filtern_definitionen.empty();
    $.each(FILTERBARE_EIGENSCHAFTEN[liste], function (index, eigenschaft_) {
        const typ = EIGENSCHAFTEN[liste][eigenschaft_].typ;
        const beschriftung = EIGENSCHAFTEN[liste][eigenschaft_].beschriftung;

        const $neue_filtern_definition = FILTERN.$blanko_filtern_definition[typ]
            .clone()
            .removeClass("blanko invisible")
            .addClass("filtern_definition")
            .attr("data-eigenschaft", eigenschaft_);

        $neue_filtern_definition.find(".beschriftung").text(beschriftung);

        if (typ == "vorgegebene_werte") {
            $neue_filtern_definition.find(".filtern_wert").empty();
            $.each(VORGEGEBENE_WERTE[liste][eigenschaft_], function (wert, eigenschaften) {
                $('<option value="' + wert + '">' + eigenschaften.beschriftung + "</option>").appendTo(
                    $neue_filtern_definition.find(".filtern_wert")
                );
            });
        }

        $neue_filtern_definition.find(".btn_filtern_erstellen").first().attr("data-liste", liste);
        if (typeof instanz !== "undefined") $neue_filtern_definition.find(".btn_filtern_erstellen").first().attr("data-instanz", instanz);
        // if (typeof eigenschaft !== "undefined") $neue_filtern_definition.find(".btn_filtern_erstellen").first().attr("data-eigenschaft", eigenschaft);
        // if (typeof element_id !== "undefined") $neue_filtern_definition.find(".btn_filtern_erstellen").first().attr("data-element_id", element_id);

        $neue_filtern_definition.appendTo($filtern_definitionen);
    });

    Liste_FilternAktualisieren($neues_filtern_formular, liste);

    if (typeof title !== "undefined") $neues_filtern_formular.find(".modal-title").text(title);

    Schnittstelle_DomModalOeffnen($neues_filtern_formular);
}
