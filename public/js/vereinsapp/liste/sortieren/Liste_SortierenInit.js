const SORTIEREN = new Object();

$(document).ready(function () {
    {
        SORTIEREN.$blanko_sortieren_element = $(".sortieren").find(".blanko").first();
        $(".sortieren").empty();
    }

    // FORMULAR (MODAL) ÖFFNEN
    $("#liste_sortieren_Modal").on("show.bs.modal", function (event) {
        const $btn_oeffnend = $(event.relatedTarget);
        const liste = $btn_oeffnend.attr("data-liste");
        Liste_SortierenFormularOeffnen($(this), $btn_oeffnend, liste);
    });

    // ERSTELLEN
    $(document).on("click", ".btn_sortieren_erstellen", function () {
        const liste = $(this).parents("[data-liste]").first().attr("data-liste");
        Liste_SortierenErstellen($(this), liste);
    });

    // ÄNDERN (VERKNÜPFUNG)
    $(document).on("click", ".btn_sortieren_aendern", function () {});

    // LÖSCHEN
    $(document).on("click", ".btn_sortieren_loeschen", function () {
        const liste = $(this).parents("[data-liste]").first().attr("data-liste");
        Liste_SortierenLoeschen($(this), liste);
    });
});
