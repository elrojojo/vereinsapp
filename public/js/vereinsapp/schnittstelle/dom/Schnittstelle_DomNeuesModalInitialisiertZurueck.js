function Schnittstelle_DomNeuesModalInitialisiertZurueck(title, modal_id, liste) {
    const $neues_modal = LISTEN[liste].modals[modal_id].clone().removeClass("blanko invisible").addClass("modal");
    if (typeof title !== "undefined") $neues_modal.find(".modal-title").text(title);

    return $neues_modal;
}
