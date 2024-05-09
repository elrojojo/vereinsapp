LISTEN.notenbank = {
    controller: "notenbank",
    element: "titel",
    beschriftung: [
        { eigenschaft: "titel_nr", prefix: "[", suffix: "]" },
        { eigenschaft: "titel", prefix: " " },
    ],
    verlinkte_listen: [],
    abhaengig_von: [],
    element_ergaenzen_aktion: Schnittstelle_EventElementErgaenzenNotenbank,
};

function Notenbank_Init() {
    // TITEL ERSTELLEN
    $(document).on("click", ".btn_titel_erstellen", function () {
        Notenbank_TitelErstellen(
            $(this).hasClass("formular_oeffnen"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.formular"),
            undefined
        );
    });

    // TITEL ÄNDERN
    $(document).on("click", ".btn_titel_aendern", function () {
        Notenbank_TitelAendern(
            $(this).hasClass("formular_oeffnen"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.formular"),
            Number($(this).attr("data-element_id"))
        );
    });

    // TITEL DUPLIZIEREN
    $(document).on("click", ".btn_titel_duplizieren", function () {
        Notenbank_TitelErstellen(
            $(this).hasClass("formular_oeffnen"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.formular"),
            Number($(this).attr("data-element_id"))
        );
    });

    // TITEL LÖSCHEN
    $(document).on("click", ".btn_titel_loeschen", function () {
        Liste_ElementLoeschen(
            $(this).hasClass("bestaetigung_einfordern"),
            $(this).attr("data-weiterleiten"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.bestaetigung"),
            Number($(this).attr("data-element_id")),
            "notenbank"
        );
    });
}
