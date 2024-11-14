const DateTime = luxon.DateTime;

$(document).ready(function () {
    Schnittstelle_AjaxInit();
    Schnittstelle_LocalstorageInit();
    Liste_Init();
    Schnittstelle_DomInit();

    if (LOGGEDIN) {
        Mitglieder_Init();
        Aufgaben_Init();
        Termine_Init();
        Strafkatalog_Init();
        Notenbank_Init();

        Schnittstelle_EventLocalstorageUpdVariable();
        Schnittstelle_EventVariableUpdDom();
        if (Object.keys(LISTEN).length > 0)
            Schnittstelle_EventSqlUpdLocalstorage(Object.keys(LISTEN), true, [
                Schnittstelle_EventLocalstorageUpdVariable,
                Schnittstelle_EventVariableUpdDom,
            ]);
    }

    $(".formular").each(function () {
        const $formular = $(this);
        const liste = $formular.attr("data-liste");
        const aktion = $formular.attr("data-aktion");
        let element_id = $formular.attr("data-element_id");
        if (typeof element_id !== "undefined") element_id = Number(element_id);
        if (typeof liste !== "undefined") Liste_ElementFormularInitialisieren($formular, aktion, element_id, liste);
    });

    // DATENACHUTZ-RICHTLINIE AKZEPTIEREN
    if (typeof Schnittstelle_LocalstorageRausZurueck("datenschutz_richtlinie_" + DATENSCHUTZ_RICHTLINIE_DATUM) === "undefined") {
        // SCHNITTSTELLE AJAX
        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "status/ajax_datenschutz_richtlinie",
            rein_validation_pos_aktion: function (AJAX) {
                Schnittstelle_DomModalOeffnen(AJAX.antwort.html);
                $(document).on("click", "#datenschutz_richtlinie_akzeptieren", function () {
                    Schnittstelle_LocalstorageRein("datenschutz_richtlinie_" + DATENSCHUTZ_RICHTLINIE_DATUM, DateTime.now());
                    Schnittstelle_DomModalSchliessen($("#datenschutz_richtlinie_modal"));
                });
            },
        };
        Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
    }
});

/* TODO

FEATURES
Filtern auf eine Ebene beschränken und die Oberfläche optimieren
Sortieren auf einen Wert beschränken (analog zu gruppieren)
Batch über filtern- und sortieren-Button legen
Liste unformatiert in die Zwischenablage kopieren
Termin mit Ende erweitern
Mitglieder Lebenslauf
Terminserie / Regeltermine
Termin als ics exportieren
Meta-Infos für Unterverzeichnisse und Dateien anzeigen
Verzeichnis filtern und sortieren
Abwesenheiten wieder einführen
Shield-Rollen als Mitglieder-Funktion nutzen (inkl. Registerführer einführen)
Link zu Github neben die Version

SOFTWARE
Zusatzsymbole in Liste durch Bootstrap-Icons ersetzen
Schnittstelle_EventElementReduzieren einführen
Hartes Löschen von Mitgliedern wieder zurücknehmen (is_unique vglb. mit Titel) und weiches Löschen für abhängige Tabellen einführen
Ausloggen, bevor Einmal-Link benutzt wird
Einzelne Module als Light-Version, einschaltbar über .env oder settings
IM DOM ERGÄNZEN und IM DOM SORTIEREN zusammenziehen (für Liste, Verzeichnis, Auswertungen, etc.)
Formatierung eines Werts flexibel machen in Liste_WertFormatiertZurueck() (inkl. möglichem Symbol)
Data-Attribute als Object in einem Attribut zusammenfassen
title ändern in beschriftung?
anwesenheiten_dokumentieren für checkliste verallgemeinern (analog zu Schnittstelle_DomNeuesModalInitialisiertZurueck)
Braucht es noch data-farbe an den Werkzeugen (generell an allen Buttons)?
Sortierung nicht mehr case sensitive machen
Bei Auswertungen data-liste.filtern dynamisch erzeugen (bspw. Kombination aus allgemeinem und spezifischem Mitglieder-Filter und bestehendem dynamischem Mitglieder-Filter)
Schnittstelle_VariableObjektBereinigtZurueck und Schnittstelle_VariableArrayBereinigtZurueck in Schnittstelle_VariableWertBereinigtZurueck vereinigen und anschließend entfernen
Schnittstellen-Funktionen einen Standardwert für undefined mitgeben um den anschließenden else-Pfad zu vermeiden
Zustandsautomat für den Zustand der Vereinsapp einführen
Auswertung unabhängig machen von Auswertungen (dann muss das Ergebnis aber für jede Auswertung bestimmt werden)
ziel/umgebung beim DOM-Update ergänzen (damit nicht immer der komplette DOM aktualisiert wird)
Select JANEIN als check umbauen
Wartungsarbeiten per Filter handlen
.btn in .formular mit ENTER betätigbar machen

AKUT
Bei iPhone verschwindet der Termin auf der Startseite nicht sofort, wenn man Rückmeldung gibt.
Bestaetigung_einfordern für alle Checks anwählen bzw. abwählen (Liste_ChecklisteInit)
zusatzsymbole mit aktion nicht anzeigen, wenn klasse_id definiert ist (weil stretched-link-unwirksam nicht funktioniert)
Form validation für bemerkung mit Regel field_exists durchführen?
Termine-Tabelle existiert nicht, wenn der zu einer Aufgabe verlinkte Termin angezeigt werden soll
    Was macht abhaengig_von und was macht verlinkte_listen und was ist der Unterschied?
Im Controller werkzeugkasten in liste integrieren (analog zu listenstatistik)
Braucht es FILTERN, SORTIEREN und GRUPPIEREN überhaupt?
Haupt-Instanzen zentral definieren (bspw. filtern, sortieren, etc. für bevorstehende_termine_startseite oder auswahl_termine)
    wenn kein filter definiert ist, dann wird der filter der Haupt-Instanz angewandt
Validation erweitern, dass zugeordnete_element_id definiert sein muss, falls zugeordnete_liste definiert ist
Element zu Aufgabe implementieren

*/
