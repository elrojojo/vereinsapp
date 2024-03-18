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
    $(document).on("show.bs.modal", "#liste_filtern_modal", function () {
        Liste_FilternFormularOeffnen($(this), G.MODALS.offen[G.MODALS.offen.length - 1].$btn_oeffnend);
    });

    // FORMULAR (MODAL) SCHLIESSEN
    $(document).on("hide.bs.modal", "#liste_filtern_modal", function () {
        Liste_FilternFormularSchliessen($(this));
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
