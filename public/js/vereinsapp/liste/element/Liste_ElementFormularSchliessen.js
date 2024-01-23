function Liste_ElementFormularSchliessen($formular) {
    const $btn_schliessend = $formular.find('[class^="btn_"]');
    const liste = $btn_schliessend.attr("data-liste");
    const element_id = $btn_schliessend.attr("data-element_id");

    $formular.find(".eigenschaft").each(function () {
        const $eigenschaft = $(this);
        const eigenschaft = $eigenschaft.attr("data-eigenschaft");
        const wert = $eigenschaft.val();
        Schnittstelle_VariableRein(wert, eigenschaft, element_id, liste, "tmp");
    });
}
