function Schnittstelle_LocalstorageWertBereinigtZurueck(wert) {
    if (isLuxonDateTime(wert)) wert = wert.toFormat(SQL_DATETIME);
    else if (wert && !Number.isNaN(Number(wert)) && typeof wert !== "boolean") wert = Number(wert);

    return wert;
}
