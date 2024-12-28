function objektKopiertZurueck(objekt) {
    const objekt_kopiert = new Object();

    $.each(objekt, function (eigenschaft, wert) {
        if (!isJquery(wert) && isObject(wert)) objekt_kopiert[eigenschaft] = objektKopiertZurueck(wert);
        else if (isArray(wert)) objekt_kopiert[eigenschaft] = arrayKopiertZurueck(wert);
        else objekt_kopiert[eigenschaft] = wert;
    });

    return objekt_kopiert;
}
