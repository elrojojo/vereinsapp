function Schnittstelle_VariableArrayBereinigtZurueck(array) {
    let array_bereinigt = new Array();

    $.each(array, function (index, element) {
        if (isObject(element)) array_bereinigt[index] = Schnittstelle_VariableObjektBereinigtZurueck(element);
        else if (Array.isArray(element)) array_bereinigt[index] = Schnittstelle_VariableArrayBereinigtZurueck(element);
        else array_bereinigt[index] = Schnittstelle_VariableWertBereinigtZurueck(element);
    });

    console.log("Array:", array, array_bereinigt);
    return array_bereinigt;
}
