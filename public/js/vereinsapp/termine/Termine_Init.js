LISTEN.rueckmeldungen = {
    controller: "termine",
    element: "rueckmeldung",
    beschriftung: [{ eigenschaft: "id", prefix: "die Rückmeldung " }],
    verlinkte_listen: ["termine", "mitglieder"],
};

LISTEN.temp_check_doppelte_rueckmeldungen = {
    controller: "termine",
    element: "doppelte_rueckmeldung",
    beschriftung: [{ eigenschaft: "id", prefix: "die doppelte Rückmeldung " }],
    verlinkte_listen: ["termine", "mitglieder"],
};

LISTEN.anwesenheiten = {
    controller: "termine",
    element: "anwesenheit",
    verlinkte_listen: ["termine", "mitglieder"],
};

LISTEN.termine = {
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
        Termine_TerminErstellen($(this));
    });

    // TERMIN ÄNDERN
    $(document).on("click", ".btn_termin_aendern", function () {
        Termine_TerminAendern($(this));
    });

    // TERMIN DUPLIZIEREN
    $(document).on("click", ".btn_termin_duplizieren", function () {
        Termine_TerminErstellen($(this));
    });

    // TERMIN LÖSCHEN
    $(document).on("click", ".btn_termin_loeschen", function () {
        Liste_ElementLoeschen(
            $(this).hasClass("bestaetigung_einfordern"),
            $(this).attr("data-weiterleiten"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.bestaetigung"),
            Number($(this).attr("data-element_id")),
            "termine"
        );
    });

    // RÜCKMELDUNG ERSTELLEN
    $(document).on("click", ".btn_rueckmeldung_erstellen", function () {
        Termine_RueckmeldungErstellen($(this));
    });

    // RÜCKMELDUNG ÄNDERN
    $(document).on("click", ".btn_rueckmeldung_aendern", function () {
        Termine_RueckmeldungAendern($(this));
    });

    // RÜCKMELDUNG DETAILLIEREN
    $(document).on("click", ".btn_rueckmeldung_detaillieren", function () {
        Termine_RueckmeldungDetaillieren($(this));
    });

    // RÜCKMELDUNG LÖSCHEN
    $(document).on("click", ".btn_rueckmeldung_loeschen", function () {
        Liste_ElementLoeschen(
            $(this).hasClass("bestaetigung_einfordern"),
            $(this).attr("data-weiterleiten"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.bestaetigung"),
            Number($(this).attr("data-element_id")),
            "rueckmeldungen"
        );
    });

    // ANWESENHEITEN DOKUMENTIEREN (MODAL) ÖFFNEN
    $(document).on("click", ".btn_anwesenheiten_dokumentieren", function () {
        const checkliste_id = "anwesenheiten_dokumentieren";
        const liste = $(this).attr("data-liste");
        const title = $(this).attr("data-title");
        const gegen_element_id = $(this).attr("data-gegen_element_id");
        const $modal = LISTEN[liste].modals[checkliste_id + "_modal"].clone().removeClass("blanko invisible").addClass("modal");

        if (typeof title !== "undefined") $modal.find(".modal-title").text(title);
        $modal.find(".checkliste").attr("data-gegen_element_id", gegen_element_id);
        Schnittstelle_DomModalOeffnen($modal);
        Schnittstelle_EventVariableUpdDom(liste);
    });

    // temp_check_doppelte_rueckmeldungen
    $(document).on("click", ".btn_temp_check_doppelte_rueckmeldungen_anzeigen", function () {
        Schnittstelle_DomModalOeffnen(
            Liste_ElementFormularInitialisiertZurueck("temp_check_doppelte_rueckmeldungen", $(this).attr("data-liste"), $(this).attr("data-aktion"), {
                title: $(this).attr("data-title"),
            })
        );
        Schnittstelle_EventVariableUpdDom($(this).attr("data-liste"));
    });
}
