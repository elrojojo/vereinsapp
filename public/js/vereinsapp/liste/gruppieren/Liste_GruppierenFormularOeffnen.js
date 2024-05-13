function Liste_GruppierenFormularOeffnen(data, liste) {
    if (typeof data === "undefined") data = new Object();

    if (!("instanz" in data)) data.instanz = undefined;
    const instanz = data.instanz;

    if (!("title" in data)) data.title = undefined;
    const title = data.title;

    const gruppieren_value = Schnittstelle_DomLetztesModalZurueck()
        .find(".btn_gruppieren_formular_oeffnen[data-liste='" + liste + "']")
        .val();

    let gruppieren_aktuell = undefined;
    if (typeof instanz !== "undefined") {
        gruppieren_aktuell = LISTEN[liste].instanz[instanz].gruppieren;
        if (typeof gruppieren_aktuell === "undefined") gruppieren_aktuell = LISTEN[liste].instanz[instanz].gruppieren_data;
    } else if (typeof gruppieren_value !== "undefined") gruppieren_aktuell = gruppieren_value;

    const $neues_gruppieren_formular = GRUPPIEREN.$blanko_gruppieren_modal.clone().removeClass("invisible");
    if (typeof title !== "undefined") $neues_gruppieren_formular.find(".modal-title").text(title);

    const $gruppieren_definitionen = $neues_gruppieren_formular.find(".gruppieren_definitionen");
    $gruppieren_definitionen.attr("data-liste", liste).attr("data-instanz", instanz);

    const $gruppieren_eigenschaft = $gruppieren_definitionen.find(".gruppieren_eigenschaft");

    $.each(GRUPPIERBARE_EIGENSCHAFTEN[liste], function (index, eigenschaft) {
        $('<option value="' + eigenschaft + '">' + EIGENSCHAFTEN[liste][eigenschaft].beschriftung + "</option>").appendTo($gruppieren_eigenschaft);
    });

    if (typeof instanz !== "undefined") $gruppieren_eigenschaft.val(gruppieren_aktuell);
    else if (typeof gruppieren_value !== "undefined") $gruppieren_eigenschaft.val(Schnittstelle_VariableWertBereinigtZurueck(gruppieren_value));

    Schnittstelle_DomModalOeffnen($neues_gruppieren_formular);
}
