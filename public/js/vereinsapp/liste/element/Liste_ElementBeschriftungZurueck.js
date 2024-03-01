function Liste_ElementBeschriftungZurueck(element_id, liste) {
    let beschriftung = G.LISTEN[liste].element;
    beschriftung = beschriftung.charAt(0).toUpperCase() + beschriftung.slice(1);
    beschriftung = unix2umlauteZurueck(beschriftung);

    if ("beschriftung" in G.LISTEN[liste]) {
        beschriftung += " ";
        $.each(G.LISTEN[liste].beschriftung, function () {
            if ("prefix" in this) beschriftung += this.prefix;
            beschriftung += G.LISTEN[liste].tabelle[element_id][this.eigenschaft];
            // die Schnittstelle_Variable-Funktion und die WertFormatiertZurueck-Funktion benuten!
            if ("suffix" in this) beschriftung += this.suffix;
        });
    }

    return beschriftung;
}
