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
    beschriftung: [{ eigenschaft: "titel" }, { eigenschaft: "start", prefix: " (", suffix: ")" }],
    verlinkte_listen: [],
    abhaengig_von: ["rueckmeldungen"],
    element_ergaenzen_aktion: Schnittstelle_EventElementErgaenzenTermine,
};

function Termine_Init() {
    // TERMIN ERSTELLEN
    $(document).on("click", ".btn_termin_erstellen", function () {
        Liste_ElementErstellen($(this));
    });

    // TERMIN ÄNDERN
    $(document).on("click", ".btn_termin_aendern", function () {
        Liste_ElementErstellen($(this));
    });

    // TERMIN DUPLIZIEREN
    $(document).on("click", ".btn_termin_duplizieren", function () {
        Liste_ElementErstellen($(this));
    });

    // TERMIN LÖSCHEN
    // $(document).on("click", ".btn_termin_loeschen", function () {
    //     Liste_ElementErstellen($(this));
    // });

    // RÜCKMELDUNG ERSTELLEN
    $(document).on("click", ".btn_rueckmeldung_erstellen", function () {
        Liste_ElementErstellen($(this));
    });

    // RÜCKMELDUNG ÄNDERN
    $(document).on("click", ".btn_rueckmeldung_aendern", function () {
        Liste_ElementErstellen($(this));
    });

    // RÜCKMELDUNG DETAILLIEREN
    $(document).on("click", ".btn_rueckmeldung_detaillieren", function () {
        Liste_ElementErstellen($(this));
    });

    // RÜCKMELDUNG LÖSCHEN
    // $(document).on("click", ".btn_rueckmeldung_loeschen", function () {
    //     Liste_ElementErstellen($(this));
    // });

    // ANWESENHEIT ERSTELLEN
    $(document).on("click", ".btn_anwesenheit_erstellen", function () {
        Liste_ElementErstellen($(this));
    });

    // ANWESENHEIT ÄNDERN
    $(document).on("click", ".btn_anwesenheit_aendern", function () {
        Liste_ElementErstellen($(this));
    });

    // ANWESENHEIT DUPLIZIEREN
    $(document).on("click", ".btn_anwesenheit_duplizieren", function () {
        Liste_ElementErstellen($(this));
    });

    // ANWESENHEIT LÖSCHEN
    // $(document).on("click", ".btn_anwesenheit_loeschen", function () {
    //     Liste_ElementErstellen($(this));
    // });
}
