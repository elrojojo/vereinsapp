LISTEN.rueckmeldungen = {
    controller: "termine",
    element: "rueckmeldung",
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
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal"), $formular: $(this).closest(".formular") },
            Liste_ElementFormularEigenschaftenWerteZurueck($(this).closest(".formular")),
            $(this).attr("data-title"),
            undefined
        );
    });

    // TERMIN ÄNDERN
    $(document).on("click", ".btn_termin_aendern", function () {
        Termine_TerminAendern(
            $(this).hasClass("formular_oeffnen"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal"), $formular: $(this).closest(".formular") },
            Liste_ElementFormularEigenschaftenWerteZurueck($(this).closest(".formular")),
            $(this).attr("data-title"),
            $(this).attr("data-element_id")
        );
    });

    // TERMIN DUPLIZIEREN
    $(document).on("click", ".btn_termin_duplizieren", function () {
        Termine_TerminErstellen(
            $(this).hasClass("formular_oeffnen"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal"), $formular: $(this).closest(".formular") },
            Liste_ElementFormularEigenschaftenWerteZurueck($(this).closest(".formular")),
            $(this).attr("data-title"),
            $(this).attr("data-element_id")
        );
    });

    // TERMIN LÖSCHEN
    $(document).on("click", ".btn_termin_loeschen", function () {
        Liste_ElementLoeschen(
            $(this).hasClass("bestaetigung_einfordern"),
            { $btn_ausloesend: $(this), $bestaetigung: $(this).closest(".bestaetigung") },
            { weiterleiten: $(this).attr("data-weiterleiten") },
            $(this).attr("data-title"),
            $(this).attr("data-element_id"),
            "termine"
        );
    });

    // RÜCKMELDUNG ERSTELLEN
    $(document).on("click", ".btn_rueckmeldung_erstellen", function () {
        Termine_RueckmeldungErstellen(
            false,
            { $btn_ausloesend: $(this) },
            {
                termin_id: JSON.parse($(this).attr("data-werte")).termin_id,
                mitglied_id: JSON.parse($(this).attr("data-werte")).mitglied_id,
                status: JSON.parse($(this).attr("data-werte")).status,
                bemerkung: "",
            },
            $(this).attr("data-title"),
            undefined
        );
    });

    // RÜCKMELDUNG ÄNDERN
    $(document).on("click", ".btn_rueckmeldung_aendern", function () {
        Termine_RueckmeldungAendern(
            false,
            { $btn_ausloesend: $(this) },
            {
                status: JSON.parse($(this).attr("data-werte")).status,
                bemerkung: "",
            },
            $(this).attr("data-title"),
            $(this).attr("data-element_id")
        );
    });

    // RÜCKMELDUNG DETAILLIEREN
    $(document).on("click", ".btn_rueckmeldung_detaillieren", function () {
        Termine_RueckmeldungDetaillieren(
            $(this).hasClass("formular_oeffnen"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal"), $formular: $(this).closest(".formular") },
            Liste_ElementFormularEigenschaftenWerteZurueck($(this).closest(".formular")),
            $(this).attr("data-title"),
            $(this).attr("data-element_id")
        );
    });

    // RÜCKMELDUNG LÖSCHEN
    $(document).on("click", ".btn_rueckmeldung_loeschen", function () {
        Liste_ElementLoeschen(
            $(this).hasClass("bestaetigung_einfordern"),
            { $btn_ausloesend: $(this), $bestaetigung: $(this).closest(".bestaetigung") },
            { weiterleiten: $(this).attr("data-weiterleiten") },
            $(this).attr("data-title"),
            $(this).attr("data-element_id"),
            "rueckmeldungen"
        );
    });

    // ANWESENHEITEN DOKUMENTIEREN (MODAL) ÖFFNEN
    $(document).on("click", ".btn_anwesenheiten_dokumentieren", function () {
        const liste = $(this).attr("data-liste");
        const element_id = $(this).attr("data-element_id");
        const title = $(this).attr("data-title");

        let gegen_liste = $(this).attr("data-gegen_liste");
        if (typeof gegen_liste === "undefined" && liste == "termine") gegen_liste = "mitglieder";
        else if (typeof gegen_liste === "undefined" && liste == "mitglieder") gegen_liste = "termine";

        const $neues_modal = Schnittstelle_DomNeuesModalInitialisiertZurueck(title, liste + "_anwesenheiten_dokumentieren");
        Schnittstelle_DomModalOeffnen($neues_modal);
        $neues_modal.find("#anwesenheiten_dokumentieren").attr("data-gegen_liste", liste).attr("data-gegen_element_id", element_id);
        Schnittstelle_EventVariableUpdDom(gegen_liste);
    });
}
