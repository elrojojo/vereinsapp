function Aufgaben_AufgabeZuweisen(auswahl_oeffnen, dom, data, title, element_id, liste) {
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

    if (auswahl_oeffnen) {
        const $neues_modal = Schnittstelle_DomNeuesModalInitialisiertZurueck(title, data.gegen_liste + "_auswahl");
        Schnittstelle_DomModalOeffnen($neues_modal);
        $neues_modal
            .find("#" + data.gegen_liste + "_auswahl")
            .attr("data-gegen_liste", liste)
            .attr("data-gegen_element_id", element_id);
        Schnittstelle_EventVariableUpdDom(data.gegen_liste);
    } else Aufgaben_AufgabeAendern(false, { $btn_ausloesend: $(), $modal: dom.$modal }, { mitglied_id_geplant: mitglied_id }, undefined, aufgabe_id);
}
