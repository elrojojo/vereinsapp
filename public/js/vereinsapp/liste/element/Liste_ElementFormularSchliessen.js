function Liste_ElementFormularSchliessen($formular) {
    const $btn_schliessend = $formular.find('[class^="btn_"]');
    const liste = $btn_schliessend.attr("data-liste");

    let element_id = $btn_schliessend.attr("data-element_id");
    // Wenn aber nichts definiert ist
    if (typeof element_id === "undefined") element_id = 0;

    $formular.find(".eigenschaft").each(function () {
        const $eigenschaft = $(this);
        const eigenschaft = $eigenschaft.attr("data-eigenschaft");
        const wert = $eigenschaft.val();
        Schnittstelle_VariableRein(wert, eigenschaft, element_id, liste, "tmp");
    });
}
