const DateTime = luxon.DateTime;

const G = {
    AJAX: new Array(),

    LISTEN: new Object(),

    MODALS: { offen: new Array() },

    CSRF: { [CSRF_NAME]: ERSTER_CSRF_HASH },
};

$(document).ready(function () {
    Schnittstelle_DomInit();

    Schnittstelle_LocalstorageInit();

    Liste_Init();

    if (LOGGEDIN) Mitglieder_Init();
    if (LOGGEDIN) Termine_Init();
    if (LOGGEDIN) Notenbank_Init();

    // DATENACHUTZ-RICHTLINIE AKZEPTIEREN
    if (typeof Schnittstelle_LocalstorageRausZurueck("datenschutz_richtlinie_" + DATENACHUTZ_RICHTLINIE_DATUM) === "undefined") {
        // SCHNITTSTELLE AJAX
        const neue_ajax_id = G.AJAX.length;
        G.AJAX[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            label: "datenschutz_richtlinie",
            url: "status/ajax_datenschutz_richtlinie",
            rein_validation_pos_aktion: function (AJAX) {
                $("#modals").append(AJAX.antwort.html);
                $("#datenschutz_richtlinie_modal").modal("show");
                $("#datenschutz_richtlinie_akzeptieren").click(function () {
                    Schnittstelle_LocalstorageRein("datenschutz_richtlinie_" + DATENACHUTZ_RICHTLINIE_DATUM, DateTime.now());
                    $("#datenschutz_richtlinie_modal").modal("hide");
                });
            },
        };
        Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
    }
});

/* TODO

FEATURES
Mitglieder Lebenslauf
Termin mit Ende erweitern
Terminserie / Regeltermine
Termin als ics exportieren
Abwesenheiten wieder einführen (inkl. Hinweis anzeigen, wenn aktuell abwesend)
Das eigene Profil editierbar machen, auch wenn man kein Recht zur Verwaltung der Mitglieder hat
Verzeichnis filtern und sortieren
Batch über filtern- und sortieren-Button legen
Shield-Rollen als Mitglieder-Funktion nutzen (inkl. Registerführer einführen)
Eigene Links im Menü anzeigen lassen (und über .env steuern)
Link zu Github neben die Version
Meta-Infos für Unterverzeichnisse und Dateien anzeigen
Bemerkung zum Termin in der Listenansicht als Pop-up anzeigen
Proberaum-Belegungsplan

SOFTWARE
Zusatzsymbole in Liste durch Bootstrap-Icons ersetzen
Formatierung eines Werts flexibel (inkl. möglichem Symbol)
Schnittstelle_EventElementErgaenzen[x] zusammenfassen in Schnittstelle_EventElementErweitern
Schnittstelle_EventElementReduzieren einführen
Hartes Löschen von Mitgliedern wieder zurücknehmen (is_unique vglb. mit Titel) und weiches Löschen für abhängige Tabellen einführen
Ausloggen, bevor Einmal-Link benutzt wird
Einzelne Module als Light-Version, einschaltbar über .env oder settings
Aufbereitung der sql-Tabelle im Model, nicht im Controller?
Haupt-Instanzen zentral definieren (bspw. filtern, sortieren, etc. für anstehende_termine)
Keine doppelten Rückmeldungen erlauben
IM DOM ERGÄNZEN und IM DOM SORTIEREN zusammenziehen (für Liste, Verzeichnis, Auswertungen, etc.)
Liste_WertFormatiertZurueck() soll auch ids verarbeiten können, indem sie in anderen Listen sucht
Feuern eines Toasts für bestimmte Listen unterdrückbar machen

AKUT
Bei iPhone verschwindet der Termin auf der Startseite nicht sofort, wenn man Rückmeldung gibt.
Migrations um Notenbank, Termine, Anwesenheiten und Rückmeldungen erweitern
Elemente aus G. als eigenständige Variablen umbauen (G. wird dann leer sein)
"erstellen" umbenennen zu "speichern"
#toasts als fixed immer oben behalten
In der .env auch die Arrays von Vereinsapp überschreibar machen
h5-Beschriftung mit truncate ergänzen
Nicht existenter Verzeichnis-Ordner führt zu Fehler
mitglied_passwort_festlegen_modal aus dem DOM löschen statt nur zu verstecken
title ändern in beschriftung?

*/
