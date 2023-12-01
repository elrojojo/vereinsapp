function Schnittstelle_LocalstorageWertBereinigtZurueck(wert) {
    if (wert && !Number.isNaN(Number(wert)) && typeof wert !== "boolean") wert = Number(wert);
    if (SQL_DATETIME_REGEX.test(wert)) wert = wert.toFormat(SQL_DATETIME);
    if (SQL_DATE_REGEX.test(wert)) wert = wert.toFormat(SQL_DATE);
    if (SQL_TIME_REGEX.test(wert)) wert = wert.toFormat(SQL_TIME);

    return wert;
}
