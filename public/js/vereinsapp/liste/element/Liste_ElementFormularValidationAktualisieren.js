function Liste_ElementFormularValidationAktualisieren($formular, validation) {
    $formular.find(".eigenschaft").each(function () {
        const $eigenschaft = $(this);
        const eigenschaft = $eigenschaft.attr("data-eigenschaft");

        if (eigenschaft in validation) {
            $eigenschaft.addClass("is-invalid").removeClass("is-valid");
            $eigenschaft.after('<div class="invalid-tooltip">' + validation[eigenschaft] + "</div>");
        } else {
            $eigenschaft.addClass("is-valid").removeClass("is-invalid");
        }
    });
}
