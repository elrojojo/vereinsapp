$(document).ready(function () {
    // CHECKS IM DOM AKTUALISIEREN
    $(document).on("VAR_upd_DOM", function (event, prio_liste) {
        const todo = new Array();
        if (prio_liste in LISTEN) {
            todo.push(prio_liste);
            $.each(Object.keys(LISTEN), function (index, liste) {
                if (liste != prio_liste) todo.push(liste);
            });
        }
        $.each(todo, function (prio, liste) {
            const LISTE = LISTEN[liste];

            // CHECK AKTUALISIEREN
            $('.check[name="' + liste + '"]').each(function () {
                const $check = $(this);
                const $liste = $check.parents(".liste").first();
                const $element = $check.parents(".element").first();
                let checked = false;

                $.each(LISTE.tabelle, function () {
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
            });
        });
    });

    // CHECK_LISTE ÄNDERN
    $(document).on("change", ".check", function () {
        const liste = $(this).parents(".liste").first().attr("data-liste");
        Liste_ChecklisteAendern($(this), liste);
    });
});
