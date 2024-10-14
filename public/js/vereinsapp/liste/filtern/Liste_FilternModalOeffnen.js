function Liste_FilternModalOeffnen(title, instanz, liste) {
    const $neues_filtern_modal = Schnittstelle_DomNeuesModalInitialisiertZurueck(title, "FILTERN");
    Liste_FilternFormularInitialisieren($neues_filtern_modal.find(".filtern_formular"), instanz, liste);
    Schnittstelle_DomModalOeffnen($neues_filtern_modal);
}
