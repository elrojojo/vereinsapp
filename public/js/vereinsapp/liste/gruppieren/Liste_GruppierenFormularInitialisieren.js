function Liste_GruppierenFormularInitialisieren($formular, instanz, liste) {
    const $gruppieren_definitionen = $formular.find(".gruppieren_definitionen");
    $gruppieren_definitionen.attr("data-liste", liste).attr("data-instanz", instanz);

    const $gruppieren_eigenschaft = $gruppieren_definitionen.find(".gruppieren_eigenschaft");

    $.each(GRUPPIERBARE_EIGENSCHAFTEN[liste], function (index, eigenschaft) {
        $('<option value="' + eigenschaft + '">' + EIGENSCHAFTEN[liste][eigenschaft].beschriftung + "</option>").appendTo($gruppieren_eigenschaft);
    });

    const gruppieren_value = Schnittstelle_DomLetztesModalZurueck()
        .find(".btn_gruppieren_modal_oeffnen[data-liste='" + liste + "']")
        .val();

    let gruppieren_aktuell = undefined;
    if (typeof instanz !== "undefined") {
        gruppieren_aktuell = LISTEN[liste].instanz[instanz].gruppieren;
        if (typeof gruppieren_aktuell === "undefined") gruppieren_aktuell = LISTEN[liste].instanz[instanz].gruppieren_data;
    } else if (typeof gruppieren_value !== "undefined") gruppieren_aktuell = gruppieren_value;

    if (typeof gruppieren_value !== "undefined") $gruppieren_eigenschaft.val(Schnittstelle_VariableWertBereinigtZurueck(gruppieren_value));
    else $gruppieren_eigenschaft.val(gruppieren_aktuell);
}
