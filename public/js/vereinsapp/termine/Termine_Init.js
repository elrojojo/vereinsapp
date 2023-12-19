G.LISTEN.rueckmeldungen = {
    $blanko_element: new Object(),
    instanz: new Object(),
    controller: "termine",
    element: "rueckmeldung",
    verlinkte_listen: ["termine", "mitglieder"],
};

G.LISTEN.anwesenheiten = {
    $blanko_element: new Object(),
    instanz: new Object(),
    controller: "termine",
    element: "anwesenheit",
    verlinkte_listen: ["termine", "mitglieder"],
};

G.LISTEN.termine = {
    $blanko_element: new Object(),
    instanz: new Object(),
    controller: "termine",
    element: "termin",
    verlinkte_listen: [],
    abhaengig_von: ["rueckmeldungen"],
    element_ergaenzen_aktion: Schnittstelle_EventElementErgaenzenTermine,
};

/* TODO
Abwesenheit in Rückmeldungen berücksichtigen
Personenkreis beschränken
Bugfix Anwesenheit kontrollieren

*/
