function umlaute2unixZurueck(umlaute) {
    let unix = umlaute;
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
            unix = unix.replaceAll(konvertierung[0], konvertierung[1]);
        }
    );

    return unix;
}
