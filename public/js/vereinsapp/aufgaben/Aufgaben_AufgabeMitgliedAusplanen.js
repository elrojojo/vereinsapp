function Aufgaben_AufgabeMitgliedAusplanen(bestaetigung_einfordern, dom, title, aufgabe_id) {
    if (typeof aufgabe_id !== "undefined") aufgabe_id = Number(aufgabe_id);

    if (bestaetigung_einfordern) {
        let nachricht;
        if (Schnittstelle_VariableRausZurueck("mitglied_id", aufgabe_id, "aufgaben") == ICH["id"]) nachricht = "dich";
        else nachricht = Liste_ElementBeschriftungZurueck(Schnittstelle_VariableRausZurueck("mitglied_id", aufgabe_id, "aufgaben"), "mitglieder");
        Schnittstelle_DomBestaetigungEinfordern(
            "Willst du wirklich " +
                nachricht +
                " nicht mehr für die Aufgabe " +
                Liste_ElementBeschriftungZurueck(aufgabe_id, "aufgaben") +
                " einplanen?",
            title,
            "btn_aufgabe_mitglied_ausplanen",
            { aufgabe_id: aufgabe_id }
        );
    } else Aufgaben_AufgabeAendern(false, dom, { mitglied_id: null }, undefined, aufgabe_id);
}
