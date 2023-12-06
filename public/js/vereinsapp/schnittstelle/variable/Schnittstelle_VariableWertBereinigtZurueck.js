function Schnittstelle_VariableWertBereinigtZurueck(wert) {
    if (SQL_DATETIME_REGEX.test(wert)) wert = DateTime.fromFormat(wert, SQL_DATETIME);
    else if (SQL_DATE_REGEX.test(wert)) wert = DateTime.fromFormat(wert, SQL_DATE);
    else if (SQL_TIME_REGEX.test(wert)) wert = DateTime.fromFormat(wert, SQL_TIME);
    else if (wert && !Number.isNaN(Number(wert)) && typeof wert !== "boolean") wert = Number(wert);

    return wert;
}
