$(document).ready(function () {
    $.each(G.LISTEN, function (liste) {
        G.LISTEN[liste].$blanko_auswertung = new Object();
        $('.auswertungen[data-liste="' + liste + '"]')
            .find(".blanko")
            .each(function () {
                const $blanko_auswertung = $(this);
                G.LISTEN[liste].$blanko_auswertung[$blanko_auswertung.parent().attr("id")] = $blanko_auswertung;
            });
        $('.auswertungen[data-liste="' + liste + '"]').empty();
    });

    // AUSWERTUNGEN IM DOM AKTUALISIEREN
    $(document).on("VAR_upd_DOM", function (event, prio_liste) {
        $.each(Liste_TodoZurueck(prio_liste), function (prio, liste) {
            // AUSWERTUNGEN AKTUALISIEREN
            $('.auswertungen[data-liste="' + liste + '"]').each(function () {
                Liste_AuswertungenAktualisieren($(this), liste);
            });
        });
    });
});
