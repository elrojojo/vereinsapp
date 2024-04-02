G.LISTEN.notenbank = {
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
        Liste_ElementLoeschen($(this));
    });
}
