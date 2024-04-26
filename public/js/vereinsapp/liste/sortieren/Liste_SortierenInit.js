const SORTIEREN = new Object();

function Liste_SortierenInit() {
    SORTIEREN.$blanko_sortieren_modal = $("#modals").find(".modal.sortieren").first();
    $("#modals").find(".modal.sortieren").remove();
    SORTIEREN.$blanko_sortieren_element = SORTIEREN.$blanko_sortieren_modal.find(".sortieren").find(".blanko").first();
    SORTIEREN.$blanko_sortieren_modal.find(".sortieren").empty();

    // FORMULAR (MODAL) ÖFFNEN
    $(document).on("click", ".btn_sortieren_formular_oeffnen", function () {
        Liste_SortierenFormularOeffnen($(this).attr("data-instanz"), $(this).attr("data-liste"), {
            title: $(this).attr("data-title"),
        });
    });

    // ERSTELLEN
    $(document).on("click", ".btn_sortieren_erstellen", function () {
        Liste_SortierenErstellen($(this));
    });

    // ÄNDERN (RICHTUNG)
    $(document).on("click", ".btn_sortieren_aendern", function () {
        Liste_SortierenRichtungAendern($(this));
    });

    // LÖSCHEN
    $(document).on("click", ".btn_sortieren_loeschen", function () {
        Liste_SortierenLoeschen($(this));
    });
}
