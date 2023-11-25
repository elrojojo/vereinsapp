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
                result =
                    richtung *
                    (umlaute2unix(a[sortieren[i].eigenschaft].toString()) < umlaute2unix(b[sortieren[i].eigenschaft].toString())
                        ? -1
                        : umlaute2unix(a[sortieren[i].eigenschaft].toString()) > umlaute2unix(b[sortieren[i].eigenschaft].toString())
                        ? 1
                        : 0);
                i++;
            }
            return result;
        });
}
