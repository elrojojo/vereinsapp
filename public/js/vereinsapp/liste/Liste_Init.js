function Liste_Init() {
    Liste_SortierenInit(); // TODO: Liste_SortierenInit(); nach $.each(G.LISTEN, function (liste) {});

    Liste_FilternInit(); // TODO: Liste_FilternInit(); nach $.each(G.LISTEN, function (liste) {});

    $.each(G.LISTEN, function (liste) {
        G.LISTEN[liste].instanz = new Object();
        $('.liste[data-liste="' + liste + '"]').each(function () {
            const $liste = $(this);
            const instanz = $liste.attr("id");
            G.LISTEN[liste].instanz[instanz] = { filtern: new Array(), sortieren: new Array(), $blanko_element: $liste.find(".blanko").first() };
        });
        $('.liste[data-liste="' + liste + '"]').empty();
    });

    Liste_AuswertungenInit();

    // FORMULAR (MODAL) ÖFFNEN
    $(".formular").on("show.bs.modal", function () {
        Liste_ElementFormularOeffnen($(this), G.MODALS.offen[G.MODALS.offen.length - 1].$btn_oeffnend);
    });

    // ELEMENT ERSTELLEN
    $(document).on("click", ".btn_element_erstellen", function () {
        const element = $(this).attr("data-element");
        let liste;
        $.each(G.LISTEN, function (liste_, LISTE_) {
            if (element == LISTE_.element) liste = liste_;
        });
        Liste_ElementErstellen($(this), liste);
    });

    // ELEMENT LÖSCHEN
    $(document).on("click", ".btn_element_loeschen", function () {
        const element = $(this).attr("data-element");
        let liste;
        $.each(G.LISTEN, function (liste_, LISTE_) {
            if (element == LISTE_.element) liste = liste_;
        });
        Liste_ElementLoeschen($(this), liste);
    });

    // CHECKLISTE ÄNDERN
    $(document).on("change", ".check", function () {
        Liste_CheckAendern($(this));
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

    Schnittstelle_EventLocalstorageUpdVariable();
    Schnittstelle_EventVariableUpdDom();
    if (Object.keys(G.LISTEN).length > 0)
        Schnittstelle_EventSqlUpdLocalstorage(Object.keys(G.LISTEN), true, [
            Schnittstelle_EventLocalstorageUpdVariable,
            Schnittstelle_EventVariableUpdDom,
        ]);
}
