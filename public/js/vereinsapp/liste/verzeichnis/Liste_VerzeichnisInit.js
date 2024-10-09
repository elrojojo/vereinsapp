function Liste_VerzeichnisInit() {
    $.each(LISTEN, function (liste) {
        LISTEN[liste].verzeichnis = new Object();
        $('.verzeichnis[data-liste="' + liste + '"]').each(function () {
            LISTEN[liste].verzeichnis[$(this).attr("id")] = new Object();
        });
    });
}
