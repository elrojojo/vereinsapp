function Schnittstelle_DomWertBereinigtZurueck(wert) {
    // if (EIGENSCHAFTEN[G.LISTEN[liste].controller][liste][eigenschaft].typ == "zeitpunkt")
    wert = wert.toFormat(SQL_DATETIME);

    return wert;
}
