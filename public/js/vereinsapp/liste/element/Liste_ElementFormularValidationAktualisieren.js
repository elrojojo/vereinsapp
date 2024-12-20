function Liste_ElementFormularValidationAktualisieren($formular, validation) {
    $formular.find(".eingabe").each(function () {
        const $eingabe = $(this);
        const eingabe = $eingabe.attr("data-eingabe");

        if (eingabe in validation) {
            $eingabe.addClass("is-invalid").removeClass("is-valid");
            $eingabe.after('<div class="invalid-tooltip">' + validation[eingabe] + "</div>");
        } else {
            $eingabe.addClass("is-valid").removeClass("is-invalid");
        }
    });
}
