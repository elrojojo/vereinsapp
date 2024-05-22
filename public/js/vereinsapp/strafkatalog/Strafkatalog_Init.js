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
}
