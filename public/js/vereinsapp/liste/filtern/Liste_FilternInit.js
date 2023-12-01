const FILTERN = new Object();

function Liste_FilternInit() {
    FILTERN.$blanko_filtern_sammlung = $(".filtern").find(".blanko").first();
    $(".filtern").empty();
    FILTERN.$blanko_filtern_element = FILTERN.$blanko_filtern_sammlung.find(".blanko").first();
    FILTERN.$blanko_filtern_sammlung.find(".filtern_kind").empty();

    FILTERN.$blanko_filtern_definition = new Object();
    $(".filtern_definitionen")
        .find(".blanko")
        .each(function () {
            const $blanko = $(this);
            FILTERN.$blanko_filtern_definition[$blanko.attr("data-typ")] = $blanko;
        });
    $(".filtern_definitionen").empty();

    // FORMULAR (MODAL) ÖFFNEN
    $("#liste_filtern_Modal").on("show.bs.modal", function (event) {
        const $btn_oeffnend = $(event.relatedTarget);
        const liste = $btn_oeffnend.attr("data-liste");
        Liste_FilternFormularOeffnen($(this), $btn_oeffnend, liste);
    });

    // ERSTELLEN
    $(document).on("click", ".btn_filtern_erstellen", function () {
        const liste = $(this).parents("[data-liste]").first().attr("data-liste");
        Liste_FilternErstellen($(this), liste);
    });

    // ÄNDERN (VERKNÜPFUNG)
    $(document).on("click", ".btn_filtern_aendern", function () {
        const liste = $(this).parents("[data-liste]").first().attr("data-liste");
        Liste_FilternVerknuepfungAendern($(this), liste);
    });

    // LÖSCHEN
    $(document).on("click", ".btn_filtern_loeschen", function () {
        const liste = $(this).parents("[data-liste]").first().attr("data-liste");
        Liste_FilternLoeschen($(this), liste);
    });
}
