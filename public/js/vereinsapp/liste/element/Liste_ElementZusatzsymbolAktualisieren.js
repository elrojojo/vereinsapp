function Liste_ElementZusatzsymbolAktualisieren($zusatzsymbol, $element, liste) {
    const element_id = Number($element.attr("data-element_id"));
    const zusatzsymbol = $zusatzsymbol.attr("data-zusatzsymbol");

    $zusatzsymbol.find('[data-bs-toggle="popover"]').popover("hide");
    $zusatzsymbol.empty();

    // Zusatzsymbol für Geburtstag
    if (
        zusatzsymbol == "geburtstag" &&
        Schnittstelle_VariableRausZurueck("geburtstag", element_id, liste) <= DateTime.now() &&
        DateTime.now() <= Schnittstelle_VariableRausZurueck("geburtstag", element_id, liste).plus({ days: 1 })
    )
        $zusatzsymbol.html('<i class="bi bi-' + SYMBOLE["geburtstag"]["bootstrap"] + ' text-primary"></i>');

    // Zusatzsymbol für offen_erledigt_markieren
    if (zusatzsymbol == "offen_erledigt_markieren")
        $zusatzsymbol.html('<i class="bi bi-' + SYMBOLE["offen_erledigt_markieren"]["bootstrap"] + ' text-primary"></i>');

    // Zusatzsymbol für offen_erledigt
    if (zusatzsymbol == "offen_erledigt") {
        let offen_erledigt;
        if (Schnittstelle_VariableRausZurueck("erledigt", element_id, liste) === null) offen_erledigt = "offen";
        else offen_erledigt = "erledigt";

        $zusatzsymbol.html(
            '<i class="bi bi-' +
                SYMBOLE[offen_erledigt]["bootstrap"] +
                ' btn_kassenbucheintrag_offen_erledigt_markieren bestaetigung_einfordern text-primary" data-' +
                LISTEN[liste].element +
                "_id=" +
                element_id +
                ' data-title="Kassenbucheintrag als offen/erledigt markieren" role="button"></i>'
        );
    }

    // Zusatzsymbol für Kategorie
    if (zusatzsymbol == "kategorie")
        $zusatzsymbol.html(VORGEGEBENE_WERTE[liste]["kategorie"][Schnittstelle_VariableRausZurueck("kategorie", element_id, liste)]["symbol"]);

    // Zusatzsymbol für Datei
    if (zusatzsymbol == "datei") {
        const datei = $element.attr("data-datei");
        const punkt = datei.lastIndexOf(".");
        const typ = datei.slice(punkt + 1);
        $zusatzsymbol.html('<i class="bi bi-' + SYMBOLE[typ]["bootstrap"] + ' text-primary"></i>');
    }

    // Zusatzsymbol für Verzeichnis
    if (zusatzsymbol == "verzeichnis") {
        $zusatzsymbol.html('<i class="bi bi-' + SYMBOLE["verzeichnis"]["bootstrap"] + ' text-primary"></i>');
    }

    // Zusatzsymbol für Ändern-Werkzeug
    if (zusatzsymbol == "aendern") {
        $zusatzsymbol.html(
            '<i class="bi bi-' +
                SYMBOLE["aendern"]["bootstrap"] +
                " btn_" +
                LISTEN[liste].element +
                '_aendern formular_oeffnen text-primary" data-liste="' +
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
                '_duplizieren formular_oeffnen text-primary" data-liste="' +
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
                '_loeschen bestaetigung_einfordern text-danger" data-liste="' +
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
                    ' stretched-link-unwirksam text-primary" data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="focus" tabindex="0" data-bs-placement="right" data-bs-content="' +
                    bemerkung +
                    '" role="button"></i>'
            );

        [...$zusatzsymbol.find('[data-bs-toggle="popover"]')].map((popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl));
    }
}
