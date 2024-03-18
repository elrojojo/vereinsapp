const SORTIEREN = new Object();

function Liste_SortierenInit() {
    SORTIEREN.$blanko_sortieren_element = $(".sortieren").find(".blanko").first();
    $(".sortieren").empty();

    // FORMULAR (MODAL) ÖFFNEN
    $(document).on("show.bs.modal", "#liste_sortieren_modal", function () {
        Liste_SortierenFormularOeffnen($(this), G.MODALS.offen[G.MODALS.offen.length - 1].$btn_oeffnend);
    });

    // FORMULAR (MODAL) SCHLIESSEN
    $(document).on("hide.bs.modal", "#liste_sortieren_modal", function () {
        Liste_SortierenFormularSchliessen($(this));
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
