function Liste_ElementBeschriftungHtmlZurueck(liste) {
    let beschriftung_html = "";

    if ("element_beschriftung" in ELEMENTE[LISTEN[liste].element] && ELEMENTE[LISTEN[liste].element].element_beschriftung.length > 0) {
        $.each(ELEMENTE[LISTEN[liste].element].element_beschriftung, function () {
            if ("prefix" in this) beschriftung_html += this.prefix;
            if ("eigenschaft" in this) beschriftung_html += '<span class="eigenschaft" data-eigenschaft="' + this.eigenschaft + '"></span>';
            if ("suffix" in this) beschriftung_html += this.suffix;
        });
    } else beschriftung_html = ELEMENTE[LISTEN[liste].element].beschriftung;

    return beschriftung_html;
}
