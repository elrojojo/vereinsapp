const DateTime = luxon.DateTime;

const G = {
    AJAX: new Array(),

    LISTEN: new Object(),

    MODALS: { offen: new Array() },

    CSRF: { [CSRF_NAME]: ERSTER_CSRF_HASH },
};

$(document).ready(function () {
    Schnittstelle_DomInit();

    Liste_Init();

    if (LOGGEDIN) Mitglieder_Init();

    function localstorage_leeren() {
        const datenschutz_richtlinie = Schnittstelle_LocalstorageRausZurueck("datenschutz_richtlinie_" + DATENACHUTZ_RICHTLINIE_DATUM);
        localStorage.clear();
        Schnittstelle_LocalstorageRein("localstorage_reset", DateTime.now());
        if (typeof datenschutz_richtlinie !== "undefined")
            Schnittstelle_LocalstorageRein("datenschutz_richtlinie_" + DATENACHUTZ_RICHTLINIE_DATUM, datenschutz_richtlinie);
        console.log("LocalStorage wurde erfolgreich geleert.");
    }

    // LOCALSTORAGE LEEREN
    $(".btn_localstorage_leeren").click(function () {
        localstorage_leeren();
        $(this).closest(".modal").modal("hide");
    });

    // LOCALSTORAGE LEEREN ERZWINGEN
    if (
        typeof Schnittstelle_LocalstorageRausZurueck("localstorage_reset") === "undefined" ||
        DateTime.fromISO(Schnittstelle_LocalstorageRausZurueck("localstorage_reset")) < DateTime.fromISO(FORCE_LOCALSTORAGE_RESET_ZEITPUNKT)
    )
        localstorage_leeren();

    // DATENACHUTZ-RICHTLINIE AKZEPTIEREN
    if (typeof Schnittstelle_LocalstorageRausZurueck("datenschutz_richtlinie_" + DATENACHUTZ_RICHTLINIE_DATUM) === "undefined") {
        // SCHNITTSTELLE AJAX
        const neue_ajax_id = G.AJAX.length;
        G.AJAX[neue_ajax_id] = {
            ajax_id: neue_ajax_id,
            label: "datenschutz_richtlinie",
            url: "status/ajax_datenschutz_richtlinie",
            rein_validation_pos_aktion: function (AJAX) {
                $("#modals_anzeigen_liste").append(AJAX.antwort.html);
                $("#datenschutz_richtlinie_Modal").modal("show");
                $("#datenschutz_richtlinie_akzeptieren").click(function () {
                    Schnittstelle_LocalstorageRein("datenschutz_richtlinie_" + DATENACHUTZ_RICHTLINIE_DATUM, DateTime.now());
                    $("#datenschutz_richtlinie_Modal").modal("hide");
                });
            },
        };
        Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
    }

    // PASSWORT ANZEIGEN
    $(document).on("click", ".passwort_anzeigen", function (event) {
        $btn = $(this);
        event.preventDefault();
        const feld = $btn.closest(".input-group").find("input.form-control");

        if (feld.attr("type") == "text") {
            feld.attr("type", "password");
            $btn.find("i").removeClass("bi-" + SYMBOLE["sichtbar"]["bootstrap"]);
            $btn.find("i").addClass("bi-" + SYMBOLE["unsichtbar"]["bootstrap"]);
        } else if (feld.attr("type") == "password") {
            feld.attr("type", "text");
            $btn.find("i").removeClass("bi-" + SYMBOLE["unsichtbar"]["bootstrap"]);
            $btn.find("i").addClass("bi-" + SYMBOLE["sichtbar"]["bootstrap"]);
        }
    });

    // INHALT KOPIEREN
    new ClipboardJS(".inhalt_kopieren");

    // VALIDATION-TOOLTIPS ENTFERNEN
    $("input, select").on("focus", function () {
        $(this).next(".invalid-tooltip").remove();
    });
});

$.fn.exists = function () {
    return this.length !== 0;
};

function umlaute2unix(unix) {
    const UMLAUTE_KONVERTIERUNG = new Array(
        [" ", "_"],
        [" ", "-"],
        ["ä", "ae"],
        ["ö", "oe"],
        ["ü", "ue"],
        ["Ä", "Ae"],
        ["Ö", "Oe"],
        ["Ü", "Ue"],
        ["ß", "ss"]
    );

    $.each(UMLAUTE_KONVERTIERUNG, function (index, konvertierung) {
        unix = unix.replaceAll(konvertierung[0], konvertierung[1]);
    });

    return unix;
}

/* TODO

FEATURES
Mitglieder Lebenslauf
Termin mit Ende erweitern
Terminserie / Regeltermine
Termin als ics exportieren
Abwesenheiten wieder einführen (inkl. Hinweis anzeigen, wenn aktuell abwesend)
Anzahl Liste-Einträge und Anzahl ausgewählter Checkliste-Einträge anzeigen
Das eigene Profil editierbar machen, auch wenn man kein Recht zur Verwaltung der Mitglieder hat
Verzeichnis filtern und sortieren
Batch über filtern- und sortieren-Button legen
Shield-Rollen als Mitglieder-Funktion nutzen (inkl. Registerführer einführen)
Eigene Links im Menü anzeigen lassen (und über .env steuern)
Cluster überarbeiten (Reihenfolge Vorgegebene Werte Register ändern (bspw. bei Auswertungen))

SOFTWARE
Zusatzsymbole in Liste durch Bootstrap-Icons ersetzen
Formatierung eines Werts flexibel (inkl. möglichem Symbol)
View für checkliste mit liste vergleichbar machen (bspw. auch als h5 verfügbar machen, bzw. miteinander verschmelzen?)
Schnittstelle_EventElementErgaenzen[x] zusammenfassen in Schnittstelle_EventElementErweitern
Schnittstelle_EventElementReduzieren einführen
Functionen in vereinsapp.js auslagern
Hartes Löschen von Mitgliedern wieder zurücknehmen (is_unique vglb. mit Titel) und weiches Löschen für abhängige Tabellen einführen
Ausloggen, bevor Einmal-Link benutzt wird
Einzelne Module als Light-Version, einschaltbar über .env oder settings
Aufbereitung der sql-Tabelle im Model, nicht im Controller?
Haupt-Instanzen zentral definieren (bspw. filtern, sortieren, etc. für anstehende_termine)

AKUT
Bei iPhone verschwindet der Termin auf der Startseite nicht sofort, wenn man Rückmeldung gibt.
Bootstrap und jquery aktualisieren
Migrations um Abwesenheiten, Notenbank, Termine, Anwesenheiten und Rückmeldungen erweitern
Rückmeldung feuern bei Erfolg/Misserfolg einer Aktion
Werkzeugkasten handle und handle_liste korrigieren
Notenbank Verzeichnis konzeptionell überarbeiten (es braucht die struktur, ähnlich wie liste, und verzeichnisse/dateien, ähnlich wie elemente)

*/
