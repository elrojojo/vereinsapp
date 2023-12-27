function Liste_VerzeichnisInit() {
    $.each(G.LISTEN, function (liste) {
        G.LISTEN[liste].verzeichnis = new Object();
        $('.verzeichnis[data-liste="' + liste + '"]').each(function () {
            const $verzeichnis = $(this);
            const verzeichnis_instanz = $verzeichnis.attr("id");
            const $verzeichnis_pfad = $verzeichnis.siblings('.verzeichnis_pfad[data-verzeichnis_instanz="' + verzeichnis_instanz + '"]').first();
            G.LISTEN[liste].verzeichnis[verzeichnis_instanz] = {
                $blanko_verzeichnis_element: $verzeichnis.find(".blanko").first(),
                $blanko_verzeichnis_pfad_element: $verzeichnis_pfad.find(".blanko").first(),
                $verzeichnis_pfad: $verzeichnis_pfad,
            };
            $verzeichnis.siblings('.verzeichnis_pfad[data-verzeichnis_instanz="' + verzeichnis_instanz + '"]').empty();
        });
        $('.verzeichnis[data-liste="' + liste + '"]').empty();
    });

    // VERZEICHNIS ÖFFNEN
    $(document).on("click", ".btn_verzeichnis_oeffnen", function () {
        Liste_VerzeichnisOeffnen($(this));
    });

    // VERZEICHNIS_PFAD ÖFFNEN
    $(document).on("click", ".btn_verzeichnis_pfad_oeffnen", function () {
        Liste_VerzeichnisPfadOeffnen($(this));
    });
}
