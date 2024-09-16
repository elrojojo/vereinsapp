function Schnittstelle_VariableRausZurueck(eigenschaft, element_id, liste) {
    if (typeof eigenschaft === "undefined") return undefined;
    if (typeof element_id === "undefined") return undefined;
    if (typeof liste === "undefined") return undefined;

    let VariableRaus = undefined;
    // Wenn aber ein Element mit der Eigenschaft in der Tabelle existiert
    if (
        "tabelle" in LISTEN[liste] &&
        typeof LISTEN[liste].tabelle[Number(element_id)] !== "undefined" &&
        // "id" in LISTEN[liste].tabelle[Number(element_id)] &&
        eigenschaft in LISTEN[liste].tabelle[Number(element_id)]
    )
        VariableRaus = LISTEN[liste].tabelle[Number(element_id)][eigenschaft];

    return VariableRaus;
}
