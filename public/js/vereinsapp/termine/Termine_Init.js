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
    verlinkte_listen: [],
    abhaengig_von: ["rueckmeldungen"],
    element_ergaenzen_aktion: Schnittstelle_EventElementErgaenzenTermine,
};

PERSONENKREIS_BESCHRAENKEN = new Object();

function Termine_Init() {
    PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_sammlung = $(".personenkreis_beschraenken").find(".blanko").first();
    $(".personenkreis_beschraenken").empty();

    PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_element = PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_sammlung
        .find(".blanko")
        .first();

    PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_sammlung.find(".personenkreis_beschraenken_kind").empty();

    PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_definition = new Object();

    $(".personenkreis_beschraenken_definitionen")
        .find(".blanko")
        .each(function () {
            const $blanko = $(this);
            PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_definition[$blanko.attr("data-typ")] = $blanko;
        });

    $(".personenkreis_beschraenken_definitionen").empty();

    // FORMULAR (MODAL) ÖFFNEN
    $(".formular_personenkreis_beschraenken").on("show.bs.modal", function (event) {
        Termine_FormularPersonenkreisBeschraenkenOeffnen($(this), event, "termine");
    });

    // PERSONENKREIS BESCHRÄNKEN ERSTELLEN
    $(document).on("click", ".btn_personenkreis_beschraenken_erstellen", function () {
        Termine_PersonenkreisBeschraenkenErstellen($(this), "termine");
    });

    // PERSONENKREIS BESCHRÄNKEN LÖSCHEN
    $(document).on("click", ".btn_personenkreis_beschraenken_loeschen", function () {
        Termine_PersonenkreisBeschraenkenLoeschen($(this), "termine");
    });

    // PERSONENKREIS BESCHRÄNKEN ÄNDERN (VERKNÜPFUNG)
    $(document).on("click", ".btn_personenkreis_beschraenken_aendern", function () {
        Termine_PersonenkreisBeschraenkenAendern($(this), "termine");
    });
}

/* TODO
Abwesenheit in Rückmeldungen berücksichtigen

*/
