function Strafkatalog_StrafeZuweisen(formular_oeffnen, bestaetigung_einfordern, title, $btn_ausloesend, $formular, strafe_id, mitglied_id) {
    if (formular_oeffnen) {
        const $modal = LISTEN.strafkatalog.modals["alle_mitglieder_modal"].clone().removeClass("blanko invisible").addClass("modal");
        $modal.find(".modal-title").text(title);
        Schnittstelle_DomModalOeffnen($modal);
        Schnittstelle_EventVariableUpdDom("mitglieder");
    } else if (bestaetigung_einfordern)
        Schnittstelle_DomBestaetigungEinfordern(
            "Willst du " +
                Liste_ElementBeschriftungZurueck(mitglied_id, "mitglieder") +
                " wirklich die Strafe " +
                Liste_ElementBeschriftungZurueck(strafe_id, "strafkatalog") +
                " zuweisen?",
            title,
            "btn_strafe_zuweisen",
            { liste: "mitglieder", element_id: mitglied_id }
        );
    else {
        console.log("ab geeehts!");
    }
}
