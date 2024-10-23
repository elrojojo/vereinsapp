function Aufgaben_AufgabeMitgliedAusplanen(bestaetigung_einfordern, dom, title, aufgabe_id) {
    if (typeof aufgabe_id !== "undefined") aufgabe_id = Number(aufgabe_id);

    let mitglied;
    if (Schnittstelle_VariableRausZurueck("mitglied_id_eingeplant", aufgabe_id, "aufgaben") == ICH["id"]) mitglied = "dich";
    else
        mitglied = Liste_ElementBeschriftungZurueck(
            Schnittstelle_VariableRausZurueck("mitglied_id_eingeplant", aufgabe_id, "aufgaben"),
            "mitglieder"
        );

    if (bestaetigung_einfordern)
        Schnittstelle_DomBestaetigungEinfordern(
            "Willst du wirklich " +
                mitglied +
                " nicht mehr für die Aufgabe " +
                Liste_ElementBeschriftungZurueck(aufgabe_id, "aufgaben") +
                " einplanen?",
            title,
            "btn_aufgabe_mitglied_ausplanen",
            { aufgabe_id: aufgabe_id, element_id: null }
        );
    else Aufgaben_AufgabeAendern(false, dom, { mitglied_id_eingeplant: null }, undefined, aufgabe_id);
}
