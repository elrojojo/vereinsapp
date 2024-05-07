function Liste_ChecklisteInit() {
    // CHECKLISTE ÄNDERN
    $(document).on("change", ".check", function () {
        Liste_CheckAendern($(this));
    });

    // ALLE CHECKS ANWÄHLEN
    $(document).on("click", ".btn_alle_checks_anwaehlen", function () {
        const instanz = $(this).attr("data-instanz");
        $(".checkliste[id='" + instanz + "']")
            .find(".check:not(:checked)")
            .trigger("click");
    });

    // ALLE CHECKS ABWÄHLEN
    $(document).on("click", ".btn_alle_checks_abwaehlen", function () {
        const instanz = $(this).attr("data-instanz");
        $('.checkliste[id="' + instanz + '"]')
            .find(".check:checked")
            .trigger("click");
    });
}
