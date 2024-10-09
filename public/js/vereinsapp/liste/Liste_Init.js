const LISTEN = new Object();

function Liste_Init() {
    $.each(LISTEN, function (liste) {
        LISTEN[liste].instanz = new Object();
        $('.liste[data-liste="' + liste + '"]')
            .each(function () {
                const $liste = $(this);
                LISTEN[liste].instanz[$liste.attr("id")] = {
                    filtern: new Array(),
                    sortieren: new Array(),
                    $blanko_element: $liste.find(".blanko.element").first(),
                };
            })
            .empty();
    });

    Liste_ChecklisteInit();

    Liste_AuswertungenInit();

    Liste_VerzeichnisInit();

    Liste_FilternInit();

    Liste_SortierenInit();

    Liste_GruppierenInit();

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
