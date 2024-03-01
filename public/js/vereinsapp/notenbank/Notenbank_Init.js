G.LISTEN.notenbank = {
    controller: "notenbank",
    element: "titel",
    beschriftung: [
        { eigenschaft: "titel_nr", prefix: "[", prefix: "]" },
        { eigenschaft: "titel", prefix: " " },
    ],
    verlinkte_listen: [],
    abhaengig_von: [],
    element_ergaenzen_aktion: Schnittstelle_EventElementErgaenzenNotenbank,
};
