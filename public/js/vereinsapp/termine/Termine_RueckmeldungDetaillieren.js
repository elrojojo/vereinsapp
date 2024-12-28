function Termine_RueckmeldungDetaillieren(formular_oeffnen, dom, data, title, rueckmeldung_id) {
    if (typeof rueckmeldung_id !== "undefined") rueckmeldung_id = Number(rueckmeldung_id);

    if (formular_oeffnen) {
        const $neues_modal = Schnittstelle_DomNeuesModalInitialisiertZurueck(title, "rueckmeldungen_bemerkung");
        Schnittstelle_DomModalOeffnen($neues_modal);
        Liste_ElementFormularInitialisieren($neues_modal.find(".formular"), undefined, rueckmeldung_id, "rueckmeldungen");
    } else Termine_RueckmeldungAendern(false, dom, data, title, rueckmeldung_id);
}
