function Schnittstelle_VariableRausZurueck(eigenschaft, element_id, liste, quelle) {
    if (typeof eigenschaft === "undefined") return undefined;
    // if (typeof element_id === "undefined") return undefined;
    if (typeof liste === "undefined") return undefined;
    if (typeof quelle === "undefined") quelle = "tabelle";

    let VariableRaus = undefined;
    // Wenn aber ein Element mit der Eigenschaft in der Tabelle existiert
    if (
        "tabelle" in G.LISTEN[liste] &&
        typeof G.LISTEN[liste].tabelle[Number(element_id)] !== "undefined" &&
        // "id" in G.LISTEN[liste].tabelle[Number(element_id)] &&
        eigenschaft in G.LISTEN[liste].tabelle[Number(element_id)]
    )
        VariableRaus = G.LISTEN[liste].tabelle[Number(element_id)][eigenschaft];

    if (typeof element_id === "undefined") element_id = 0;
    // Und wenn aber ein Element mit der Eigenschaft in der temporären Tabelle existiert (bevorzugt)
    if (
        "tmp" in G.LISTEN[liste] &&
        typeof G.LISTEN[liste].tmp[element_id] !== "undefined" &&
        // "id" in G.LISTEN[liste].tmp[element_id] &&
        eigenschaft in G.LISTEN[liste].tmp[element_id]
    ) {
        VariableRaus = G.LISTEN[liste].tmp[element_id][eigenschaft];
        delete G.LISTEN[liste].tmp[element_id][eigenschaft];
    }

    return VariableRaus;
}
