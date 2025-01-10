ELEMENTE.umfrage.ergaenzen_aktion = function (umfrage) {
    if ("rueckmeldungen" in LISTEN) {
        umfrage["ich_rueckmeldung_id"] = Liste_ElementIdZurueck(
            [
                { liste: "umfragen", element_id: Number(umfrage["id"]) },
                { liste: "mitglieder", element_id: Number(ICH["id"]) },
            ],
            "rueckmeldungen"
        );
        if (typeof umfrage["ich_rueckmeldung_id"] === "undefined") umfrage["ich_rueckgemeldet"] = false;
        else umfrage["ich_rueckgemeldet"] = true;
    }
};

function Umfragen_Init() {
    // UMFRAGE ERSTELLEN
    $(document).on("click", ".btn_umfrage_erstellen", function () {
        Umfragen_UmfrageErstellen(
            $(this).hasClass("formular_oeffnen"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal"), $formular: $(this).closest(".formular") },
            Liste_ElementFormularEigenschaftenWerteZurueck($(this).closest(".formular")),
            $(this).attr("data-title"),
            undefined
        );
    });

    // UMFRAGE ÄNDERN
    $(document).on("click", ".btn_umfrage_aendern", function () {
        Umfragen_UmfrageAendern(
            $(this).hasClass("formular_oeffnen"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal"), $formular: $(this).closest(".formular") },
            Liste_ElementFormularEigenschaftenWerteZurueck($(this).closest(".formular")),
            $(this).attr("data-title"),
            $(this).attr("data-element_id")
        );
    });

    // UMFRAGE DUPLIZIEREN
    $(document).on("click", ".btn_umfrage_duplizieren", function () {
        Umfragen_UmfrageErstellen(
            $(this).hasClass("formular_oeffnen"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal"), $formular: $(this).closest(".formular") },
            Liste_ElementFormularEigenschaftenWerteZurueck($(this).closest(".formular")),
            $(this).attr("data-title"),
            $(this).attr("data-element_id")
        );
    });

    // UMFRAGE LÖSCHEN
    $(document).on("click", ".btn_umfrage_loeschen", function () {
        Liste_ElementLoeschen(
            $(this).hasClass("bestaetigung_einfordern"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal") },
            { weiterleiten: $(this).attr("data-weiterleiten") },
            $(this).attr("data-title"),
            $(this).attr("data-element_id"),
            "umfragen"
        );
    });

    // RÜCKMELDUNG ERSTELLEN
    $(document).on("click", ".btn_rueckmeldung_erstellen", function () {
        Umfragen_RueckmeldungErstellen(
            false,
            { $btn_ausloesend: $(this) },
            {
                umfrage_id: JSON.parse($(this).attr("data-werte")).umfrage_id,
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
        Umfragen_RueckmeldungAendern(
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
        Umfragen_RueckmeldungDetaillieren(
            $(this).hasClass("formular_oeffnen"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal"), $formular: $(this).closest(".formular") },
            Liste_ElementFormularEigenschaftenWerteZurueck($(this).closest(".formular")),
            $(this).attr("data-title"),
            $(this).attr("data-element_id")
        );
    });
}
