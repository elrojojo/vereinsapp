function Liste_GruppierenModalOeffnen(title, instanz, liste) {
    const $neues_gruppieren_modal = Schnittstelle_DomNeuesModalInitialisiertZurueck(title, "GRUPPIEREN");
    Liste_GruppierenFormularInitialisieren($neues_gruppieren_modal.find(".gruppieren_formular"), instanz, liste);
    Schnittstelle_DomModalOeffnen($neues_gruppieren_modal);
}
