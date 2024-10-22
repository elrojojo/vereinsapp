LISTEN.aufgaben = {
    controller: "aufgaben",
    element: "aufgabe",
    beschriftung: [{ eigenschaft: "titel" }],
    verlinkte_listen: [],
    abhaengig_von: [],
    element_ergaenzen_aktion: Schnittstelle_EventElementErgaenzenAufgaben,
};

function Aufgaben_Init() {
    EVENT_VARIABLE_UPD_DOM_MODULE.push(Aufgaben_InitEventVariableUpdDom);

    // AUFGABE ERSTELLEN
    $(document).on("click", ".btn_aufgabe_erstellen", function () {
        Aufgaben_AufgabeErstellen(
            $(this).hasClass("formular_oeffnen"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal"), $formular: $(this).closest(".formular") },
            Liste_ElementFormularEigenschaftenWerteZurueck($(this).closest(".formular")),
            $(this).attr("data-title"),
            undefined
        );
    });

    // AUFGABE ÄNDERN
    $(document).on("click", ".btn_aufgabe_aendern", function () {
        Aufgaben_AufgabeAendern(
            $(this).hasClass("formular_oeffnen"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal"), $formular: $(this).closest(".formular") },
            Liste_ElementFormularEigenschaftenWerteZurueck($(this).closest(".formular")),
            $(this).attr("data-title"),
            $(this).attr("data-element_id")
        );
    });

    // AUFGABE DUPLIZIEREN
    $(document).on("click", ".btn_aufgabe_duplizieren", function () {
        Aufgaben_AufgabeErstellen(
            $(this).hasClass("formular_oeffnen"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal"), $formular: $(this).closest(".formular") },
            Liste_ElementFormularEigenschaftenWerteZurueck($(this).closest(".formular")),
            $(this).attr("data-title"),
            $(this).attr("data-element_id")
        );
    });

    // AUFGABE LÖSCHEN
    $(document).on("click", ".btn_aufgabe_loeschen", function () {
        Liste_ElementLoeschen(
            $(this).hasClass("bestaetigung_einfordern"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal") },
            { weiterleiten: $(this).attr("data-weiterleiten") },
            $(this).attr("data-title"),
            $(this).attr("data-element_id"),
            "aufgaben"
        );
    });

    // MITGLIED FÜR AUFGABE EINPLANEN
    $(document).on("click", ".btn_aufgabe_mitglied_einplanen", function () {
        Aufgaben_AufgabeMitgliedEinplanen(
            $(this).hasClass("auswahl_oeffnen"),
            $(this).hasClass("bestaetigung_einfordern"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal") },
            { mitglied_id: $(this).attr("data-element_id"), aufgabe_id: $(this).attr("data-gegen_element_id") },
            $(this).attr("data-title"),
            $(this).attr("data-aufgabe_id")
        );
    });
}

function Aufgaben_InitEventVariableUpdDom() {
    // AUFGABE AKTUALISIEREN
    $('.element[data-liste="aufgaben"]').each(function () {
        Aufgaben_AufgabeAktualisieren($(this));
    });
}
