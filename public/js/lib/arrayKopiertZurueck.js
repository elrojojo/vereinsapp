function arrayKopiertZurueck(array) {
    const array_kopiert = new Array();

    $.each(array, function (index, element) {
        if (isObject(element)) array_kopiert[index] = objektKopiertZurueck(element);
        else if (isArray(element)) array_kopiert[index] = arrayKopiertZurueck(element);
        else array_kopiert[index] = element;
    });

    return array_kopiert;
}
