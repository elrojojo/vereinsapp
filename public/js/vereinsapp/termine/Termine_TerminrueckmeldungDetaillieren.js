function Termine_TerminrueckmeldungDetaillieren(formular_oeffnen, dom, data, title, terminrueckmeldung_id) {
    if (typeof terminrueckmeldung_id !== "undefined") terminrueckmeldung_id = Number(terminrueckmeldung_id);

    if (formular_oeffnen) {
        const $neues_modal = Schnittstelle_DomNeuesModalInitialisiertZurueck(title, "terminrueckmeldungen_bemerkung");
        Schnittstelle_DomModalOeffnen($neues_modal);
        Liste_ElementFormularInitialisieren($neues_modal.find(".formular"), undefined, terminrueckmeldung_id, "terminrueckmeldungen");
    } else Termine_TerminrueckmeldungAendern(false, dom, data, title, terminrueckmeldung_id);
}
