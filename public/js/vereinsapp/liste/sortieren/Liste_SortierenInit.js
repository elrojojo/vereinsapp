const SORTIEREN = new Object();

function Liste_SortierenInit() {
    SORTIEREN.$blanko_sortieren_element = $(".sortieren").find(".blanko").first();
    $(".sortieren").empty();

    // FORMULAR (MODAL) ÖFFNEN
    $("#liste_sortieren_Modal").on("show.bs.modal", function (event) {
        Liste_SortierenFormularOeffnen($(this), G.MODALS.offen[G.MODALS.offen.length - 1].$btn_oeffnend);
    });

    // FORMULAR (MODAL) SCHLIESSEN
    $("#liste_sortieren_Modal").on("hide.bs.modal", function (event) {
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
