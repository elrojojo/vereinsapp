function Schnittstelle_VariableArrayBereinigtZurueck(array) {
    const array_bereinigt = new Array();

    $.each(array, function (index, element) {
        if (!isJquery(element) && isObject(element)) array_bereinigt[index] = Schnittstelle_VariableObjektBereinigtZurueck(element);
        else if (isArray(element)) array_bereinigt[index] = Schnittstelle_VariableArrayBereinigtZurueck(element);
        else array_bereinigt[index] = Schnittstelle_VariableWertBereinigtZurueck(element);
    });

    return array_bereinigt;
}
