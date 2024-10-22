function Aufgaben_AufgabeZuweisen(auswahl_oeffnen, bestaetigung_einfordern, dom, data, title, element_id, liste) {
    if (typeof element_id !== "undefined") element_id = Number(element_id);

    if (typeof data.gegen_liste === "undefined" && liste == "aufgaben") data.gegen_liste = "mitglieder";
    else if (typeof data.gegen_liste === "undefined" && liste == "mitglieder") data.gegen_liste = "aufgaben";

    let aufgabe_id, mitglied_id;
    if (liste == "aufgaben" && data.gegen_liste == "mitglieder") {
        aufgabe_id = element_id;
        mitglied_id = data.gegen_element_id;
    } else if (liste == "mitglieder" && data.gegen_liste == "aufgaben") {
        mitglied_id = element_id;
        aufgabe_id = data.gegen_element_id;
    }

    if (typeof mitglied_id === "undefined") mitglied_id = ICH["id"];

    if (auswahl_oeffnen) {
        const $neues_modal = Schnittstelle_DomNeuesModalInitialisiertZurueck(title, data.gegen_liste + "_auswahl");
        Schnittstelle_DomModalOeffnen($neues_modal);
        $neues_modal
            .find("#" + data.gegen_liste + "_auswahl.liste")
            .attr("data-gegen_liste", liste)
            .attr("data-gegen_element_id", element_id);
        Schnittstelle_EventVariableUpdDom(data.gegen_liste);
    } else if (bestaetigung_einfordern)
        Schnittstelle_DomBestaetigungEinfordern(
            "Willst du wirklich dir die Aufgabe " + Liste_ElementBeschriftungZurueck(aufgabe_id, "aufgaben") + " zuweisen?",
            title,
            "btn_aufgabe_zuweisen",
            { liste: liste, element_id: element_id, gegen_liste: data.gegen_liste, gegen_element_id: data.gegen_element_id }
        );
    else Aufgaben_AufgabeAendern(false, dom, { mitglied_id_eingeplant: mitglied_id }, undefined, aufgabe_id);
}
