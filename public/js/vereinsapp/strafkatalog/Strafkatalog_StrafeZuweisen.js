function Strafkatalog_StrafeZuweisen(auswahl_oeffnen, bestaetigung_einfordern, dom, data, title, element_id, liste) {
    if (typeof element_id !== "undefined") element_id = Number(element_id);

    if (typeof data.gegen_liste === "undefined" && liste == "strafkatalog") data.gegen_liste = "mitglieder";
    else if (typeof data.gegen_liste === "undefined" && liste == "mitglieder") data.gegen_liste = "strafkatalog";

    let strafe_id, mitglied_id;
    if (liste == "strafkatalog" && data.gegen_liste == "mitglieder") {
        strafe_id = element_id;
        mitglied_id = data.gegen_element_id;
    } else if (liste == "mitglieder" && data.gegen_liste == "strafkatalog") {
        mitglied_id = element_id;
        strafe_id = data.gegen_element_id;
    }

    if (auswahl_oeffnen) {
        const $neues_modal = Schnittstelle_DomNeuesModalInitialisiertZurueck(title, data.gegen_liste + "_auswahl");
        Schnittstelle_DomModalOeffnen($neues_modal);
        $neues_modal
            .find("#" + data.gegen_liste + "_auswahl")
            .attr("data-gegen_liste", liste)
            .attr("data-gegen_element_id", element_id);
        Hier muss das blanko_element der Liste in MODALS eingefügt werden!
        Schnittstelle_EventVariableUpdDom(data.gegen_liste);
    } else if (bestaetigung_einfordern) {
        if (dom.$modal.exists()) Schnittstelle_DomModalSchliessen(dom.$modal);

        Schnittstelle_DomBestaetigungEinfordern(
            "Willst du " +
                Liste_ElementBeschriftungZurueck(mitglied_id, "mitglieder") +
                " wirklich die Strafe " +
                Liste_ElementBeschriftungZurueck(strafe_id, "strafkatalog") +
                " zuweisen?",
            title,
            "btn_strafe_zuweisen",
            { liste: liste, element_id: element_id, gegen_liste: data.gegen_liste, gegen_element_id: data.gegen_element_id }
        );
    } else {
        const data_kassenbucheintrag = {
            titel: Schnittstelle_VariableRausZurueck("titel", strafe_id, "strafkatalog"),
            wert: Schnittstelle_VariableRausZurueck("wert", strafe_id, "strafkatalog"),
            aktiv: 0,
            mitglied_id: mitglied_id,
            bemerkung: "Strafe",
        };

        dom.$formular = dom.$bestaetigung;
        Strafkatalog_KassenbucheintragErstellen(false, dom, data_kassenbucheintrag);
    }
}
