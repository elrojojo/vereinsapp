function Liste_VerzeichnisInit() {
    $.each(G.LISTEN, function (liste) {
        G.LISTEN[liste].verzeichnis = new Object();
        $('.verzeichnis[data-liste="' + liste + '"]').each(function () {
            const $verzeichnis = $(this);
            const instanz = $verzeichnis.attr("id");
            G.LISTEN[liste].verzeichnis[instanz] = new Object();

            G.LISTEN[liste].verzeichnis[instanz].$blanko_unterverzeichnis = $verzeichnis.find(".blanko").first();
            $verzeichnis.empty();
            G.LISTEN[liste].verzeichnis[instanz].$blanko_datei = G.LISTEN[liste].verzeichnis[instanz].$blanko_unterverzeichnis
                .find(".blanko")
                .first();
            G.LISTEN[liste].verzeichnis[instanz].$blanko_unterverzeichnis.find(".verzeichnis").empty();
        });
    });
}
