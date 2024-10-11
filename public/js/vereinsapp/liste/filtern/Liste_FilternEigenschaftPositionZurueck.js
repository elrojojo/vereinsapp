function Liste_FilternEigenschaftPositionZurueck(filtern, eigenschaft, position) {
    if (typeof position === "undefined" || !Array.isArray(position)) position = new Array();
    if (position.length === 0) position.push(0);

    $.each(filtern, function (pos, knoten) {
        if ("verknuepfung" in knoten) {
            position = Liste_FilternEigenschaftPositionZurueck(knoten.filtern, eigenschaft, position);
        } else {
            if (eigenschaft == knoten.eigenschaft) {
                position.push(pos);
            }
        }
    });

    return position;
}
