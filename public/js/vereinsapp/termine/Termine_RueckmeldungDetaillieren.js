function Termine_RueckmeldungDetaillieren(formular_oeffnen, dom, data, title, rueckmeldung_id) {
    if (typeof rueckmeldung_id !== "undefined") rueckmeldung_id = Number(rueckmeldung_id);

    if (formular_oeffnen)
        Schnittstelle_DomModalOeffnen(
            Liste_ElementFormularInitialisiertZurueck("bemerkung", "rueckmeldungen", {
                title: title,
                element_id: rueckmeldung_id,
            })
        );
    else Termine_RueckmeldungAendern(false, dom, data, title, rueckmeldung_id);
}
