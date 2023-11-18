function Liste_ElementFormularOeffnen($formular, $btn_oeffnend, liste) {
    const aktion = $btn_oeffnend.attr("data-aktion");
    let element = $btn_oeffnend.attr("data-element");
    let element_id = $btn_oeffnend.attr("data-element_id");
    if (typeof element === "undefined") element = $btn_oeffnend.parents(".element").first().attr("data-element");
    if (typeof element_id === "undefined") element_id = $btn_oeffnend.parents(".element").first().attr("data-element_id");
    if (typeof liste === "undefined")
        $.each(G.LISTEN, function (liste_each, LISTE_each) {
            if (element == LISTE_each.element) liste = liste_each;
        });

    let titel_beschriftung;
    if (typeof element !== "undefined") titel_beschriftung = element;
    else titel_beschriftung = liste;
    $formular.find(".modal-title").text(bezeichnung_kapitalisieren(unix2umlaute(titel_beschriftung)) + " " + unix2umlaute(aktion));
    $formular.find(".is-invalid").removeClass("is-invalid");
    $formular.find(".is-valid").removeClass("is-valid");

    if (aktion == "erstellen" || aktion == "duplizieren" || aktion == "aendern") {
        $formular.find(".eigenschaft").each(function () {
            const $eigenschaft = $(this);
            const eigenschaft = $eigenschaft.attr("data-eigenschaft");

            let val;
            if (typeof element_id !== "undefined") val = G.LISTEN[liste].tabelle[element_id][eigenschaft];
            else val = EIGENSCHAFTEN[G.LISTEN[liste].controller][liste][eigenschaft].standard;

            if ($eigenschaft.attr("type") == "date") {
                if (typeof val !== "object") val = DateTime.fromFormat(val, SQL_DATETIME);
                val = val.toISODate();
            } else if ($eigenschaft.attr("type") == "time") {
                if (typeof val !== "object") val = DateTime.fromFormat(val, SQL_DATETIME);
                val = val.toISOTime({
                    includeOffset: false,
                    suppressSeconds: true,
                    suppressMilliseconds: true,
                });
            }

            $eigenschaft.val(val).change();
        });
    } else if (aktion == "loeschen") {
        $formular.find(".beschriftung").html(
            $('.element[data-element="' + element + '"][data-element_id="' + element_id + '"]')
                .find(".beschriftung")
                .html()
        ); // Für element_loeschen (modal)
    }

    const $btns = $formular.find('[class^="btn_"]');

    if (typeof element !== "undefined") $btns.attr("data-element", element);
    else $btns.removeAttr("data-element");

    if (typeof aktion !== "undefined") $btns.attr("data-aktion", aktion);
    else $btns.removeAttr("data-aktion");

    if (typeof element_id !== "undefined" && aktion != "duplizieren") $btns.attr("data-element_id", element_id);
    else $btns.removeAttr("data-element_id");
}
