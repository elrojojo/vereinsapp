function Liste_ElementZusatzsymbolAktualisieren($zusatzsymbol, $element, liste) {
    const element_id = Number($element.attr("data-element_id"));
    const zusatzsymbol = $zusatzsymbol.attr("data-zusatzsymbol");

    $zusatzsymbol.find('[data-bs-toggle="popover"]').popover("hide");
    $zusatzsymbol.empty();

    // Zusatzsymbol für Geburtstag
    if (
        zusatzsymbol == "geburtstag" &&
        G.LISTEN[liste].tabelle[element_id].geburtstag <= DateTime.now() &&
        DateTime.now() <= G.LISTEN[liste].tabelle[element_id].geburtstag.plus({ days: 1 })
    )
        $zusatzsymbol.html(SYMBOLE["geburtstag"]["html"]);

    // Zusatzsymbol für abwesend
    if (zusatzsymbol == "abwesend" && G.LISTEN[liste].tabelle[element_id].abwesend) $zusatzsymbol.html(SYMBOLE["abwesend"]["html"]);

    // Zusatzsymbol für Kategorie
    if (zusatzsymbol == "kategorie")
        $zusatzsymbol.html(VORGEGEBENE_WERTE[liste]["kategorie"][G.LISTEN[liste].tabelle[element_id].kategorie]["symbol"]);

    // Zusatzsymbol für Datei
    if (zusatzsymbol == "datei") {
        const datei = $element.attr("data-datei");
        const punkt = datei.lastIndexOf(".");
        const typ = datei.slice(punkt + 1);
        $zusatzsymbol.html('<i class="bi bi-' + SYMBOLE[typ]["bootstrap"] + ' text-primary me-1"></i>');
    }

    // Zusatzsymbol für Verzeichnis
    if (zusatzsymbol == "verzeichnis") {
        $zusatzsymbol.html('<i class="bi bi-' + SYMBOLE["verzeichnis"]["bootstrap"] + ' text-primary me-1"></i>');
    }

    // Zusatzsymbol für Kommentar bei Rückmeldung
    if (zusatzsymbol == "kommentar") {
        if ($element.parents('.auswertungen[data-auswertungen="rueckmeldungen"]').exists()) {
            const termin_id = Number(
                JSON.parse($element.parents('.auswertungen[data-auswertungen="rueckmeldungen"]').attr("data-gegen_liste")).filtern[0].wert
            );

            const filtern = [
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
            const gefilterte_rueckmeldungen = Liste_TabelleGefiltertZurueck(filtern, "rueckmeldungen");

            if (gefilterte_rueckmeldungen.length > 0)
                $zusatzsymbol.html(
                    '<i class="bi bi-' +
                        SYMBOLE["bemerkung"]["bootstrap"] +
                        ' text-primary ms-1" data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="focus" tabindex="0" data-bs-placement="right" data-bs-content="' +
                        gefilterte_rueckmeldungen[gefilterte_rueckmeldungen.length - 1]["bemerkung"] +
                        '" role="button"></i>'
                );

            [...$zusatzsymbol.find('[data-bs-toggle="popover"]')].map((popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl));
        }
    }

    if (typeof $zusatzsymbol.attr("data-element_id") !== "undefined") $zusatzsymbol.attr("data-element_id", element_id); // temp_check_doppelte_rueckmeldungen
}
