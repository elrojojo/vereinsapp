function umlaute2unixZurueck(umlaute) {
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
            unix = umlaute.replaceAll(konvertierung[0], konvertierung[1]);
        }
    );

    return unix;
}
