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
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal"), $formular: $(this).closest(".formular") },
            Liste_ElementFormularEigenschaftenWerteZurueck($(this).closest(".formular")),
            $(this).attr("data-title"),
            undefined
        );
    });

    // MITGLIED ÄNDERN
    $(document).on("click", ".btn_mitglied_aendern", function () {
        Mitglieder_MitgliedAendern(
            $(this).hasClass("formular_oeffnen"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal"), $formular: $(this).closest(".formular") },
            Liste_ElementFormularEigenschaftenWerteZurueck($(this).closest(".formular")),
            $(this).attr("data-title"),
            $(this).attr("data-element_id")
        );
    });

    // MITGLIED DUPLIZIEREN
    $(document).on("click", ".btn_mitglied_duplizieren", function () {
        Mitglieder_MitgliedErstellen(
            $(this).hasClass("formular_oeffnen"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal"), $formular: $(this).closest(".formular") },
            Liste_ElementFormularEigenschaftenWerteZurueck($(this).closest(".formular")),
            $(this).attr("data-title"),
            $(this).attr("data-element_id")
        );
    });

    // MITGLIED LÖSCHEN
    $(document).on("click", ".btn_mitglied_loeschen", function () {
        Liste_ElementLoeschen(
            $(this).hasClass("bestaetigung_einfordern"),
            { $btn_ausloesend: $(this), $bestaetigung: $(this).closest(".bestaetigung") },
            { weiterleiten: $(this).attr("data-weiterleiten") },
            $(this).attr("data-title"),
            $(this).attr("data-element_id"),
            "mitglieder"
        );
    });

    // PASSWORT ÄNDERN
    $(document).on("click", ".btn_mitglied_passwort_aendern", function () {
        Mitglieder_PasswortAendern(
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal"), $formular: $(this).closest(".formular") },
            Liste_ElementFormularEigenschaftenWerteZurueck($(this).closest(".formular")),
            $(this).attr("data-element_id")
        );
    });

    // PASSWORT FESTLEGEN
    $(document).on("click", ".btn_mitglied_passwort_festlegen", function () {
        Mitglieder_PasswortFestlegen(
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal"), $formular: $(this).closest(".formular") },
            Liste_ElementFormularEigenschaftenWerteZurueck($(this).closest(".formular")),
            $(this).attr("data-element_id")
        );
    });

    // EINMAL-LINK ANZEIGEN
    $(document).on("click", ".btn_mitglied_einmal_link_anzeigen", function () {
        Mitglieder_EinmalLinkErstellen(
            $(this).hasClass("formular_oeffnen"),
            $(this).hasClass("bestaetigung_einfordern"),
            {
                $btn_ausloesend: $(this),
                $modal: $(this).closest(".modal"),
                $formular: $(this).closest(".formular"),
                $einmal_link: $(this).closest(".formular").find(".einmal_link"),
                $btn_dismiss: $(this).closest(".formular").find('.btn.invisible[data-bs-dismiss="modal"]'),
            },
            {},
            $(this).attr("data-title"),
            $(this).attr("data-element_id")
        );
    });

    // EINMAL-LINK PER EMAIL VERSCHICKEN
    $(document).on("click", ".btn_mitglied_einmal_link_email", function () {
        Mitglieder_EinmalLinkErstellen(
            $(this).hasClass("formular_oeffnen"),
            $(this).hasClass("bestaetigung_einfordern"),
            { $btn_ausloesend: $(this), $bestaetigung: $(this).closest(".bestaetigung") },
            { email: true },
            $(this).attr("data-title"),
            $(this).attr("data-element_id")
        );
    });
}
