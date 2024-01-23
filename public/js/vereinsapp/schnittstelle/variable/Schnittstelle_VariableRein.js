function Schnittstelle_VariableRein(wert, eigenschaft, element_id, liste, ziel) {
    if (typeof ziel === "undefined") ziel = "tabelle";
    else if (ziel == "tmp" && typeof element_id === "undefined") element_id = 0;

    if (typeof eigenschaft !== "undefined" && typeof element_id !== "undefined" && typeof liste !== "undefined") {
        element_id = Number(element_id);
        if (typeof G.LISTEN[liste][ziel][element_id] === "undefined") G.LISTEN[liste][ziel][element_id] = new Object();
        G.LISTEN[liste][ziel][element_id][eigenschaft] = Schnittstelle_VariableWertBereinigtZurueck(wert);
    }
}

function Schnittstelle_VariableWertBereinigtZurueck(wert) {
    let WertBereinigt = wert;
    // Wenn aber der Wert eine Zahl ist
    if (wert && !Number.isNaN(Number(wert)) && typeof wert !== "boolean") WertBereinigt = Number(wert);
    // Oder wenn aber der Wert ein SQL-Zeitpunkt ist
    else if (DateTime.fromSQL(wert).isValid) WertBereinigt = DateTime.fromSQL(wert);
    // Oder wenn aber der Wert ein ISO-Zeitpunkt ist
    else if (DateTime.fromISO(wert).isValid) WertBereinigt = DateTime.fromISO(wert);

    // Und wenn der Wert im JSON-Format ist
    if (isJson(WertBereinigt)) WertBereinigt = JSON.parse(WertBereinigt);

    return WertBereinigt;
}
