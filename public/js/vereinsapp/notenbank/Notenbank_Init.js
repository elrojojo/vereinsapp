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
        Notenbank_TitelErstellen($(this));
    });

    // TITEL ÄNDERN
    $(document).on("click", ".btn_titel_aendern", function () {
        Notenbank_TitelAendern($(this));
    });

    // TITEL DUPLIZIEREN
    $(document).on("click", ".btn_titel_duplizieren", function () {
        Notenbank_TitelErstellen($(this));
    });

    // TITEL LÖSCHEN
    $(document).on("click", ".btn_titel_loeschen", function () {
        Liste_ElementLoeschen(
            {
                bestaetigung_einfordern: $(this).hasClass("bestaetigung_einfordern"),
                weiterleiten: $(this).attr("data-weiterleiten"),
                title: $(this).attr("data-title"),
                $btn_ausloesend: $(this),
                $modal_ausloesend: $(this).closest(".modal.bestaetigung"),
            },
            Number($(this).attr("data-element_id")),
            "notenbank"
        );
    });
}
