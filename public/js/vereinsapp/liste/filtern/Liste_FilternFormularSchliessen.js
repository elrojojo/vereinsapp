function Liste_FilternFormularSchliessen($formular) {
    const $filtern = $formular.find(".filtern");
    const liste = $filtern.attr("data-liste");
    const instanz = $filtern.attr("data-instanz");
    const eigenschaft = $filtern.attr("data-eigenschaft");
    const filtern_liste = $filtern.attr("data-filtern_liste");
    const element_id = $filtern.attr("data-element_id");

    if (typeof eigenschaft !== "undefined")
        Schnittstelle_VariableRein(Liste_$Filtern2FilternZurueck($filtern, filtern_liste), eigenschaft, element_id, liste, "tmp");
}
