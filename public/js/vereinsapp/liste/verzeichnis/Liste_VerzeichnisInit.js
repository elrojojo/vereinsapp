function Liste_VerzeichnisInit() {
    $.each(LISTEN, function (liste) {
        LISTEN[liste].verzeichnis = new Object();
        $('.verzeichnis[data-liste="' + liste + '"]').each(function () {
            const $verzeichnis = $(this);
            const instanz = $verzeichnis.attr("id");
            LISTEN[liste].verzeichnis[instanz] = new Object();

            LISTEN[liste].verzeichnis[instanz].$blanko_unterverzeichnis = $verzeichnis.find(".blanko.unterverzeichnis").first();
            $verzeichnis.empty();
            LISTEN[liste].verzeichnis[instanz].$blanko_datei = LISTEN[liste].verzeichnis[instanz].$blanko_unterverzeichnis
                .find(".verzeichnis")
                .find(".blanko.datei")
                .first();
            LISTEN[liste].verzeichnis[instanz].$blanko_unterverzeichnis.find(".verzeichnis").empty();
        });
    });
}
