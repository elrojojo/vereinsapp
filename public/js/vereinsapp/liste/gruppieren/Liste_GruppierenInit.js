const GRUPPIEREN = new Object();

function Liste_GruppierenInit() {
    // MODAL ÖFFNEN
    $(document).on("click", ".btn_gruppieren_modal_oeffnen", function () {
        Liste_GruppierenModalOeffnen($(this).attr("data-title"), $(this).attr("data-instanz"), $(this).attr("data-liste"));
    });

    // ERSTELLEN
    $(document).on("change", ".gruppieren_eigenschaft", function () {
        Liste_GruppierenSpeichern(
            $(this),
            $(this).closest(".gruppieren_definitionen").attr("data-instanz"),
            $(this).closest(".gruppieren_definitionen").attr("data-liste")
        );
    });
}
