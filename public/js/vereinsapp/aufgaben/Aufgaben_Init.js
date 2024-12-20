LISTEN.aufgaben.element_ergaenzen_aktion = function (aufgabe) {
    if (aufgabe["erledigt"] === null) aufgabe["erledigt_janein"] = false;
    else aufgabe["erledigt_janein"] = true;

    if (aufgabe["zugeordnete_liste"] !== null && aufgabe["zugeordnete_element_id"] !== null)
        aufgabe["zugeordnetes_element"] = { liste: aufgabe["zugeordnete_liste"], id: aufgabe["zugeordnete_element_id"] };
    else aufgabe["zugeordnetes_element"] = null;
};

EIGENSCHAFTEN.aufgaben.zugeordnete_liste.change_aktion = function ($zugeordnete_liste) {
    const zugeordnete_liste = $zugeordnete_liste.val();
    const $formular = $zugeordnete_liste.closest(".formular");

    $formular.find('.eingabe[data-eingabe="zugeordnete_element_id"]').each(function () {
        const $zugeordnete_element_id = $(this);
        if (zugeordnete_liste != "") $zugeordnete_element_id.attr("data-liste", zugeordnete_liste).val(null);
        else $zugeordnete_element_id.removeAttr("data-liste").val(null);

        EIGENSCHAFTEN.aufgaben.zugeordnete_element_id.change_aktion($zugeordnete_element_id);
    });

    $formular.find(".btn_element_zuordnen, .btn_zugeordnetes_element_loeschen").each(function () {
        const $btn = $(this);
        if (zugeordnete_liste != "") $btn.removeClass("disabled");
        else $btn.addClass("disabled");
    });
};

EIGENSCHAFTEN.aufgaben.zugeordnete_element_id.change_aktion = function ($zugeordnete_element_id) {
    const zugeordnete_liste = $zugeordnete_element_id.attr("data-liste");
    const zugeordnete_element_id = $zugeordnete_element_id.val();

    $zugeordnete_element_id
        .closest(".formular")
        .find("#zugeordnetes_element.liste")
        .each(function () {
            const $zugeordnetes_element = $(this);

            if (typeof zugeordnete_liste !== "undefined")
                $zugeordnetes_element
                    .attr("data-liste", zugeordnete_liste)
                    .attr("data-filtern", JSON.stringify([{ operator: "==", eigenschaft: "id", wert: zugeordnete_element_id }]));
            else $zugeordnetes_element.removeAttr("data-liste").removeAttr("data-filtern");

            EIGENSCHAFTEN.aufgaben.zugeordnetes_element.change_aktion($zugeordnetes_element);
        });
};

EIGENSCHAFTEN.aufgaben.zugeordnetes_element.change_aktion = function ($zugeordnetes_element) {
    const zugeordnete_liste = $zugeordnetes_element.attr("data-liste");

    if (typeof zugeordnete_liste !== "undefined") {
        const $blanko_element = AUSWAHLLISTE.$blanko_element.clone(); // ToDo: Hauptinstanzen verwenden
        $blanko_element.attr("data-liste", zugeordnete_liste).find(".beschriftung").html(Liste_ElementBeschriftungHtmlZurueck(zugeordnete_liste));
        LISTEN[zugeordnete_liste].instanz["zugeordnetes_element"] = { filtern: [], sortieren: [], $blanko_element: $blanko_element };
        Schnittstelle_EventAusfuehren(Schnittstelle_EventVariableUpdDom, { liste: zugeordnete_liste });
    } else $zugeordnetes_element.empty();
};

function Aufgaben_Init() {
    EVENT_VARIABLE_UPD_DOM_MODULE["aufgaben"] = [
        function () {
            // AUFGABE AKTUALISIEREN
            $('.element[data-liste="aufgaben"]').each(function () {
                Aufgaben_AufgabeAktualisieren($(this));
            });
        },
    ];

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

    // ELEMENT ZUORDNEN
    $(document).on("click", ".btn_element_zuordnen", function () {
        Aufgaben_AufgabeElementZuordnen(
            $(this).hasClass("auswahl_einfordern"),
            { $ziel: $(this), $quelle: $(this), $modal: $(this).closest(".modal") },
            $(this).attr("data-title"),
            $(this).attr("data-liste")
        );
    });

    // ZUGEORDNETES ELEMENT LÖSCHEN
    $(document).on("click", ".btn_zugeordnetes_element_loeschen", function () {
        Aufgaben_AufgabeZugeordnetesElementLoeschen({ $formular: $(this).closest(".formular") });
    });

    // MITGLIED EINPLANEN
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

    // MITGLIED AUSPLANEN
    $(document).on("click", ".btn_aufgabe_mitglied_ausplanen", function () {
        Aufgaben_AufgabeMitgliedAusplanen(
            $(this).hasClass("bestaetigung_einfordern"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal") },
            $(this).attr("data-title"),
            $(this).attr("data-aufgabe_id")
        );
    });

    // AUFGABE ALS OFEN/ERLEDIGT MARKIEREN
    $(document).on("click", ".btn_aufgabe_offen_erledigt_markieren", function () {
        Aufgabe_AufgabeOffenErledigtMarkieren(
            $(this).hasClass("bestaetigung_einfordern"),
            { $btn_ausloesend: $(this), $modal: $(this).closest(".modal") },
            $(this).attr("data-title"),
            $(this).attr("data-aufgabe_id")
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
}
