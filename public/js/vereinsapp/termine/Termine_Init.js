LISTEN.rueckmeldungen = {
    controller: "termine",
    element: "rueckmeldung",
    beschriftung: [{ eigenschaft: "id", prefix: "die Rückmeldung " }],
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
        Termine_TerminErstellen(
            $(this).hasClass("formular_oeffnen"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.formular"),
            undefined
        );
    });

    // TERMIN ÄNDERN
    $(document).on("click", ".btn_termin_aendern", function () {
        Termine_TerminAendern(
            $(this).hasClass("formular_oeffnen"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.formular"),
            Number($(this).attr("data-element_id"))
        );
    });

    // TERMIN DUPLIZIEREN
    $(document).on("click", ".btn_termin_duplizieren", function () {
        Termine_TerminErstellen(
            $(this).hasClass("formular_oeffnen"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.formular"),
            Number($(this).attr("data-element_id"))
        );
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
        Termine_RueckmeldungErstellen(
            $(this),
            JSON.parse($(this).attr("data-werte")).termin_id,
            JSON.parse($(this).attr("data-werte")).mitglied_id,
            JSON.parse($(this).attr("data-werte")).status
        );
    });

    // RÜCKMELDUNG ÄNDERN
    $(document).on("click", ".btn_rueckmeldung_aendern", function () {
        Termine_RueckmeldungAendern($(this), JSON.parse($(this).attr("data-werte")).status, Number($(this).attr("data-element_id")));
    });

    // RÜCKMELDUNG DETAILLIEREN
    $(document).on("click", ".btn_rueckmeldung_detaillieren", function () {
        Termine_RueckmeldungDetaillieren(
            $(this).hasClass("formular_oeffnen"),
            $(this).attr("data-title"),
            $(this),
            $(this).closest(".modal.formular"),
            Number($(this).attr("data-element_id"))
        );
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
        const liste = $(this).attr("data-liste");
        const title = $(this).attr("data-title");
        const $modal = LISTEN[liste].modals["anwesenheiten_dokumentieren_modal"].clone().removeClass("blanko invisible").addClass("modal");

        if (typeof title !== "undefined") $modal.find(".modal-title").text(title);
        Schnittstelle_DomModalOeffnen($modal);
        Schnittstelle_EventVariableUpdDom(liste);
    });
}
