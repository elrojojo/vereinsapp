function Liste_AuswertungenInit() {
    $.each(G.LISTEN, function (liste) {
        G.LISTEN[liste].auswertungen = new Object();
        $('.auswertungen[data-liste="' + liste + '"]').each(function () {
            const $auswertungen = $(this);
            const auswertungen_instanz = $auswertungen.attr("id");
            G.LISTEN[liste].auswertungen[auswertungen_instanz] = { $blanko_auswertung: $auswertungen.find(".blanko").first() };
        });
        $('.auswertungen[data-liste="' + liste + '"]').empty();
    });
}
