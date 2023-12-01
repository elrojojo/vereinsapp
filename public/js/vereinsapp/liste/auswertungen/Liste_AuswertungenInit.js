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
});
