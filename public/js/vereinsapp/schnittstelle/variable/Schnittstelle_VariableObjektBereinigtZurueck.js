function Schnittstelle_VariableObjektBereinigtZurueck(objekt) {
    const objekt_bereinigt = new Object();

    $.each(objekt, function (eigenschaft, wert) {
        if (!isJquery(wert) && isObject(wert)) objekt_bereinigt[eigenschaft] = Schnittstelle_VariableObjektBereinigtZurueck(wert);
        else if (isArray(wert)) objekt_bereinigt[eigenschaft] = Schnittstelle_VariableArrayBereinigtZurueck(wert);
        else objekt_bereinigt[eigenschaft] = Schnittstelle_VariableWertBereinigtZurueck(wert);
    });

    return objekt_bereinigt;
}
