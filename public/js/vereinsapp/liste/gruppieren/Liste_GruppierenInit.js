const GRUPPIEREN = new Object();

function Liste_GruppierenInit() {
    GRUPPIEREN.$blanko_gruppieren_modal = $("#modals").find(".modal.gruppieren").first();
    $("#modals").find(".modal.gruppieren").remove();

    // FORMULAR (MODAL) ÖFFNEN
    $(document).on("click", ".btn_gruppieren_formular_oeffnen", function () {
        Liste_GruppierenFormularOeffnen({ instanz: $(this).attr("data-instanz"), title: $(this).attr("data-title") }, $(this).attr("data-liste"));
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
