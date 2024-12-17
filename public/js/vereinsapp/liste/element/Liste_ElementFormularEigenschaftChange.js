function Liste_ElementFormularEigenschaftChange($eigenschaft) {
    const verlinkte_eigenschaft = $eigenschaft.attr("data-verlinkte_eigenschaft");
    const $formular = $eigenschaft.closest(".formular");

    const eigenschaft = $eigenschaft.attr("data-eigenschaft").replace("zugeordnete_", "");

    $formular.find('.eigenschaft[data-eigenschaft="' + verlinkte_eigenschaft + '"]').each(function () {
        const $verlinkte_eigenschaft = $(this);

        if ($eigenschaft.val() != "") $verlinkte_eigenschaft.attr("data-" + eigenschaft, $eigenschaft.val()).removeClass("disabled");
        else
            $verlinkte_eigenschaft
                .removeAttr("data-" + eigenschaft)
                .addClass("disabled")
                .val("");
    });
}
