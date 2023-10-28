function Liste_ElementAktualisieren($element, liste) {
    const element_id = Number($element.attr("data-element_id"));

    // EIGENSCHAFTEN AKTUALISIEREN
    $element.find(".eigenschaft").each(function () {
        const $eigenschaft = $(this);
        const eigenschaft = $eigenschaft.attr("data-eigenschaft");
        $eigenschaft.html(Liste_WertFormatieren(LISTEN[liste].tabelle[element_id][eigenschaft], eigenschaft, liste));
    });

    // ZUSATZSYMBOLE AKTUALISIEREN
    $element.find(".zusatzsymbol").each(function () {
        const $zusatzsymbol = $(this);
        const zusatzsymbol = $zusatzsymbol.attr("data-zusatzsymbol");

        $zusatzsymbol.find('[data-bs-toggle="popover"]').popover("hide");
        $zusatzsymbol.empty();

        // Zusatzsymbol für Geburtstag
        if (
            zusatzsymbol == "geburtstag" &&
            LISTEN[liste].tabelle[element_id].geburtstag <= DateTime.now() &&
            DateTime.now() <= LISTEN[liste].tabelle[element_id].geburtstag.plus({ days: 1 })
        )
            $zusatzsymbol.html(SYMBOLE["geburtstag"]["html"]);

        // Zusatzsymbol für abwesend
        if (zusatzsymbol == "abwesend" && LISTEN[liste].tabelle[element_id].abwesend) $zusatzsymbol.html(SYMBOLE["abwesend"]["html"]);

        // Zusatzsymbol für Kategorie
        if (zusatzsymbol == "kategorie")
            $zusatzsymbol.html(VORGEGEBENE_WERTE[liste]["kategorie"][LISTEN[liste].tabelle[element_id].kategorie]["symbol"]);

        // Zusatzsymbol für Kommentar
        if (zusatzsymbol == "kommentar") {
            if ($element.parents('.auswertungen[data-liste="rueckmeldungen"]').exists()) {
                const termin_id = Number(JSON.parse($element.parents('.auswertungen[data-liste="rueckmeldungen"]').attr("data-filtern"))[0].wert);

                const rueckmeldungen_filtern = [
                    {
                        verknuepfung: "&&",
                        filtern: [
                            { operator: "==", eigenschaft: "termin_id", wert: termin_id },
                            { operator: "==", eigenschaft: "mitglied_id", wert: element_id },
                            { operator: "!=", eigenschaft: "bemerkung", wert: "undefined" },
                            { operator: "!=", eigenschaft: "bemerkung", wert: null },
                            { operator: "!=", eigenschaft: "bemerkung", wert: "" },
                        ],
                    },
                ];
                const gefilterte_rueckmeldungen = Liste_TabelleFiltern(rueckmeldungen_filtern, "rueckmeldungen");

                if (gefilterte_rueckmeldungen.length > 0)
                    $zusatzsymbol.html(
                        '<i class="bi bi-' +
                            SYMBOLE["bemerkung"]["bootstrap"] +
                            ' text-primary ms-1" role="button" data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="focus" tabindex="0" data-bs-placement="right" data-bs-content="' +
                            gefilterte_rueckmeldungen[gefilterte_rueckmeldungen.length - 1]["bemerkung"] +
                            '"></i>'
                    );

                [...$zusatzsymbol.find('[data-bs-toggle="popover"]')].map((popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl));
            }
        }
    });

    // LETZTEN SPACER AUS DER VORSCHAU LÖSCHEN
    const $letztes_vorschau_element = $element.find(".vorschau").children().last();
    if ($letztes_vorschau_element.hasClass("spacer")) $letztes_vorschau_element.remove();
}
