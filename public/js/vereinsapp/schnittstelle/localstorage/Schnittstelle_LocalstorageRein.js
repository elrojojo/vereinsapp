function Schnittstelle_LocalstorageRein(schluessel, wert) {
    let string = wert;
    if (!isLuxonDateTime(wert) && (isObject(wert) || isArray(wert))) string = JSON.stringify(wert);
    localStorage.setItem("vereinsapp_" + schluessel, string);
}
