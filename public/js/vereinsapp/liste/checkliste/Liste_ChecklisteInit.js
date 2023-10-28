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
            // CHECK AKTUALISIEREN
            $('.check[name="' + liste + '"]').each(function () {
                Liste_CheckAktualisieren($(this), liste);
            });
        });
    });

    // CHECK_LISTE ÄNDERN
    $(document).on("change", ".check", function () {
        const liste = $(this).parents(".liste").first().attr("data-liste");
        Liste_ChecklisteAendern($(this), liste);
    });
});
