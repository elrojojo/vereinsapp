const FILTERN = new Object();

function Liste_FilternInit() {
    FILTERN.$blanko_filtern_modal = $("#modals").find(".modal.filtern").first();
    $("#modals").find(".modal.filtern").remove();
    FILTERN.$blanko_filtern_sammlung = FILTERN.$blanko_filtern_modal.find(".filtern").find(".blanko").first();
    FILTERN.$blanko_filtern_modal.find(".filtern").empty();
    FILTERN.$blanko_filtern_element = FILTERN.$blanko_filtern_sammlung.find(".blanko").first();
    FILTERN.$blanko_filtern_sammlung.find(".filtern_kind").empty();

    FILTERN.$blanko_filtern_definition = new Object();
    FILTERN.$blanko_filtern_modal
        .find(".filtern_definitionen")
        .find(".blanko")
        .each(function () {
            const $blanko = $(this);
            FILTERN.$blanko_filtern_definition[$blanko.attr("data-typ")] = $blanko;
        });
    FILTERN.$blanko_filtern_modal.find(".filtern_definitionen").empty();

    // FORMULAR (MODAL) ÖFFNEN
    $(document).on("click", ".btn_filtern_formular_oeffnen", function () {
        Liste_FilternFormularOeffnen({ instanz: $(this).attr("data-instanz"), title: $(this).attr("data-title") }, $(this).attr("data-liste"));
    });

    // ERSTELLEN
    $(document).on("click", ".btn_filtern_erstellen", function () {
        Liste_FilternErstellen($(this));
    });

    // ÄNDERN (VERKNÜPFUNG)
    $(document).on("click", ".btn_filtern_aendern", function () {
        Liste_FilternVerknuepfungAendern($(this));
    });

    // LÖSCHEN
    $(document).on("click", ".btn_filtern_loeschen", function () {
        Liste_FilternLoeschen($(this));
    });
}
