function Liste_ElementBeschriftungZurueck(element_id, liste) {
    let beschriftung = "";

    if ("element_beschriftung" in ELEMENTE[LISTEN[liste].element] && ELEMENTE[LISTEN[liste].element].element_beschriftung.length > 0) {
        $.each(ELEMENTE[LISTEN[liste].element].element_beschriftung, function () {
            if ("prefix" in this) beschriftung += this.prefix;
            beschriftung += Liste_WertFormatiertZurueck(
                Schnittstelle_VariableRausZurueck(this.eigenschaft, element_id, liste),
                this.eigenschaft,
                liste
            );
            // die Schnittstelle_Variable-Funktion und die WertFormatiertZurueck-Funktion benuten!
            if ("suffix" in this) beschriftung += this.suffix;
        });
    } else beschriftung = ELEMENTE[LISTEN[liste].element].beschriftung;

    return beschriftung;
}
