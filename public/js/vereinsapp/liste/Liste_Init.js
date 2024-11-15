function Liste_Init() {
    $.each(LISTEN, function (liste) {
        LISTEN[liste].instanz = new Object();
        $('.liste[data-liste="' + liste + '"]').each(function () {
            LISTEN[liste].instanz[$(this).attr("id")] = { filtern: [], sortieren: [] };
        });
    });

    Liste_ChecklisteInit();

    Liste_AuswertungenInit();

    Liste_VerzeichnisInit();

    Liste_FilternInit();

    Liste_SortierenInit();

    Liste_GruppierenInit();

    $(document).on("change", ".eigenschaft", function () {
        Liste_ElementFormularEigenschaftChange($(this));
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
}
