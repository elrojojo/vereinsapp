const LISTEN = new Object();

$(document).ready(function () {
    $.each(LISTEN, function (liste, LISTE) {
        LOC_upd_VAR(liste);

        LISTE.$blanko_element = new Object();
        $('.liste[data-liste="' + liste + '"]')
            .find(".blanko")
            .each(function () {
                const $blanko_element = $(this);
                LISTE.$blanko_element[$blanko_element.parent().attr("id")] = $blanko_element;
            });
        $('.liste[data-liste="' + liste + '"]').empty();
    });

    $(document).trigger("VAR_upd_DOM");

    // LISTE UND ELEMENT IM DOM AKTUALISIEREN
    $(document).on("VAR_upd_DOM", function (event, prio_liste) {
        $.each(Liste_GibTodo(prio_liste), function (prio, liste) {
            // LISTE AKTUALISIEREN
            $('.liste[data-liste="' + liste + '"]').each(function () {
                Liste_Aktualisieren($(this), liste);
            });

            // ELEMENT AKTUALISIEREN
            $('.element[data-element="' + LISTEN[liste].element + '"]').each(function () {
                Liste_ElementAktualisieren($(this), liste);
            });

            $(document).trigger("VAR_upd_DOM_" + liste);

            //console.log( 'ERFOLG VAR_upd_DOM_'+liste );
        });
    });

    // FORMULAR (MODAL) ÖFFNEN
    $(".formular").on("show.bs.modal", function (event) {
        const $btn_oeffnend = $(event.relatedTarget);
        const liste = $btn_oeffnend.attr("data-liste");
        Liste_ElementFormularOeffnen($(this), $btn_oeffnend, liste);
    });

    // ELEMENT ERSTELLEN
    $(document).on("click", ".btn_element_erstellen", function () {
        const element = $(this).attr("data-element");
        let liste;
        $.each(LISTEN, function (liste_, LISTE_) {
            if (element == LISTE_.element) liste = liste_;
        });
        Liste_ElementErstellen($(this), liste);
    });

    // ELEMENT LÖSCHEN
    $(document).on("click", ".btn_element_loeschen", function () {
        const element = $(this).attr("data-element");
        let liste;
        $.each(LISTEN, function (liste_, LISTE_) {
            if (element == LISTE_.element) liste = liste_;
        });
        Liste_ElementLoeschen($(this), liste);
    });

    // CHECKLISTE ÄNDERN
    $(document).on("change", ".check", function () {
        const liste = $(this).parents(".liste").first().attr("data-liste");
        Liste_CheckAendern($(this), liste);
    });

    // SORTABLE
    $(".sortable").sortable({
        handle: ".sortable_handle",
        start: function (event, ui) {
            ui.item.addClass("border-top border-primary shadow");
        },
        stop: function (event, ui) {
            ui.item.removeClass("border-top border-primary shadow");
        },
        update: function () {
            $("#sortable_speichern").attr("disabled", false);
        },
    });

    $.each(LISTEN, function (liste, LISTE) {
        $(document).trigger("Schnittstelle_SQL_upd_LOC_event", [true, liste]); // $(document).trigger( 'LOC_upd_VAR' );
    });

    $(document).trigger("VAR_upd_DOM");
});
