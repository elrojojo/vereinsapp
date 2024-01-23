function Liste_SortierenFormularSchliessen($formular) {
    const $sortieren = $formular.find(".sortieren");
    const liste = $sortieren.attr("data-liste");
    const instanz = $sortieren.attr("data-instanz");
    const eigenschaft = $sortieren.attr("data-eigenschaft");
    const sortieren_liste = $sortieren.attr("data-sortieren_liste");
    const element_id = $sortieren.attr("data-element_id");

    if (typeof eigenschaft !== "undefined")
        Schnittstelle_VariableRein(Liste_$Sortieren2SortierenZurueck($sortieren, sortieren_liste), eigenschaft, element_id, liste, "tmp");
}
