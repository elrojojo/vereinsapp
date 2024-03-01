function Liste_ElementBeschriftungZurueck(element_id, liste) {
    let beschriftung = "";

    if ("beschriftung" in G.LISTEN[liste]) {
        $.each(G.LISTEN[liste].beschriftung, function () {
            if ("prefix" in this) beschriftung += this.prefix;
            beschriftung += Liste_WertFormatiertZurueck(
                Schnittstelle_VariableRausZurueck(this.eigenschaft, element_id, liste),
                this.eigenschaft,
                liste
            );
            // die Schnittstelle_Variable-Funktion und die WertFormatiertZurueck-Funktion benuten!
            if ("suffix" in this) beschriftung += this.suffix;
        });
    } else {
        beschriftung = G.LISTEN[liste].element;
        beschriftung = beschriftung.charAt(0).toUpperCase() + beschriftung.slice(1);
        beschriftung = unix2umlauteZurueck(beschriftung);
    }

    return beschriftung;
}
