const SORTIEREN = new Object();

$(document).ready(function () {
    {
        SORTIEREN.$blanko_sortieren_element = $(".sortieren").find(".blanko").first();
        $(".sortieren").empty();
    }

    // SORTIEREN IM DOM AKTUALISIEREN
    $(document).on("VAR_upd_DOM", function (event, prio_liste) {
        const todo = new Array();
        if (prio_liste in LISTEN) {
            todo.push(prio_liste);
            $.each(Object.keys(LISTEN), function (index, liste) {
                if (liste != prio_liste) todo.push(liste);
            });
        }
        $.each(todo, function (prio, liste) {
            const LISTE = LISTEN[liste];

            // SORTIEREN AKTUALISIEREN
            $('.sortieren[data-liste="' + liste + '"]').each(function () {
                const $sortieren = $(this);
                $sortieren.html(Liste_Sortieren2$Sortieren(LISTE.sortieren, liste));
            });
        });
    });

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
