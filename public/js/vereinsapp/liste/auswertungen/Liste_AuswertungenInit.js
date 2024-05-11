function Liste_AuswertungenInit() {
    $.each(LISTEN, function (liste) {
        $('.auswertungen[data-auswertungen="' + liste + '"]').each(function () {
            const $auswertungen = $(this);
            const auswertungen_instanz = $auswertungen.attr("id");

            LISTEN[liste].instanz[auswertungen_instanz] = new Object();
            LISTEN[liste].instanz[auswertungen_instanz].$blanko_auswertung = $auswertungen.find(".blanko").first();

            let liste_data = $auswertungen.attr("data-liste");
            if (typeof liste_data !== "undefined") liste_data = JSON.parse(liste_data);
            else liste_data = new Object();
            // liste aus liste_data
            let liste_ = undefined;
            if ("liste" in liste_data) liste_ = liste_data.liste;
            LISTEN[liste_].instanz[auswertungen_instanz] = new Object();
        });
        $('.auswertungen[data-auswertungen="' + liste + '"]').empty();
    });
}
