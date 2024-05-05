function Schnittstelle_VariableRein(wert, eigenschaft, element_id, liste) {
    if (typeof eigenschaft !== "undefined" && typeof element_id !== "undefined" && typeof liste !== "undefined") {
        element_id = Number(element_id);

        if (typeof G.LISTEN[liste].tabelle[element_id] === "undefined") G.LISTEN[liste].tabelle[element_id] = new Object();
        G.LISTEN[liste].tabelle[element_id][eigenschaft] = Schnittstelle_VariableWertBereinigtZurueck(wert);
    }
}
