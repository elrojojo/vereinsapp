function Liste_AuswahlInit() {
    // MODAL ÖFFNEN
    $(document).on("click", ".btn_auswahl_modal_oeffnen", function () {
        Liste_AuswahlModalOeffnen($(this).attr("data-title"), $(this).attr("data-liste"));
    });
}
