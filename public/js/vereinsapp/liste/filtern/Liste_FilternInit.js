const FILTERN = new Object();
FILTERN.$blanko_filtern_definition = new Object();

function Liste_FilternInit() {
    // MODAL ÖFFNEN
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
