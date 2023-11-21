function Schnittstelle_LocalstorageWertBereinigtZurueck(wert, eigenschaft, liste) {
    if (wert && !Number.isNaN(Number(wert)) && typeof wert !== "boolean") wert = Number(wert);
    if (SQL_DATETIME_REGEX.test(wert)) wert = DateTime.fromFormat(wert, SQL_DATETIME);
    if (SQL_DATE_REGEX.test(wert)) wert = DateTime.fromFormat(wert, SQL_DATE);
    if (SQL_TIME_REGEX.test(wert)) wert = DateTime.fromFormat(wert, SQL_TIME);

    return wert;
}
