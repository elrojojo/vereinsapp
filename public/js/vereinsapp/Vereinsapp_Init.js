const DateTime = luxon.DateTime;

$(document).ready(function () {
    Schnittstelle_AjaxInit();
    Schnittstelle_DomInit();
    Schnittstelle_LocalstorageInit();

    Liste_Init();

    $(".formular").each(function () {
        const $formular = $(this);

        const liste = $formular.attr("data-liste");

        let element_id_data = $formular.attr("data-element_id");
        if (typeof element_id_data !== "undefined") element_id_data = Number(element_id_data);
        const element_id = element_id_data;

        Liste_ElementFormularEigenschaftenWerteAktualisieren($formular, element_id, liste);
    });

    if (LOGGEDIN) Mitglieder_Init();
    if (LOGGEDIN) Termine_Init();
    if (LOGGEDIN) Strafkatalog_Init();
    if (LOGGEDIN) Notenbank_Init();

    // DATENACHUTZ-RICHTLINIE AKZEPTIEREN
    if (typeof Schnittstelle_LocalstorageRausZurueck("datenschutz_richtlinie_" + DATENACHUTZ_RICHTLINIE_DATUM) === "undefined") {
        // SCHNITTSTELLE AJAX
        const neue_ajax_id = AJAXSCHLANGE.length;
        AJAXSCHLANGE[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            url: "status/ajax_datenschutz_richtlinie",
            rein_validation_pos_aktion: function (AJAX) {
                Schnittstelle_DomModalOeffnen(AJAX.antwort.html);
                $(document).on("click", "#datenschutz_richtlinie_akzeptieren", function () {
                    Schnittstelle_LocalstorageRein("datenschutz_richtlinie_" + DATENACHUTZ_RICHTLINIE_DATUM, DateTime.now());
                    Schnittstelle_DomModalSchliessen($("#datenschutz_richtlinie_modal"));
                });
            },
        };
        Schnittstelle_AjaxInDieSchlange(AJAXSCHLANGE[neue_ajax_id]);
    }
});

/* TODO

FEATURES
Proberaum-Belegungsplan
Mitglieder Lebenslauf
Terminserie / Regeltermine
Termin mit Ende erweitern
Termin als ics exportieren
Meta-Infos für Unterverzeichnisse und Dateien anzeigen
Verzeichnis filtern und sortieren
Abwesenheiten wieder einführen (inkl. Hinweis anzeigen, wenn aktuell abwesend)
Shield-Rollen als Mitglieder-Funktion nutzen (inkl. Registerführer einführen)
Eigene Links im Menü anzeigen lassen (und über .env steuern)
Link zu Github neben die Version
Batch über filtern- und sortieren-Button legen

SOFTWARE
Zusatzsymbole in Liste durch Bootstrap-Icons ersetzen
Schnittstelle_EventElementErgaenzen[x] zusammenfassen in Schnittstelle_EventElementErweitern
Schnittstelle_EventElementReduzieren einführen
Hartes Löschen von Mitgliedern wieder zurücknehmen (is_unique vglb. mit Titel) und weiches Löschen für abhängige Tabellen einführen
Ausloggen, bevor Einmal-Link benutzt wird
Einzelne Module als Light-Version, einschaltbar über .env oder settings
Haupt-Instanzen zentral definieren (bspw. filtern, sortieren, etc. für bevorstehende_termine_startseite)
IM DOM ERGÄNZEN und IM DOM SORTIEREN zusammenziehen (für Liste, Verzeichnis, Auswertungen, etc.)
Formatierung eines Werts flexibel machen in Liste_WertFormatiertZurueck() (inkl. möglichem Symbol)
Data-Attribute als Object in einem Attribut zusammenfassen
title ändern in beschriftung?
anwesenheiten_dokumentieren_modal für checkliste verallgemeinern (analog zu Liste_ElementFormularInitialisiertZurueck)
In der .env auch die Arrays von Vereinsapp überschreibar machen
Argumente sinnvoll ordnen ($ eher nach hinten?)
Braucht es noch data-farbe an den Werkzeugen (generell an allen Buttons)?
Sortierung nicht mehr case sensitive machen
Bei Auswertungen data-liste.filtern dynamisch erzeugen (bspw. Kombination aus allgemeinem und spezifischem Mitglieder-Filter und bestehendem dynamischem Mitglieder-Filter)
Schnittstelle_VariableObjektBereinigtZurueck und Schnittstelle_VariableArrayBereinigtZurueck in Schnittstelle_VariableWertBereinigtZurueck vereinigen und anschließend entfernen
Schnittstellen-Funktionen einen Standardwert für undefined mitgeben um den anschließenden else-Pfad zu vermeiden
Zustandsautomat für den Zustand der Vereinsapp einführen
Auswertung unabhängig machen von Auswertungen (dann muss das Ergebnis aber für jede Auswertung bestimmt werden)
ziel/umgebung beim DOM-Update ergänzen (damit nicht immer der komplette DOM aktualisiert wird)
Select JANEIN als check umbauen

AKUT
Bei iPhone verschwindet der Termin auf der Startseite nicht sofort, wenn man Rückmeldung gibt.
Codeigniter und Shield updaten
Bemerkung zum Termin, zur Strafe und zum Kassenbuch in der Listenansicht als Pop-up anzeigen
ajax_rueckmeldung_speichern und ajax_rueckmeldung_aendern zusammenführen (analog zu kassenbucheintrag_speichern)
Schnittstelle_DomBestaetigungEinfordern erweitern für array und object (mit JSON.stringify)
Alle Aendern-Funktionen erweitern und PHP-Funktionen anpassen (wie Strafkatalog_KassenbucheintragAendern, d.h. bspw. ajax_rueckmeldung_aendern in ajax_rueckmeldung_speichern integrieren)
Schnittstelle_BtnWartenStart und Schnittstelle_BtnWartenEnde umbauen, sodass icons durch das Symbole temporär ersetzt werden (fällt dann Schnittstelle_BtnDanebenWartenStart und Schnittstelle_BtnDanebenWartenEnde weg?)

*/
