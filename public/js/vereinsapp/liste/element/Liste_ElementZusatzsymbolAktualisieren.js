function Liste_ElementZusatzsymbolAktualisieren($zusatzsymbol, $element, liste) {
    const element_id = Number($element.attr("data-element_id"));
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

    // Zusatzsymbol für de_aktivieren
    if (zusatzsymbol == "de_aktivieren") $zusatzsymbol.html('<i class="bi bi-' + SYMBOLE["de_aktivieren"]["bootstrap"] + ' text-primary me-1"></i>');

    // Zusatzsymbol für aktiv
    if (zusatzsymbol == "aktiv") {
        let aktiv = "aktiv";
        if (LISTEN[liste].tabelle[element_id].aktiv == 0) aktiv = "inaktiv";

        $zusatzsymbol.html(
            '<i class="bi bi-' +
                SYMBOLE[aktiv]["bootstrap"] +
                ' btn_kassenbucheintrag_de_aktivieren text-primary me-1" data-element_id=' +
                element_id +
                ' data-title="Kassenbucheintrag (de)aktivieren" role="button"></i>'
        );
    }
    // Zusatzsymbol für Kategorie
    if (zusatzsymbol == "kategorie") $zusatzsymbol.html(VORGEGEBENE_WERTE[liste]["kategorie"][LISTEN[liste].tabelle[element_id].kategorie]["symbol"]);

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

    // Zusatzsymbol für Ändern-Werkzeug
    if (zusatzsymbol == "aendern") {
        $zusatzsymbol.html(
            '<i class="bi bi-' +
                SYMBOLE["aendern"]["bootstrap"] +
                " btn_" +
                LISTEN[liste].element +
                '_aendern formular_oeffnen text-primary me-1" data-liste="' +
                liste +
                '" data-element_id="' +
                element_id +
                '" data-title="' +
                Liste_ElementBeschriftungZurueck(element_id, liste) +
                ' ändern" role="button"></i>'
        );
    }

    // Zusatzsymbol für Duplizieren-Werkzeug
    if (zusatzsymbol == "duplizieren") {
        $zusatzsymbol.html(
            '<i class="bi bi-' +
                SYMBOLE["duplizieren"]["bootstrap"] +
                " btn_" +
                LISTEN[liste].element +
                '_duplizieren formular_oeffnen text-primary me-1" data-liste="' +
                liste +
                '" data-element_id="' +
                element_id +
                '" data-title="' +
                Liste_ElementBeschriftungZurueck(element_id, liste) +
                ' duplizieren" role="button"></i>'
        );
    }

    // Zusatzsymbol für Löschen-Werkzeug
    if (zusatzsymbol == "loeschen") {
        $zusatzsymbol.html(
            '<i class="bi bi-' +
                SYMBOLE["loeschen"]["bootstrap"] +
                " btn_" +
                LISTEN[liste].element +
                '_loeschen bestaetigung_einfordern text-danger me-1" data-liste="' +
                liste +
                '" data-element_id="' +
                element_id +
                '" data-title="' +
                Liste_ElementBeschriftungZurueck(element_id, liste) +
                ' löschen" role="button"></i>'
        );
    }

    // Zusatzsymbol für Bemerkung bei Rückmeldung
    if (zusatzsymbol == "bemerkung") {
        let bemerkung;

        if ($element.parents('.auswertungen[data-auswertungen="rueckmeldungen"]').exists()) {
            const gegen_element_id = Number($element.parents('.auswertungen[data-auswertungen="rueckmeldungen"]').attr("data-gegen_element_id"));
            const filtern = [
                {
                    verknuepfung: "&&",
                    filtern: [
                        { operator: "==", eigenschaft: "termin_id", wert: gegen_element_id },
                        { operator: "==", eigenschaft: "mitglied_id", wert: element_id },
                    ],
                },
            ];
            const gefilterte_rueckmeldungen = Liste_TabelleGefiltertZurueck(filtern, "rueckmeldungen");
            if (gefilterte_rueckmeldungen.length > 0) bemerkung = gefilterte_rueckmeldungen[gefilterte_rueckmeldungen.length - 1]["bemerkung"];
        } else bemerkung = Schnittstelle_VariableRausZurueck("bemerkung", element_id, liste);

        if (typeof bemerkung !== "undefined" && bemerkung != null && bemerkung != "")
            $zusatzsymbol.html(
                '<i class="bi bi-' +
                    SYMBOLE["bemerkung"]["bootstrap"] +
                    ' stretched-link-unwirksam text-primary ms-1 " data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="focus" tabindex="0" data-bs-placement="right" data-bs-content="' +
                    bemerkung +
                    '" role="button"></i>'
            );

        [...$zusatzsymbol.find('[data-bs-toggle="popover"]')].map((popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl));
    }
}
