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
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.formular"),
            undefined
        );
    });

    // STRAFE ÄNDERN
    $(document).on("click", ".btn_strafe_aendern", function () {
        Strafkatalog_StrafeAendern(
            $(this).hasClass("formular_oeffnen"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.formular"),
            Number($(this).attr("data-element_id"))
        );
    });

    // STRAFE DUPLIZIEREN
    $(document).on("click", ".btn_strafe_duplizieren", function () {
        Strafkatalog_StrafeErstellen(
            $(this).hasClass("formular_oeffnen"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.formular"),
            Number($(this).attr("data-element_id"))
        );
    });

    // STRAFE LÖSCHEN
    $(document).on("click", ".btn_strafe_loeschen", function () {
        Liste_ElementLoeschen(
            $(this).hasClass("bestaetigung_einfordern"),
            $(this).attr("data-weiterleiten"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.bestaetigung"),
            Number($(this).attr("data-element_id")),
            "strafkatalog"
        );
    });

    // STRAFE ZUWEISEN
    $(document).on("click", ".btn_strafe_zuweisen", function () {
        Strafkatalog_StrafeZuweisen(
            $(this).hasClass("formular_oeffnen"),
            $(this).hasClass("bestaetigung_einfordern"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.formular"),
            Number($(this).attr("data-element_id")),
            Number($(this).attr("data-element_id"))
        );
    });

    // KASSENBUCHEINTRAG ERSTELLEN
    $(document).on("click", ".btn_kassenbucheintrag_erstellen", function () {
        Strafkatalog_KassenbucheintragErstellen(
            $(this).hasClass("formular_oeffnen"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.formular"),
            undefined
        );
    });

    // KASSENBUCHEINTRAG ÄNDERN
    $(document).on("click", ".btn_kassenbucheintrag_aendern", function () {
        Strafkatalog_KassenbucheintragAendern(
            $(this).hasClass("formular_oeffnen"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.formular"),
            Number($(this).attr("data-element_id"))
        );
    });

    // KASSENBUCHEINTRAG DUPLIZIEREN
    $(document).on("click", ".btn_kassenbucheintrag_duplizieren", function () {
        Strafkatalog_KassenbucheintragErstellen(
            $(this).hasClass("formular_oeffnen"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.formular"),
            Number($(this).attr("data-element_id"))
        );
    });

    // KASSENBUCHEINTRAG LÖSCHEN
    $(document).on("click", ".btn_kassenbucheintrag_loeschen", function () {
        Liste_ElementLoeschen(
            $(this).hasClass("bestaetigung_einfordern"),
            $(this).attr("data-weiterleiten"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.bestaetigung"),
            Number($(this).attr("data-element_id")),
            "kassenbuch"
        );
    });
}
