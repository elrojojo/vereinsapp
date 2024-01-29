function Liste_ArraySortiertZurueck(array, sortieren) {
    // https://bithacker.dev/javascript-object-multi-property-sort
    if (array.length == 0 || sortieren.length == 0) return array;
    else
        return array.sort(function (a, b) {
            let i = 0,
                result = 0;
            while (i < sortieren.length && result === 0) {
                let richtung = 1;
                if (sortieren[i].richtung == SORT_ASC) richtung = 1;
                else if (sortieren[i].richtung == SORT_DESC) richtung = -1;

                a_formatiert = a[sortieren[i].eigenschaft];
                b_formatiert = b[sortieren[i].eigenschaft];
                // Wenn aber a und b vom Typ String sind
                if (typeof a_formatiert === "string" && typeof b_formatiert === "string") {
                    a_formatiert = umlaute2unix(a_formatiert.toString());
                    b_formatiert = umlaute2unix(b_formatiert.toString());
                }

                result = richtung * (a_formatiert < b_formatiert ? -1 : a_formatiert > b_formatiert ? 1 : 0);
                i++;
            }
            return result;
        });
}
