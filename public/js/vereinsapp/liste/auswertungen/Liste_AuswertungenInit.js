$(document).ready(function () {
    $.each(LISTEN, function (liste, LISTE) {
        LISTE.$blanko_auswertung = new Object();
        $('.auswertungen[data-liste="' + liste + '"]')
            .find(".blanko")
            .each(function () {
                const $blanko_auswertung = $(this);
                LISTE.$blanko_auswertung[$blanko_auswertung.parent().attr("id")] = $blanko_auswertung;
            });
        $('.auswertungen[data-liste="' + liste + '"]').empty();
    });

    // AUSWERTUNGEN IM DOM AKTUALISIEREN
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

            // AUSWERTUNGEN AKTUALISIEREN
            $('.auswertungen[data-liste="' + liste + '"]').each(function () {
                Liste_AuswertungenAktualisieren($(this), liste);
            });
        });
    });
});
