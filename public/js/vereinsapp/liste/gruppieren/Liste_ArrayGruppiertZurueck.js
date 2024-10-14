function Liste_ArrayGruppiertZurueck(array, gruppieren) {
    const array_gruppiert = new Object();

    if (array.length === 0 || gruppieren == "" || gruppieren == null || typeof gruppieren === "undefined") return array;
    else {
        const gruppieren_werte = new Array();
        $.each(array, function () {
            const element = this;
            const wert = element[gruppieren];

            if (!gruppieren_werte.includes(wert)) {
                gruppieren_werte.push(wert);
                array_gruppiert[wert] = new Array();
            }
            array_gruppiert[wert].push(element);
        });
    }

    return array_gruppiert;
}
