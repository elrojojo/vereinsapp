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
        const klasse_id = "btn_strafe_zuweisen";
        let modal_id;
        if (data.gegen_liste == "mitglieder") modal_id = "alle_mitglieder_modal";
        else if (data.gegen_liste == "strafkatalog") modal_id = "kompletter_strafkatalog_modal";

        $modal = LISTEN[data.gegen_liste].modals[modal_id].clone().removeClass("blanko invisible").addClass("modal");
        $modal.find(".modal-title").text(title);
        Schnittstelle_DomModalOeffnen($modal);
        Schnittstelle_EventVariableUpdDom(data.gegen_liste);

        $modal.find(".element").attr("data-gegen_liste", liste);
        $modal.find(".element").attr("data-gegen_element_id", element_id);
        $modal.find(".element").addClass(klasse_id);
        $modal.find(".element").addClass("bestaetigung_einfordern");
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
            titel: Liste_ElementBeschriftungZurueck(strafe_id, "strafkatalog"),
            wert: Schnittstelle_VariableRausZurueck("wert", strafe_id, "strafkatalog"),
            aktiv: 0,
            mitglied_id: mitglied_id,
            bemerkung: "",
        };

        dom.$formular = dom.$bestaetigung;
        Strafkatalog_KassenbucheintragErstellen(false, dom, data_kassenbucheintrag);
    }
}
