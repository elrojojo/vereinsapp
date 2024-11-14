function Liste_ChecklisteInit() {
    // CHECK ÄNDERN
    $(document).on("change", ".check", function () {
        Liste_CheckAendern(
            { $check: $(this), $element: $(this).closest(".element") },
            {
                liste: $(this).closest(".element").attr("data-liste"),
                element_id: $(this).val(),
                gegen_liste: $(this).closest(".element").attr("data-gegen_liste"),
                gegen_element_id: $(this).closest(".element").attr("data-gegen_element_id"),
                checkliste: $(this).attr("data-checkliste"),
                status: $(this).is(":checked"),
            }
        );
    });

    // ALLE CHECKS ANWÄHLEN
    $(document).on("click", ".btn_alle_checks_anwaehlen", function () {
        const instanz = $(this).attr("data-instanz");
        $(".liste[id='" + instanz + "']")
            .find(".check:not(:checked)")
            .trigger("click");
    });

    // ALLE CHECKS ABWÄHLEN
    $(document).on("click", ".btn_alle_checks_abwaehlen", function () {
        const instanz = $(this).attr("data-instanz");
        $('.liste[id="' + instanz + '"]')
            .find(".check:checked")
            .trigger("click");
    });
}
