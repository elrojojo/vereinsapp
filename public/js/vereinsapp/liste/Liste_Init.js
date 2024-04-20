function Liste_Init() {
    $.each(G.LISTEN, function (liste) {
        G.LISTEN[liste].instanz = new Object();
        $('.liste[data-liste="' + liste + '"]').each(function () {
            const $liste = $(this);
            const instanz = $liste.attr("id");
            G.LISTEN[liste].instanz[instanz] = { filtern: new Array(), sortieren: new Array(), $blanko_element: $liste.find(".blanko").first() };
            $liste.empty();
        });

        G.LISTEN[liste].modals = new Object();
        $('.blanko_modals[data-liste="' + liste + '"]').each(function () {
            const $blanko_modals = $(this);
            $blanko_modals.find(".blanko").each(function () {
                const $blanko_modal = $(this);
                const blanko_modal_id = $blanko_modal.attr("id");
                $blanko_modal.removeAttr("id");
                G.LISTEN[liste].modals[blanko_modal_id] = $blanko_modal;
            });
            $blanko_modals.remove();
        });
    });

    Liste_ChecklisteInit();

    Liste_AuswertungenInit();

    Liste_VerzeichnisInit();

    Liste_FilternInit();

    Liste_SortierenInit();

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
