const SORTIEREN = new Object();

function Liste_SortierenInit() {
    SORTIEREN.$blanko_sortieren_element = $(".sortieren").find(".blanko").first();
    $(".sortieren").empty();

    // FORMULAR (MODAL) ÖFFNEN
    $("#liste_sortieren_Modal").on("show.bs.modal", function (event) {
        Liste_SortierenFormularOeffnen($(this), $(event.relatedTarget));
    });

    // ERSTELLEN
    $(document).on("click", ".btn_sortieren_erstellen", function () {
        Liste_SortierenErstellen($(this));
    });

    // ÄNDERN (RICHTUNG)
    // $(document).on("click", ".btn_sortieren_aendern", function () {});

    // LÖSCHEN
    $(document).on("click", ".btn_sortieren_loeschen", function () {
        Liste_SortierenLoeschen($(this));
    });
}
