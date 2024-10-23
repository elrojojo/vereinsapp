LISTEN.kassenbuch = {
    controller: "strafkatalog",
    element: "kassenbucheintrag",
    beschriftung: [{ eigenschaft: "titel" }, { eigenschaft: "wert", prefix: " (", suffix: ")" }],
    verlinkte_listen: [],
    abhaengig_von: [],
    element_ergaenzen_aktion: Schnittstelle_EventElementErgaenzenKassenbuch,
};

LISTEN.strafkatalog = {
    controller: "strafkatalog",
    element: "strafe",
    beschriftung: [{ eigenschaft: "titel" }, { eigenschaft: "wert", prefix: " (", suffix: ")" }],
    verlinkte_listen: [],
    abhaengig_von: [],
    element_ergaenzen_aktion: Schnittstelle_EventElementErgaenzenStrafkatalog,
};

function Strafkatalog_Init() {
    // STRAFE ERSTELLEN
    $(document).on("click", ".btn_strafe_erstellen", function () {
        Strafkatalog_StrafeErstellen(
            $(this).hasClass("formular_oeffnen"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal"), $formular: $(this).closest(".formular") },
            Liste_ElementFormularEigenschaftenWerteZurueck($(this).closest(".formular")),
            $(this).attr("data-title"),
            undefined
        );
    });

    // STRAFE ÄNDERN
    $(document).on("click", ".btn_strafe_aendern", function () {
        Strafkatalog_StrafeAendern(
            $(this).hasClass("formular_oeffnen"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal"), $formular: $(this).closest(".formular") },
            Liste_ElementFormularEigenschaftenWerteZurueck($(this).closest(".formular")),
            $(this).attr("data-title"),
            $(this).attr("data-element_id")
        );
    });

    // STRAFE DUPLIZIEREN
    $(document).on("click", ".btn_strafe_duplizieren", function () {
        Strafkatalog_StrafeErstellen(
            $(this).hasClass("formular_oeffnen"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal"), $formular: $(this).closest(".formular") },
            Liste_ElementFormularEigenschaftenWerteZurueck($(this).closest(".formular")),
            $(this).attr("data-title"),
            $(this).attr("data-element_id")
        );
    });

    // STRAFE LÖSCHEN
    $(document).on("click", ".btn_strafe_loeschen", function () {
        Liste_ElementLoeschen(
            $(this).hasClass("bestaetigung_einfordern"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal") },
            { weiterleiten: $(this).attr("data-weiterleiten") },
            $(this).attr("data-title"),
            $(this).attr("data-element_id"),
            "strafkatalog"
        );
    });

    // STRAFE ZUWEISEN
    $(document).on("click", ".btn_strafe_zuweisen", function () {
        Strafkatalog_StrafeZuweisen(
            $(this).hasClass("auswahl_oeffnen"),
            $(this).hasClass("bestaetigung_einfordern"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal") },
            { gegen_element_id: $(this).attr("data-gegen_element_id"), gegen_liste: $(this).attr("data-gegen_liste") },
            $(this).attr("data-title"),
            $(this).attr("data-element_id"),
            $(this).attr("data-liste")
        );
    });

    // KASSENBUCHEINTRAG ERSTELLEN
    $(document).on("click", ".btn_kassenbucheintrag_erstellen", function () {
        Strafkatalog_KassenbucheintragErstellen(
            $(this).hasClass("formular_oeffnen"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal"), $formular: $(this).closest(".formular") },
            Liste_ElementFormularEigenschaftenWerteZurueck($(this).closest(".formular")),
            $(this).attr("data-title"),
            undefined
        );
    });

    // KASSENBUCHEINTRAG ÄNDERN
    $(document).on("click", ".btn_kassenbucheintrag_aendern", function () {
        Strafkatalog_KassenbucheintragAendern(
            $(this).hasClass("formular_oeffnen"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal"), $formular: $(this).closest(".formular") },
            Liste_ElementFormularEigenschaftenWerteZurueck($(this).closest(".formular")),
            $(this).attr("data-title"),
            $(this).attr("data-element_id")
        );
    });

    // KASSENBUCHEINTRAG DUPLIZIEREN
    $(document).on("click", ".btn_kassenbucheintrag_duplizieren", function () {
        Strafkatalog_KassenbucheintragErstellen(
            $(this).hasClass("formular_oeffnen"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal"), $formular: $(this).closest(".formular") },
            Liste_ElementFormularEigenschaftenWerteZurueck($(this).closest(".formular")),
            $(this).attr("data-title"),
            $(this).attr("data-element_id")
        );
    });

    // KASSENBUCHEINTRAG (DE)AKTIVIEREN
    $(document).on("click", ".btn_kassenbucheintrag_de_aktivieren", function () {
        Strafkatalog_KassenbucheintragDeAktivieren(
            $(this).hasClass("bestaetigung_einfordern"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal") },
            $(this).attr("data-title"),
            $(this).attr("data-element_id")
        );
    });

    // KASSENBUCHEINTRAG LÖSCHEN
    $(document).on("click", ".btn_kassenbucheintrag_loeschen", function () {
        Liste_ElementLoeschen(
            $(this).hasClass("bestaetigung_einfordern"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal") },
            { weiterleiten: $(this).attr("data-weiterleiten") },
            $(this).attr("data-title"),
            $(this).attr("data-element_id"),
            "kassenbuch"
        );
    });
}
