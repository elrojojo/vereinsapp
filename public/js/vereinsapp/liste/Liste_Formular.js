$(document).ready(function () {
    // FORMULAR (MODAL) ÖFFNEN
    $(".formular").on("show.bs.modal", function (event) {
        const $formular = $(this);
        const $btn_oeffnend = $(event.relatedTarget);
        const aktion = $btn_oeffnend.attr("data-aktion");

        let element = $btn_oeffnend.attr("data-element");
        let element_id = $btn_oeffnend.attr("data-element_id");
        let liste = $btn_oeffnend.attr("data-liste");
        if (typeof element === "undefined") element = $btn_oeffnend.parents(".element").first().attr("data-element");
        if (typeof element_id === "undefined") element_id = $btn_oeffnend.parents(".element").first().attr("data-element_id");
        if (typeof liste === "undefined")
            $.each(LISTEN, function (liste_each, LISTE_each) {
                if (element == LISTE_each.element) liste = liste_each;
            });
        const LISTE = LISTEN[liste];

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
                if (typeof element_id !== "undefined") val = LISTE.tabelle[element_id][eigenschaft];
                else val = EIGENSCHAFTEN[LISTE.controller][liste][eigenschaft].standard;
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
        } else if (aktion == "sortieren") {
            $formular.find(".sortieren, .sortieren_definitionen").attr("data-liste", liste);
            const $filtern_definition = $formular.find(".sortieren_definitionen");
            $filtern_definition.find(".sortieren_eigenschaft").empty();
            $.each(SORTIERBARE_EIGENSCHAFTEN[liste], function (index, eigenschaft) {
                $('<option value="' + eigenschaft + '">' + EIGENSCHAFTEN[LISTE.controller][liste][eigenschaft].beschriftung + "</option>").appendTo(
                    $filtern_definition.find(".sortieren_eigenschaft")
                );
            });

            $(document).trigger("VAR_upd_DOM", [liste]);
        } else if (aktion == "filtern") {
            $formular.find(".filtern, .filtern_definitionen").attr("data-liste", liste);

            $(".filtern_definitionen").empty();
            $.each(FILTERBARE_EIGENSCHAFTEN[liste], function (index, eigenschaft) {
                const typ = EIGENSCHAFTEN[LISTE.controller][liste][eigenschaft].typ;
                const beschriftung = EIGENSCHAFTEN[LISTE.controller][liste][eigenschaft].beschriftung;
                const $neue_filtern_definition = FILTERN.$blanko_filtern_definition[typ]
                    .clone()
                    .removeClass("blanko invisible")
                    .addClass("filtern_definition")
                    .attr("data-eigenschaft", eigenschaft);
                $neue_filtern_definition
                    .find(".accordion-button")
                    .attr("data-bs-target", "#filtern_" + eigenschaft)
                    .text(beschriftung);
                $neue_filtern_definition.find(".accordion-collapse").attr("id", "filtern_" + eigenschaft);
                if (typ == "vorgegebene_werte") {
                    $neue_filtern_definition.find(".filtern_wert").empty();
                    $.each(VORGEGEBENE_WERTE[liste][eigenschaft], function (wert, eigenschaften) {
                        $('<option value="' + wert + '">' + eigenschaften.beschriftung + "</option>").appendTo(
                            $neue_filtern_definition.find(".filtern_wert")
                        );
                    });
                }
                $neue_filtern_definition.appendTo($formular.find(".filtern_definitionen"));
            });

            $(document).trigger("VAR_upd_DOM", [liste]);
        }

        const $btns = $formular.find('[class^="btn_"]');
        if (typeof element !== "undefined") $btns.attr("data-element", element);
        else $btns.removeAttr("data-element");
        if (typeof aktion !== "undefined") $btns.attr("data-aktion", aktion);
        else $btns.removeAttr("data-aktion");
        if (typeof element_id !== "undefined" && aktion != "duplizieren") $btns.attr("data-element_id", element_id);
        else $btns.removeAttr("data-element_id");
    });
});
