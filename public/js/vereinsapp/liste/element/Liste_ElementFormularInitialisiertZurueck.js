function Liste_ElementFormularInitialisiertZurueck(formular_id, liste, data) {
    if (typeof data === "undefined") data = new Object();

    if (!("aktion" in data)) data.aktion = undefined;
    const aktion = data.aktion;

    if (!("title" in data)) data.title = undefined;
    const title = data.title;

    if (!("element_id" in data)) data.element_id = undefined;
    const element_id = data.element_id;

    // Formular als Modal generieren
    const $neues_modal = LISTEN[liste].modals[formular_id].clone().removeClass("blanko invisible").addClass("modal");
    if (typeof title !== "undefined") $neues_modal.find(".modal-title").text(title);
    if (typeof element_id !== "undefined") $neues_modal.find(".beschriftung").text(Liste_ElementBeschriftungZurueck(element_id, liste));

    const $formular = $neues_modal.find(".formular");

    Liste_ElementFormularEigenschaftenWerteAktualisieren($formular, element_id, liste);

    const $btn_aktion = $formular.find("[class*=btn_" + LISTEN[liste].element + "_");
    if ($btn_aktion.exists()) {
        if ($btn_aktion.hasClass("btn_" + LISTEN[liste].element + "_aktion") && typeof aktion !== "undefined")
            $btn_aktion.addClass("btn_" + LISTEN[liste].element + "_" + aktion).removeClass("btn_" + LISTEN[liste].element + "_aktion");
        if (typeof element_id !== "undefined") $btn_aktion.attr("data-element_id", element_id);
    }
    return $neues_modal;
}
