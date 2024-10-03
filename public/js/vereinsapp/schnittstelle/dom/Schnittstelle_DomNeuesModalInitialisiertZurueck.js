function Schnittstelle_DomNeuesModalInitialisiertZurueck(modal_id, liste, data) {
    if (typeof data === "undefined") data = new Object();

    // Formular als Modal generieren

    if (!("title" in data)) data.title = undefined;
    const title = data.title;

    const $neues_modal = LISTEN[liste].modals[modal_id].clone().removeClass("blanko invisible").addClass("modal");
    if (typeof title !== "undefined") $neues_modal.find(".modal-title").text(title);

    const $formular = $neues_modal.find(".formular");

    if (!("element_id" in data)) data.element_id = undefined;
    if (typeof data.element_id !== "undefined") data.element_id = Number(data.element_id);
    const element_id = data.element_id;

    if (!("aktion" in data)) data.aktion = undefined;
    const aktion = data.aktion;

    Liste_ElementFormularInitialisieren($formular, aktion, element_id, liste);

    return $neues_modal;
}
