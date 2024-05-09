LISTEN.verfuegbare_rechte = {
    controller: "mitglieder",
    element: "verfuegbares_recht",
};

LISTEN.vergebene_rechte = {
    controller: "mitglieder",
    element: "vergebenes_recht",
    verlinkte_listen: ["mitglieder", "verfuegbare_rechte"],
};

LISTEN.mitglieder = {
    controller: "mitglieder",
    element: "mitglied",
    beschriftung: [{ eigenschaft: "vorname" }, { eigenschaft: "nachname", prefix: " " }],
    verlinkte_listen: [],
    abhaengig_von: [],
    element_ergaenzen_aktion: Schnittstelle_EventElementErgaenzenMitglieder,
};

function Mitglieder_Init() {
    // MITGLIED ERSTELLEN
    $(document).on("click", ".btn_mitglied_erstellen", function () {
        Mitglieder_MitgliedErstellen(
            $(this).hasClass("formular_oeffnen"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.formular"),
            undefined
        );
    });

    // MITGLIED ÄNDERN
    $(document).on("click", ".btn_mitglied_aendern", function () {
        Mitglieder_MitgliedAendern(
            $(this).hasClass("formular_oeffnen"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.formular"),
            Number($(this).attr("data-element_id"))
        );
    });

    // MITGLIED DUPLIZIEREN
    $(document).on("click", ".btn_mitglied_duplizieren", function () {
        Mitglieder_MitgliedErstellen(
            $(this).hasClass("formular_oeffnen"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.formular"),
            Number($(this).attr("data-element_id"))
        );
    });

    // MITGLIED LÖSCHEN
    $(document).on("click", ".btn_mitglied_loeschen", function () {
        Liste_ElementLoeschen(
            $(this).hasClass("bestaetigung_einfordern"),
            $(this).attr("data-weiterleiten"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.bestaetigung"),
            Number($(this).attr("data-element_id")),
            "mitglieder"
        );
    });

    // PASSWORT ÄNDERN
    $(document).on("click", ".btn_mitglied_passwort_aendern", function () {
        Mitglieder_PasswortAendern($(this), $(this).closest(".formular"), Number($(this).attr("data-element_id")));
    });

    // PASSWORT FESTLEGEN
    $(document).on("click", ".btn_mitglied_passwort_festlegen", function () {
        Mitglieder_PasswortFestlegen($(this), $(this).closest(".modal.formular"), Number($(this).attr("data-element_id")));
    });

    // EINMAL-LINK ANZEIGEN
    $(document).on("click", ".btn_mitglied_einmal_link_anzeigen", function () {
        Mitglieder_EinmalLinkAnzeigen(
            $(this).hasClass("formular_oeffnen"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.formular"),
            Number($(this).attr("data-element_id"))
        );
    });

    // EINMAL-LINK PER EMAIL VERSCHICKEN
    $(document).on("click", ".btn_mitglied_einmal_link_email", function () {
        Mitglieder_EinmalLinkEmail(
            $(this).hasClass("bestaetigung_einfordern"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.bestaetigung"),
            Number($(this).attr("data-element_id"))
        );
    });
}
