G.LISTEN.rueckmeldungen = {
    controller: "termine",
    element: "rueckmeldung",
    verlinkte_listen: ["termine", "mitglieder"],
};

G.LISTEN.anwesenheiten = {
    controller: "termine",
    element: "anwesenheit",
    verlinkte_listen: ["termine", "mitglieder"],
};

G.LISTEN.termine = {
    controller: "termine",
    element: "termin",
    beschriftung: [{ eigenschaft: "titel" }, { eigenschaft: "titel", prefix: " (", suffix: ")" }],
    verlinkte_listen: [],
    abhaengig_von: ["rueckmeldungen"],
    element_ergaenzen_aktion: Schnittstelle_EventElementErgaenzenTermine,
};
