function Liste_CheckAktualisieren($check, liste) {
    const $liste = $check.parents(".liste").first();
    const $element = $check.parents(".element").first();
    let checked = false;

    $.each(LISTEN[liste].tabelle, function () {
        const element = this;
        if ("id" in element) {
            if (
                element[$liste.attr("data-gegen_element") + "_id"] == Number($liste.attr("data-gegen_element_id")) &&
                element[$element.attr("data-element") + "_id"] == Number($check.val())
            )
                checked = true;
        }
    });
    $check.attr("checked", checked);
}
