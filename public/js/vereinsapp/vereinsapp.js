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
        $passwort_anzeigen = $(this);
        event.preventDefault();
        let feld = $passwort_anzeigen.closest(".input-group").find("input.form-control");

        if (feld.attr("type") == "text") {
            feld.attr("type", "password");
            $passwort_anzeigen.find("i").removeClass("bi-" + SYMBOLE["sichtbar"]["bootstrap"]);
            $passwort_anzeigen.find("i").addClass("bi-" + SYMBOLE["unsichtbar"]["bootstrap"]);
        } else if (feld.attr("type") == "password") {
            feld.attr("type", "text");
            $passwort_anzeigen.find("i").removeClass("bi-" + SYMBOLE["unsichtbar"]["bootstrap"]);
            $passwort_anzeigen.find("i").addClass("bi-" + SYMBOLE["sichtbar"]["bootstrap"]);
        }
    });

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
Zusatzsymbole in Liste durch Bootstrap-Icons ersetzen
View für checkliste mit liste vergleichbar machen (bspw. auch als h5 verfügbar machen)
Anzahl Liste-Einträge und Anzahl ausgewählter Checkliste-Einträge anzeigen
Abwesenheiten wieder einführen
    Hinweis anzeigen, wenn aktuell abwesend
Das eigene Profil editierbar machen, auch wenn man kein Recht zur Verwaltung der Mitglieder hat
Registerführer einführen
Verzeichnis filtern und sortieren
Schnittstelle_EventElementErgaenzen[x] zusammenfassen in Schnittstelle_EventElementErweitern
Schnittstelle_EventElementReduzieren einführen
Functionen in vereinsapp.js auslagern
View Details mit <span class="beschriftung">...</span> erweitern (für Befüllung von Modals)
Hartes Löschen wieder zurücknehmen (bspw. bei Mitglied)
ID auto-Increament in JavaScript umsetzen (nicht erst auf EventSqlUpdateLocalstorage warten)
Ausloggen, bevor Einmal-Link benutzt wird
Bootstrap und jquery aktualisieren
Eigene Links im Menü anzeigen lassen (und über .env steuern)
Einzelne Module als Light-Version, einschaltbar über .env oder settings
Cluster überarbeiten
    Reihenfolge Vorgegebene Werte Register ändern (bspw. bei Auswertungen)
Werkzeugkasten bei Listen "von unten"
Aufbereitung der sql-Tabelle im Model, nicht im Controller?
Formatierung eines Werts flexibel (inkl. möglichem Symbol)
Termin löschen in der Detail-Ansicht
Mitglieder Lebenslauf
Termin mit Ende erweitern
Terminserie / Regeltermine
Termin als ics exportieren
Haupt-Instanzen zentral definieren (bspw. filtern, sortieren, etc. für anstehende_termine)

Rückmeldung feuern bei Erfolg/Misserfolg einer Aktion
Batch über filtern- und sortieren-Button legen
Einmal-Link automatisch in die Zwischenablage kopieren (nachdem er angezeigt wurde)
Richtung der Sortierung änderbar machen
Das Recht zur Vergabe von Rechten aenderbar machen, wenn man das Recht für Globale Einstellungen hat
sortieren und filtern nicht im Localstorage speichern, wenn es leer ist (bspw. bei Änderung einer Liste)

*/
