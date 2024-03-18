function Liste_ElementFormularSchliessen($formular) {
    const $btn_erfolgreich_abschliessen = $formular.find(".btn_erfolgreich_abschliessen");
    const liste = $btn_erfolgreich_abschliessen.attr("data-liste");
    const aktion = $btn_erfolgreich_abschliessen.attr("data-aktion");
    const element_id = $btn_erfolgreich_abschliessen.attr("data-element_id");

    $btn_erfolgreich_abschliessen
        .removeAttr("data-liste")
        .removeAttr("data-aktion", aktion)
        .removeClass(G.LISTEN[liste].element + "_" + aktion);
    $btn_erfolgreich_abschliessen.removeAttr("data-weiterleiten");
    $btn_erfolgreich_abschliessen.removeAttr("data-element_id");
    
    $formular.find(".eigenschaft").each(function () {
        const $eigenschaft = $(this);
        const eigenschaft = $eigenschaft.attr("data-eigenschaft");
        const wert = $eigenschaft.val();
        Schnittstelle_VariableRein(wert, eigenschaft, element_id, liste, "tmp");
    });
}
