const LISTEN = new Object();

function Liste_Init() {
    $.each(LISTEN, function (liste) {
        LISTEN[liste].instanz = new Object();
        $('.liste[data-liste="' + liste + '"]').each(function () {
            const $liste = $(this);
            const instanz = $liste.attr("id");
            LISTEN[liste].instanz[instanz] = { filtern: new Array(), sortieren: new Array(), $blanko_element: $liste.find(".blanko").first() };
            $liste.empty();
        });

        LISTEN[liste].modals = new Object();
        $('.blanko_modals[data-liste="' + liste + '"]').each(function () {
            const $blanko_modals = $(this);
            $blanko_modals.find(".blanko").each(function () {
                const $blanko_modal = $(this);
                const blanko_modal_id = $blanko_modal.attr("id");
                $blanko_modal.removeAttr("id");
                LISTEN[liste].modals[blanko_modal_id] = $blanko_modal;
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
    if (Object.keys(LISTEN).length > 0)
        Schnittstelle_EventSqlUpdLocalstorage(Object.keys(LISTEN), true, [
            Schnittstelle_EventLocalstorageUpdVariable,
            Schnittstelle_EventVariableUpdDom,
        ]);
}
