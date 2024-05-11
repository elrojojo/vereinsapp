function Liste_AuswertungenInit() {
    $.each(LISTEN, function (liste) {
        LISTEN[liste].auswertungen = new Object();
        $('.auswertungen[data-auswertungen="' + liste + '"]').each(function () {
            const $auswertungen = $(this);
            const auswertungen_instanz = $auswertungen.attr("id");
            LISTEN[liste].auswertungen[auswertungen_instanz] = new Object();
            LISTEN[liste].auswertungen[auswertungen_instanz].$blanko_auswertung = $auswertungen.find(".blanko").first();
        });
        $('.auswertungen[data-auswertungen="' + liste + '"]').empty();
    });
}
