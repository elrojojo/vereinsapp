const DateTime = luxon.DateTime;

$(document).ready(function () {
    Schnittstelle_AjaxInit();
    Schnittstelle_EventInit();
    Schnittstelle_LocalstorageInit();
    Liste_Init();
    Schnittstelle_DomInit();

    if (LOGGEDIN) {
        Mitglieder_Init();
        Aufgaben_Init();
        Termine_Init();
        Strafkatalog_Init();
        Notenbank_Init();

        $.each(LISTEN, function (liste, LISTE) {
            Schnittstelle_EventAusfuehren([Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom], {
                liste: liste,
            });
        });

        Schnittstelle_EventAusfuehren(
            [Schnittstelle_EventSqlUpdLocalstorage, Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom],
            undefined,
            true
        );
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
    if (typeof Schnittstelle_LocalstorageRausZurueck("datenschutz_richtlinie_" + DATENSCHUTZ_RICHTLINIE_DATUM) === "undefined")
        Schnittstelle_AjaxInDieSchlange("status/ajax_datenschutz_richtlinie", {}, {}, function (AJAX) {
            Schnittstelle_DomModalOeffnen(AJAX.antwort.html);
            $(document).on("click", "#datenschutz_richtlinie_akzeptieren", function () {
                Schnittstelle_LocalstorageRein("datenschutz_richtlinie_" + DATENSCHUTZ_RICHTLINIE_DATUM, DateTime.now());
                Schnittstelle_DomModalSchliessen($("#datenschutz_richtlinie_modal"));
            });
        });
});

/* TODO

FEATURES
Filtern auf eine Ebene beschränken und die Oberfläche optimieren
Sortieren auf einen Wert beschränken (analog zu gruppieren)
Batch über filtern- und sortieren-Button legen
Liste unformatiert in die Zwischenablage kopieren
Termin mit Ende erweitern
Mitglied einplanen bereits bei der Erstellung einer Aufgabe
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
zusatzsymbole mit aktion nicht anzeigen, wenn klasse_id definiert ist (weil stretched-link-unwirksam nicht funktioniert)
Rekursion-Problem Rückmeldungen vs. Termine auflösen
Schnittstelle_LocalstorageWertBereinigtZurueck in Schnittstelle_LocalstorageRein integrieren
Form validation für bemerkung mit Regel field_exists durchführen?
Braucht es FILTERN, SORTIEREN und GRUPPIEREN überhaupt?
Wozu braucht es LISTEN[liste].instanz[instanz].filtern und .sortieren?

*/
