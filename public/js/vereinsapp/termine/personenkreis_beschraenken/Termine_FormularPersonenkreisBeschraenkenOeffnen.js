function Termine_FormularPersonenkreisBeschraenkenOeffnen($formular, event, liste) {
    const $btn_oeffnend = $(event.relatedTarget);
    const element_id = $btn_oeffnend.attr("data-element_id");
    const filtern_liste = "mitglieder";

    $formular
        .find(".personenkreis_beschraenken, .personenkreis_beschraenken_definitionen")
        .attr("data-filtern_liste", filtern_liste)
        .attr("data-element_id", element_id);

    $(".personenkreis_beschraenken_definitionen").empty();
    $.each(FILTERBARE_EIGENSCHAFTEN[filtern_liste], function (index, eigenschaft) {
        const EIGENSCHAFT =
            EIGENSCHAFTEN[LISTEN[filtern_liste].controller][filtern_liste][eigenschaft];
        const typ = EIGENSCHAFT.typ;
        const beschriftung = EIGENSCHAFT.beschriftung;
        const $neue_personenkreis_beschraenken_definition =
            PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_definition[typ]
                .clone()
                .removeClass("blanko invisible")
                .addClass("personenkreis_beschraenken_definition")
                .attr("data-eigenschaft", eigenschaft);

        $neue_personenkreis_beschraenken_definition
            .find(".accordion-button")
            .attr("data-bs-target", "#personenkreis_beschraenken_" + eigenschaft)
            .text(beschriftung);
        $neue_personenkreis_beschraenken_definition
            .find(".accordion-collapse")
            .attr("id", "personenkreis_beschraenken_" + eigenschaft);

        if (typ == "vorgegebene_werte") {
            $neue_personenkreis_beschraenken_definition
                .find(".personenkreis_beschraenken_wert")
                .empty();
            $.each(VORGEGEBENE_WERTE[filtern_liste][eigenschaft], function (wert, eigenschaften) {
                $(
                    '<option value="' + wert + '">' + eigenschaften.beschriftung + "</option>"
                ).appendTo(
                    $neue_personenkreis_beschraenken_definition.find(
                        ".personenkreis_beschraenken_wert"
                    )
                );
            });
        }
        $neue_personenkreis_beschraenken_definition.appendTo(
            $formular.find(".personenkreis_beschraenken_definitionen")
        );
    });

    $(document).trigger("VAR_upd_DOM", [liste]);
}
