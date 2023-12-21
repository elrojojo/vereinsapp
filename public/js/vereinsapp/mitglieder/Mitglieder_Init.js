G.LISTEN.verfuegbare_rechte = {
    controller: "mitglieder",
    element: "verfuegbares_recht",
};

G.LISTEN.vergebene_rechte = {
    controller: "mitglieder",
    element: "vergebenes_recht",
    verlinkte_listen: ["mitglieder", "verfuegbare_rechte"],
};

G.LISTEN.abwesenheiten = {
    controller: "mitglieder",
    element: "abwesenheit",
    verlinkte_listen: ["mitglieder"],
};

G.LISTEN.mitglieder = {
    controller: "mitglieder",
    element: "mitglied",
    verlinkte_listen: [],
    abhaengig_von: ["abwesenheiten"],
    element_ergaenzen_aktion: Schnittstelle_EventElementErgaenzenMitglieder,
};

/* TODO
Das eigene Profil editierbar machen, auch wenn man kein Recht zur Verwaltung der Mitglieder hat
Das Recht zur Vergabe von Rechten aenderbar machen, wenn man das Recht für Globale Einstellungen hat
Registerführer einführen

*/
