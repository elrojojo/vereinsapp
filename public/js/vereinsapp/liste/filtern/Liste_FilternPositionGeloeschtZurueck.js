function Liste_FilternPositionGeloeschtZurueck(filtern, position, position_uebrig) {
    if (typeof position === "undefined" || !Array.isArray(position)) position = new Array();
    if (typeof position_uebrig === "undefined" || !Array.isArray(position_uebrig)) {
        position_uebrig = position;
        position_uebrig.reverse();
    }

    const position_ebene = position_uebrig.pop();
    if ("verknuepfung" in filtern[position_ebene]) {
        filtern[position_ebene].filtern = Liste_FilternPositionGeloeschtZurueck(filtern[position_ebene].filtern, position, position_uebrig);
        if (filtern[position_ebene].filtern.length == 0) filtern.splice(position_ebene, 1);
    } else {
        if (typeof position_uebrig !== "undefined" && Array.isArray(position_uebrig) && position_uebrig.length == 0)
            filtern.splice(position_ebene, 1);
    }

    return filtern;
}
