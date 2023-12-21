const DateTime = luxon.DateTime;

const G = {
    AJAX: [],

    LISTEN: {},

    CSRF: { [CSRF_NAME]: ERSTER_CSRF_HASH },

    DEBUG: { aktiv: false, zaehler: 0, spot_id: 0 },
};

$(document).ready(function () {
    Schnittstelle_DomWartenInit();

    Liste_Init();

    //POPOVER AKTIVIEREN
    // $('[data-toggle="popover"]').popover();

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
                $("#datenschutz_richtlinie_modal").modal("show");
                $("#datenschutz_richtlinie_akzeptieren").click(function () {
                    Schnittstelle_LocalstorageRein("datenschutz_richtlinie_" + DATENACHUTZ_RICHTLINIE_DATUM, DateTime.now());
                    console.log("ERFOLG", "Datenschutz-Richtlinie akzeptiert");
                    $("#datenschutz_richtlinie_modal").modal("hide");
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

    // EIGENSCHAFT-INPUTS UND -SELECTS MIT STANDARDWERTEN BEFÜLLEN
    // $('input.eigenschaft select.eigenschaft').each( function() { const $eigenschaft = $(this); const eigenschaft = $eigenschaft.attr('data-eigenschaft');
    //     if( $eigenschaft.attr('type') == 'date' ) $eigenschaft.val( DateTime.now().toISODate() );
    //     if( $eigenschaft.attr('type') == 'time' ) $eigenschaft.val( DateTime.now().toISOTime() );
    //     // ...
    //     $eigenschaft.change();
    // } );

    //LOCALSTORAGE LEEREN
    $(".navbar-text").click(function () {
        localStorage.clear();
        alert("localStorage geleert.");
    });
});

$.fn.exists = function () {
    return this.length !== 0;
};

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
function unix2umlaute(umlaute) {
    $.each(UMLAUTE_KONVERTIERUNG, function (index, konvertierung) {
        umlaute = umlaute.replaceAll(konvertierung[1], konvertierung[0]);
    });
    return umlaute;
}
function umlaute2unix(unix) {
    $.each(UMLAUTE_KONVERTIERUNG, function (index, konvertierung) {
        unix = unix.replaceAll(konvertierung[0], konvertierung[1]);
    });
    return unix;
}

function bezeichnung_kapitalisieren(bezeichnung) {
    return bezeichnung.substring(0, 1).toUpperCase() + bezeichnung.substring(1);
}

function HTML_time(zeitstempel) {}

function HTML_date(zeitpunkt) {
    return new Date(zeitpunkt * 1000).toLocaleDateString("en-CA");
}

function HTML_datetime_local(zeitstempel) {
    return strval(date("Y-m-dTH:i", $zeitstempel));
}

/* TODO
Zusatzsymbole in Mitglieder-Liste durch Bootstrap-Icons ersetzen
Richtung der Sortierung änderbar machen
Rückmeldung feuern bei Erfolg/Misserfolg einer Aktion
sortieren und filtern nicht im Localstorage speichern, wenn es leer ist (bspw. bei Änderung einer Liste)
Checkliste bei leerem LocalStorage korrekt anzeigen

*/
