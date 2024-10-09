const FILTERN = new Object();

function Liste_FilternInit() {
    FILTERN.$blanko_filtern_sammlung = MODALS.FILTERN.find(".filtern").find(".blanko.filtern_sammlung").first();
    MODALS.FILTERN.find(".filtern").empty();

    FILTERN.$blanko_filtern_element = FILTERN.$blanko_filtern_sammlung.find(".filtern_kind").find(".blanko.filtern_element").first();
    FILTERN.$blanko_filtern_sammlung.find(".filtern_kind").empty();

    FILTERN.$blanko_filtern_definition = new Object();
    MODALS.FILTERN.find(".filtern_definitionen")
        .find(".blanko.filtern_definition")
        .each(function () {
            const typ = $(this).attr("data-typ");
            FILTERN.$blanko_filtern_definition[typ] = $(this);
        });
    MODALS.FILTERN.find(".filtern_definitionen").empty();

    // FORMULAR (MODAL) ÖFFNEN
    $(document).on("click", ".btn_filtern_modal_oeffnen", function () {
        Liste_FilternModalOeffnen($(this).attr("data-title"), $(this).attr("data-instanz"), $(this).attr("data-liste"));
    });

    // ERSTELLEN
    $(document).on("click", ".btn_filtern_erstellen", function () {
        Liste_FilternErstellen($(this).closest(".filtern_definition"), $(this).attr("data-instanz"), $(this).attr("data-liste"));
    });

    // ÄNDERN (VERKNÜPFUNG)
    $(document).on("click", ".btn_filtern_aendern", function () {
        Liste_FilternVerknuepfungAendern(
            $(this).closest(".filtern_sammlung").find(".verknuepfung").first(),
            $(this).attr("data-instanz"),
            $(this).attr("data-liste")
        );
    });

    // LÖSCHEN
    $(document).on("click", ".btn_filtern_loeschen", function () {
        Liste_FilternLoeschen($(this).closest(".filtern_element, .filtern_sammlung"), $(this).attr("data-instanz"), $(this).attr("data-liste"));
    });
}
