function Aufgaben_AufgabeMitgliedEinplanen(auswahl_oeffnen, bestaetigung_einfordern, dom, data, title, aufgabe_id) {
    if (typeof aufgabe_id !== "undefined") aufgabe_id = Number(aufgabe_id);
    else if ("aufgabe_id" in data && typeof data.aufgabe_id !== "undefined") aufgabe_id = Number(data.aufgabe_id);

    let mitglied_id;
    if ("mitglied_id" in data && typeof data.mitglied_id !== "undefined") mitglied_id = Number(data.mitglied_id);

    const mitglied_id_eingeplant = Schnittstelle_VariableRausZurueck("mitglied_id_eingeplant", aufgabe_id, "aufgaben");
    if (auswahl_oeffnen) {
        const $neues_modal = Schnittstelle_DomNeuesModalInitialisiertZurueck(title, "mitglieder_auswahl");
        $neues_modal.find("#mitglieder_auswahl.liste").attr("data-gegen_element_id", aufgabe_id);
        Schnittstelle_DomModalOeffnen($neues_modal);
        Schnittstelle_EventVariableUpdDom("mitglieder");
    } else if (bestaetigung_einfordern)
        if (mitglied_id_eingeplant === null)
            Schnittstelle_DomBestaetigungEinfordern(
                "Willst du wirklich dich für die Aufgabe " + Liste_ElementBeschriftungZurueck(aufgabe_id, "aufgaben") + " einplanen?",
                "Mich für die Aufgabe einplanen",
                "btn_aufgabe_mitglied_einplanen",
                { gegen_element_id: aufgabe_id, element_id: ICH["id"] }
            );
        else
            Schnittstelle_DomBestaetigungEinfordern(
                "Willst du wirklich dich nicht mehr für die Aufgabe " + Liste_ElementBeschriftungZurueck(aufgabe_id, "aufgaben") + " einplanen?",
                "Mich nicht mehr für die Aufgabe einplanen",
                "btn_aufgabe_mitglied_einplanen",
                { gegen_element_id: aufgabe_id }
            );
    else Aufgaben_AufgabeAendern(false, dom, { mitglied_id_eingeplant: mitglied_id }, undefined, aufgabe_id);
}
