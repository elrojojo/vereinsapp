function Liste_Init() {
    $.each(G.LISTEN, function (liste) {
        G.LISTEN[liste].instanz = new Object();
        $('.liste[data-liste="' + liste + '"]').each(function () {
            const $liste = $(this);
            const instanz = $liste.attr("id");
            G.LISTEN[liste].instanz[instanz] = { filtern: new Array(), sortieren: new Array(), $blanko_element: $liste.find(".blanko").first() };
        });
        $('.liste[data-liste="' + liste + '"]').empty();
    });

    Liste_ChecklisteInit();

    Liste_AuswertungenInit();

    Liste_VerzeichnisInit();

    Liste_FilternInit();

    Liste_SortierenInit();

    // FORMULAR (MODAL) ÖFFNEN
    $(document).on("show.bs.modal", ".formular", function () {
        Liste_ElementFormularOeffnen($(this), G.MODALS.offen[G.MODALS.offen.length - 1].$btn_oeffnend);
    });

    // FORMULAR (MODAL) SCHLIESSEN
    $(document).on("hide.bs.modal", ".formular", function () {
        Liste_ElementFormularSchliessen($(this));
    });

    // ELEMENT ERSTELLEN
    $(document).on("click", ".btn_erfolgreich_abschliessen", function () {
        Liste_ElementErstellen($(this));
    });

    // ELEMENT LÖSCHEN
    $(document).on("click", ".btn_element_loeschen", function () {
        Liste_ElementLoeschen($(this));
    });

    // CHECKLISTE ÄNDERN
    $(document).on("change", ".check", function () {
        Liste_CheckAendern($(this));
    });

    // ALLE CHECKS ANWÄHLEN
    $(document).on("click", ".btn_alle_checks_anwaehlen", function () {
        const $btn = $(this);
        const instanz = $btn.attr("data-instanz");
        $(".checkliste[id='" + instanz + "']")
            .find(".check:not(:checked)")
            .trigger("click");
    });

    // ALLE CHECKS ABWÄHLEN
    $(document).on("click", ".btn_alle_checks_abwaehlen", function () {
        const $btn = $(this);
        const instanz = $btn.attr("data-instanz");
        $('.checkliste[id="' + instanz + '"]')
            .find(".check:checked")
            .trigger("click");
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
