function Liste_AuswertungenInit() {
    $.each(LISTEN, function (liste) {
        LISTEN[liste].auswertungen = new Object();
        $('.auswertungen[data-auswertungen="' + liste + '"]').each(function () {
            const $auswertungen = $(this);
            const auswertungen_instanz = $auswertungen.attr("id");
            LISTEN[liste].auswertungen[auswertungen_instanz] = {
                eigenschaft: undefined,
                cluster: new Object(),
                $blanko_auswertung: $auswertungen.find(".blanko").first(),
            };
        });
        $('.auswertungen[data-auswertungen="' + liste + '"]').empty();
    });
}
