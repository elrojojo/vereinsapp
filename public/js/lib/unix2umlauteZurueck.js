function unix2umlauteZurueck(unix) {
    let umlaute = unix;
    $.each(
        [
            [" ", "_"],
            [" ", "-"],
            ["ä", "ae"],
            ["ö", "oe"],
            ["ü", "ue"],
            ["Ä", "Ae"],
            ["Ö", "Oe"],
            ["Ü", "Ue"],
            ["ß", "ss"],
        ],
        function (index, konvertierung) {
            umlaute = umlaute.replaceAll(konvertierung[1], konvertierung[0]);
        }
    );
    return umlaute;
}
