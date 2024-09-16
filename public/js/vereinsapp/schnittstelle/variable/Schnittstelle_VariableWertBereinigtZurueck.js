function Schnittstelle_VariableWertBereinigtZurueck(wert) {
    let wert_bereinigt = wert;
    // Wenn aber der Wert eine Zahl ist
    if (isNumber(wert)) wert_bereinigt = Number(wert);
    // Oder wenn aber der Wert ein SQL-Zeitpunkt ist
    else if (DateTime.fromSQL(wert).isValid) wert_bereinigt = DateTime.fromSQL(wert);
    // Oder wenn aber der Wert ein ISO-Zeitpunkt ist
    else if (DateTime.fromISO(wert).isValid) wert_bereinigt = DateTime.fromISO(wert);

    // Und wenn der Wert im JSON-Format ist
    if (isJson(wert_bereinigt)) wert_bereinigt = JSON.parse(wert_bereinigt);

    return wert_bereinigt;
}
