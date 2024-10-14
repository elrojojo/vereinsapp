function Liste_SortierenModalOeffnen(title, instanz, liste) {
    const $neues_sortieren_modal = Schnittstelle_DomNeuesModalInitialisiertZurueck(title, "SORTIEREN");
    Liste_SortierenFormularInitialisieren($neues_sortieren_modal.find(".sortieren_formular"), instanz, liste);
    Schnittstelle_DomModalOeffnen($neues_sortieren_modal);
}
