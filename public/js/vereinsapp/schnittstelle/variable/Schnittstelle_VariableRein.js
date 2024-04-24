function Schnittstelle_VariableRein(wert, eigenschaft, element_id, liste) {
    if (typeof eigenschaft !== "undefined" && typeof element_id !== "undefined" && typeof liste !== "undefined") {
        element_id = Number(element_id);

        if (typeof G.LISTEN[liste].tabelle[element_id] === "undefined") G.LISTEN[liste].tabelle[element_id] = new Object();
        G.LISTEN[liste].tabelle[element_id][eigenschaft] = Schnittstelle_VariableWertBereinigtZurueck(wert);
    }
}

function Schnittstelle_VariableWertBereinigtZurueck(wert) {
    let WertBereinigt = wert;
    // Wenn aber der Wert eine Zahl ist
    if (isNumber(wert)) WertBereinigt = Number(wert);
    // Oder wenn aber der Wert ein SQL-Zeitpunkt ist
    else if (DateTime.fromSQL(wert).isValid) WertBereinigt = DateTime.fromSQL(wert);
    // Oder wenn aber der Wert ein ISO-Zeitpunkt ist
    else if (DateTime.fromISO(wert).isValid) WertBereinigt = DateTime.fromISO(wert);

    // Und wenn der Wert im JSON-Format ist
    if (isJson(WertBereinigt)) WertBereinigt = JSON.parse(WertBereinigt);

    return WertBereinigt;
}
