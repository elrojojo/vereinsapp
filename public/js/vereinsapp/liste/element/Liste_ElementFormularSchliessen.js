function Liste_ElementFormularSchliessen($formular, liste, aktion) {
    const $btn_element_aktion = $formular.find(".btn_" + G.LISTEN[liste].element + "_" + aktion);
    const element_id = $btn_element_aktion.attr("data-element_id");

    $formular.removeAttr("data-liste").removeAttr("data-aktion");
    $formular.find(".btn_" + G.LISTEN[liste].element + "_aktion").removeClass("btn_" + G.LISTEN[liste].element + "_" + aktion);

    $formular.find(".eigenschaft").each(function () {
        const $eigenschaft = $(this);
        const eigenschaft = $eigenschaft.attr("data-eigenschaft");
        const wert = $eigenschaft.val();
        Schnittstelle_VariableRein(wert, eigenschaft, element_id, liste, "tmp");
    });

    $btn_element_aktion.removeAttr("data-element_id");

    $formular.modal("hide");
}
