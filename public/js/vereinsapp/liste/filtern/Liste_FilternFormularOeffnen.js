function Liste_FilternFormularOeffnen(data, liste) {
    if (typeof data === "undefined") data = new Object();

    if (!("instanz" in data)) data.instanz = undefined;
    const instanz = data.instanz;

    if (!("title" in data)) data.title = undefined;
    const title = data.title;

    const $neues_filtern_formular = FILTERN.$blanko_filtern_modal.clone().removeClass("invisible");
    if (typeof title !== "undefined") $neues_filtern_formular.find(".modal-title").text(title);

    const $filtern_definitionen = $neues_filtern_formular.find(".filtern_definitionen");
    $filtern_definitionen.empty();
    $.each(FILTERBARE_EIGENSCHAFTEN[liste], function (index, eigenschaft) {
        const typ = EIGENSCHAFTEN[liste][eigenschaft].typ;
        const beschriftung = EIGENSCHAFTEN[liste][eigenschaft].beschriftung;

        const $neue_filtern_definition = FILTERN.$blanko_filtern_definition[typ]
            .clone()
            .removeClass("blanko invisible")
            .addClass("filtern_definition")
            .attr("data-eigenschaft", eigenschaft);

        $neue_filtern_definition.find(".beschriftung").text(beschriftung);

        if (typ == "vorgegebene_werte") {
            $neue_filtern_definition.find(".filtern_wert").empty();
            $.each(VORGEGEBENE_WERTE[liste][eigenschaft], function (wert, eigenschaften) {
                $('<option value="' + wert + '">' + eigenschaften.beschriftung + "</option>").appendTo(
                    $neue_filtern_definition.find(".filtern_wert")
                );
            });
        }

        $neue_filtern_definition.find(".btn_filtern_erstellen").first().attr("data-liste", liste);

        $neue_filtern_definition.appendTo($filtern_definitionen);
    });

    $neues_filtern_formular.find(".btn_filtern_speichern").attr("data-liste", liste);
    const filtern_value = Schnittstelle_DomLetztesModalZurueck()
        .find(".btn_filtern_formular_oeffnen[data-liste='" + liste + "']")
        .val();
    if (typeof instanz !== "undefined") {
        $neues_filtern_formular.find(".filtern").append(Liste_Filtern2$FilternZurueck(G.LISTEN[liste].instanz[instanz].filtern, liste));
        $neues_filtern_formular.find(".btn_filtern_speichern").attr("data-instanz", instanz);
    } else if (isJson(filtern_value))
        $neues_filtern_formular
            .find(".filtern")
            .append(Liste_Filtern2$FilternZurueck(Schnittstelle_VariableArrayBereinigtZurueck(JSON.parse(filtern_value)), liste));

    Schnittstelle_DomModalOeffnen($neues_filtern_formular);
}
