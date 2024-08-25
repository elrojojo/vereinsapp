function Strafkatalog_StrafeZuweisen(
    auswahl_oeffnen,
    bestaetigung_einfordern,
    title,
    $btn_ausloesend,
    gegen_element_id,
    gegen_liste,
    element_id,
    liste
) {
    if (typeof gegen_liste === "undefined" && liste == "strafkatalog") gegen_liste = "mitglieder";
    else if (typeof gegen_liste === "undefined" && liste == "mitglieder") gegen_liste = "strafkatalog";

    if (auswahl_oeffnen) {
        let aktion;
        if (gegen_liste == "mitglieder") aktion = "alle_mitglieder_modal";
        else aktion = "kompletter_strafkatalog_modal";
        $modal = LISTEN[gegen_liste].modals[aktion].clone().removeClass("blanko invisible").addClass("modal");
        $modal.find(".modal-title").text(title);
        Schnittstelle_DomModalOeffnen($modal);
        Schnittstelle_EventVariableUpdDom(gegen_liste);

        $modal.find(".element").attr("data-gegen_liste", liste);
        $modal.find(".element").attr("data-gegen_element_id", element_id);
        $modal.find(".element").addClass("btn_strafe_zuweisen");
        $modal.find(".element").addClass("bestaetigung_einfordern");
        Schnittstelle_EventVariableUpdDom(gegen_liste);
    } else if (bestaetigung_einfordern)
        Schnittstelle_DomBestaetigungEinfordern(
            "Willst du " +
                Liste_ElementBeschriftungZurueck(element_id, liste) +
                " wirklich " +
                Liste_ElementBeschriftungZurueck(gegen_element_id, gegen_liste) +
                " zuweisen?",
            title,
            "btn_strafe_zuweisen",
            { liste: liste, element_id: element_id, gegen_liste: gegen_liste, gegen_element_id: gegen_element_id }
        );
    else {
        console.log(
            Liste_ElementBeschriftungZurueck(element_id, liste) +
                " wird " +
                Liste_ElementBeschriftungZurueck(gegen_element_id, gegen_liste) +
                " zugewiesen"
        );
    }
}
