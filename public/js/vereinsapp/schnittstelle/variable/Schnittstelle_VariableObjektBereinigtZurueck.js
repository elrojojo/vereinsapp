function Schnittstelle_VariableObjektBereinigtZurueck(objekt) {
    let objekt_bereinigt = new Object();

    $.each(objekt, function (eigenschaft, wert) {
        if (isObject(wert)) objekt_bereinigt[eigenschaft] = Schnittstelle_VariableObjektBereinigtZurueck(wert);
        else if (Array.isArray(wert)) objekt_bereinigt[eigenschaft] = Schnittstelle_VariableArrayBereinigtZurueck(wert);
        else objekt_bereinigt[eigenschaft] = Schnittstelle_VariableWertBereinigtZurueck(wert);
    });

    console.log("Objekt:", objekt, objekt_bereinigt);
    return objekt_bereinigt;
}
