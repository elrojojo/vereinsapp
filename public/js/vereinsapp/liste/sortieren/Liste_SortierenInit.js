const SORTIEREN = new Object();

function Liste_SortierenInit() {
    MODALS.sortieren = $("#modals").find(".blanko#sortieren").first();
    $("#modals").find(".blanko#sortieren").remove();
    SORTIEREN.$blanko_sortieren_element = MODALS.sortieren.find(".sortieren").find(".blanko").first();
    MODALS.sortieren.find(".sortieren").empty();

    // FORMULAR (MODAL) ÖFFNEN
    $(document).on("click", ".btn_sortieren_oeffnen", function () {
        Liste_SortierenFormularOeffnen({ instanz: $(this).attr("data-instanz"), title: $(this).attr("data-title") }, $(this).attr("data-liste"));
    });

    // ERSTELLEN
    $(document).on("click", ".btn_sortieren_erstellen", function () {
        Liste_SortierenErstellen($(this).closest(".sortieren_definitionen"), $(this).attr("data-instanz"), $(this).attr("data-liste"));
    });

    // ÄNDERN (RICHTUNG)
    $(document).on("click", ".btn_sortieren_aendern", function () {
        Liste_SortierenRichtungAendern($(this), $(this).attr("data-instanz"), $(this).attr("data-liste"));
    });

    // LÖSCHEN
    $(document).on("click", ".btn_sortieren_loeschen", function () {
        Liste_SortierenLoeschen($(this).closest(".sortieren_element"), $(this).attr("data-instanz"), $(this).attr("data-liste"));
    });
}
