LISTEN.rueckmeldungen = {
    controller: "termine",
    element: "rueckmeldung",
};

LISTEN.anwesenheiten = {
    controller: "termine",
    element: "anwesenheit",
};

LISTEN.termine = {
    controller: "termine",
    element: "termin",
};

PERSONENKREIS_BESCHRAENKEN = new Object();

$(document).ready(function () {
    {
        PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_sammlung =
            $(".personenkreis_beschraenken").find(".blanko").first();
        $(".personenkreis_beschraenken").empty();
        PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_element =
            PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_sammlung
                .find(".blanko")
                .first();
        PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_sammlung
            .find(".personenkreis_beschraenken_kind")
            .empty();

        PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_definition =
            new Object();
        $(".personenkreis_beschraenken_definitionen")
            .find(".blanko")
            .each(function () {
                const $blanko = $(this);
                PERSONENKREIS_BESCHRAENKEN.$blanko_personenkreis_beschraenken_definition[
                    $blanko.attr("data-typ")
                ] = $blanko;
            });
        $(".personenkreis_beschraenken_definitionen").empty();
    }

    //ELEMENTE UND PERSONENKREIS BESCHRÄNKEN IM DOM AKTUALISIEREN
    $(document).on("VAR_upd_DOM_termine", function () {
        $('.element[data-element="' + LISTEN.termine.element + '"]').each(
            function () {
                const $element = $(this);
                const element_id = Number($element.attr("data-element_id"));

                // FORMULAR MEINE RÜCKMELDUNG EIN-/AUSBLENDEN
                $element.find(".rueckmeldung").each(function () {
                    Termine_FormularMeineRueckmeldungEinAusblenden(
                        $(this),
                        $element,
                        "termine"
                    );
                });

                // MEINE RÜCKMELDUNG AKTUALISIEREN
                $element.find(".zusagen, .absagen").each(function () {
                    Termine_MeineRueckmeldungAktualisieren(
                        $(this),
                        element_id,
                        "termine"
                    );
                });
            }
        );

        // PERSONENKREIS BESCHRÄNKEN AKTUALISIEREN
        $(".personenkreis_beschraenken").each(function () {
            Termine_PersonenkreisBeschraenkenAktualisieren($(this), "termine");
        });
    });

    // FORMULAR (MODAL) ÖFFNEN
    $(".formular_personenkreis_beschraenken").on(
        "show.bs.modal",
        function (event) {
            Termine_FormularPersonenkreisBeschraenkenOeffnen(
                $(this),
                event,
                "termine"
            );
        }
    );

    // PERSONENKREIS BESCHRÄNKEN ERSTELLEN
    $(document).on(
        "click",
        ".btn_personenkreis_beschraenken_erstellen",
        function () {
            Termine_PersonenkreisBeschraenkenErstellen($(this), "termine");
        }
    );

    // PERSONENKREIS BESCHRÄNKEN LÖSCHEN
    $(document).on(
        "click",
        ".btn_personenkreis_beschraenken_loeschen",
        function () {
            Termine_PersonenkreisBeschraenkenLoeschen($(this), "termine");
        }
    );

    // PERSONENKREIS BESCHRÄNKEN ÄNDERN (VERKNÜPFUNG)
    $(document).on(
        "click",
        ".btn_personenkreis_beschraenken_aendern",
        function () {
            Termine_PersonenkreisBeschraenkenAendern($(this), "termine");
        }
    );
});
