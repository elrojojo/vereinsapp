function Liste_ElementFormularEigenschaftChange($eigenschaft) {
    const eigenschaft = $eigenschaft.attr("data-eigenschaft");
    const $formular = $eigenschaft.closest(".formular");
    $formular.find(".eigenschaft.verlinkte_eigenschaft").each(function () {
        const $verlinkte_eigenschaft = $(this);

        if ($verlinkte_eigenschaft.attr("data-verlinkte_eigenschaft") == eigenschaft) {
            let data_eigenschaft = eigenschaft;
            if (eigenschaft == "zugeordnete_liste") data_eigenschaft = "liste";

            if ($eigenschaft.val() != "") $verlinkte_eigenschaft.attr("data-" + data_eigenschaft, $eigenschaft.val()).removeClass("disabled");
            else $verlinkte_eigenschaft.removeAttr("data-" + data_eigenschaft).addClass("disabled");
        }
    });
}
