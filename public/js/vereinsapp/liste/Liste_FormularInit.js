function Liste_FormularInit() {
    // FORMULAR (MODAL) ÖFFNEN
    $(".formular").on("show.bs.modal", function (event) {
        Liste_ElementFormularOeffnen($(this), $(event.relatedTarget), $(event.relatedTarget).attr("data-liste"));
    });
}
