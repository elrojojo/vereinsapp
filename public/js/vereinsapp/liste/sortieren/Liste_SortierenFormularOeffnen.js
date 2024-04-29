function Liste_SortierenFormularOeffnen(instanz, liste, data) {
    if (typeof data === "undefined") data = new Object();

    if (!("title" in data)) data.title = undefined;
    const title = data.title;

    const $neues_sortieren_formular = SORTIEREN.$blanko_sortieren_modal.clone().removeClass("invisible");

    $neues_sortieren_formular.find(".sortieren, .sortieren_definitionen").attr("data-liste", liste);
    // if (typeof instanz !== "undefined")
    $neues_sortieren_formular.find(".sortieren, .sortieren_definitionen").attr("data-instanz", instanz);
    // else $neues_sortieren_formular.find(".sortieren, .sortieren_definitionen").removeAttr("data-instanz");

    const $sortieren_definitionen = $neues_sortieren_formular.find(".sortieren_definitionen");

    $sortieren_definitionen.find(".sortieren_eigenschaft").empty();
    $.each(SORTIERBARE_EIGENSCHAFTEN[liste], function (index, eigenschaft) {
        $('<option value="' + eigenschaft + '">' + EIGENSCHAFTEN[liste][eigenschaft].beschriftung + "</option>").appendTo(
            $sortieren_definitionen.find(".sortieren_eigenschaft")
        );
    });

    $sortieren_definitionen.find(".btn_sortieren_erstellen").first().attr("data-liste", liste).attr("data-instanz", instanz);

    Liste_SortierenAktualisieren($neues_sortieren_formular, liste);

    if (typeof title !== "undefined") $neues_sortieren_formular.find(".modal-title").text(title);

    Schnittstelle_DomModalOeffnen($neues_sortieren_formular);
}
