const STATUS_SPINNER_CLASS = "spinner-border spinner-border-sm";
const STATUS_SPINNER_HTML = '<span class="' + STATUS_SPINNER_CLASS + '" role="status"><span class="visually-hidden">Loading...</span></span>';

const TOASTS = new Object();
const BESTAETIGUNGEN = new Object();

function Schnittstelle_DomInit() {
    const STATUS_STANDARD_HTML = $("#status").html();

    TOASTS.$blanko_toast = $("#toasts").find(".blanko").first();
    $("#toasts").empty();

    BESTAETIGUNGEN.$blanko_bestaetigung = $("#modals").find(".modal.bestaetigung").first();
    $("#modals").find(".modal.bestaetigung").remove();

    $("#modals")
        .find(".modal.autoload")
        .each(function () {
            Schnittstelle_DomModalOeffnen($(this));
        });

    $(document).ajaxStart(function () {
        $("#status").html(STATUS_SPINNER_HTML);
    });

    $(document).ajaxStop(function () {
        $("#status").html(STATUS_STANDARD_HTML);
    });

    $(document).ajaxSuccess(function () {
        $("#status").removeClass("text-danger");
        $("#status").addClass("text-success");
    });

    $(document).ajaxError(function () {
        $("#status").removeClass("text-success");
        $("#status").addClass("text-danger");
    });

    $(window).on("beforeunload", function () {
        $("#status").html(STATUS_SPINNER_HTML);
    });

    $(".jetzt").each(function () {
        Schnittstelle_JetztAktualisieren($(this));
    });

    // WERKZEUGKASTEN (OFFCANVAS) ÖFFNEN
    $(document).on("show.bs.offcanvas", "#werkzeugkasten", function (event) {
        const $werkzeugkasten = $(this).find(".werkzeugkasten");
        const $btn_oeffnend = $(event.relatedTarget);
        const liste = $btn_oeffnend.attr("data-liste");
        const element_id = $btn_oeffnend.attr("data-element_id");

        $werkzeugkasten.find(".werkzeug").removeAttr("data-element_id");

        if (typeof liste !== "undefined" && typeof element_id !== "undefined")
            $werkzeugkasten.find(".werkzeug").each(function () {
                const $werkzeug = $(this);
                if ($werkzeug.attr("data-liste") == liste) $werkzeug.attr("data-element_id", element_id);
            });
    });

    $(document).on("hidden.bs.modal", ".modal", function () {
        const $modal = $(this);
        const $umgebung = $modal.parent();
        const $letztes_wartendes_modal = $umgebung.find(".modal.warten:last");

        if (!$modal.hasClass("warten")) $modal.remove();

        if (!$umgebung.find(".modal.show").exists() && $letztes_wartendes_modal.exists()) {
            $letztes_wartendes_modal.removeClass("warten");
            Schnittstelle_DomModalOeffnen($letztes_wartendes_modal);
        }
    });

    $(document).on("hidden.bs.toast", ".toast", function () {
        $(this).remove();
    });

    // PASSWORT ANZEIGEN
    $(document).on("click", ".btn_passwort_anzeigen", function (event) {
        const $btn_passwort_anzeigen = $(this);
        event.preventDefault();
        const feld = $btn_passwort_anzeigen.closest(".input-group").find("input.form-control");

        if (feld.attr("type") == "text") {
            feld.attr("type", "password");
            $btn_passwort_anzeigen.find("i").removeClass("bi-" + SYMBOLE["sichtbar"]["bootstrap"]);
            $btn_passwort_anzeigen.find("i").addClass("bi-" + SYMBOLE["unsichtbar"]["bootstrap"]);
        } else if (feld.attr("type") == "password") {
            feld.attr("type", "text");
            $btn_passwort_anzeigen.find("i").removeClass("bi-" + SYMBOLE["unsichtbar"]["bootstrap"]);
            $btn_passwort_anzeigen.find("i").addClass("bi-" + SYMBOLE["sichtbar"]["bootstrap"]);
        }
    });

    // INHALT KOPIEREN
    const CLIPBOARD = new ClipboardJS(".btn_inhalt_kopieren");

    CLIPBOARD.on("success", function (event) {
        Schnittstelle_DomToastFeuern("Kopieren in die Zwischenablage war erfolgreich.");
    });

    CLIPBOARD.on("error", function (event) {
        Schnittstelle_DomToastFeuern("Kopieren in die Zwischenablage ist fehlgeschlagen.", "danger");
    });

    // VALIDATION-TOOLTIPS ENTFERNEN
    $(document).on("focus", "input, select", function () {
        $(this).next(".invalid-tooltip").remove();
    });

    // COLLAPSE ÖFFNEN
    $(document).on("show.bs.collapse", ".collapse.auswertung_collapse, .collapse.verzeichnis_collapse", function (event) {
        const $collapse = $(this);

        if ($collapse.is(event.target)) {
            $('.toggle_symbol[data-bs-target="#' + $collapse.attr("id") + '"]').each(function () {
                Schnittstelle_ToggleSymbol($(this));
            });
        }
    });
    $(document).on("show.bs.collapse", ".collapse.tab_collapse", function (event) {
        const $collapse = $(this);

        if ($collapse.is(event.target)) {
            $('.nav-item[data-bs-target="#' + $collapse.attr("id") + '"]').each(function () {
                const $toggle = $(this);

                $toggle.removeAttr("data-bs-toggle");
                $toggle.find(".nav-link").addClass("active");

                $toggle
                    .closest(".nav-tabs")
                    .find(".nav-item")
                    .each(function () {
                        const $anderes_toggle = $(this);
                        if ($anderes_toggle.attr("data-bs-target") != $toggle.attr("data-bs-target")) {
                            $anderes_toggle.attr("data-bs-toggle", "collapse");
                            $anderes_toggle.find(".nav-link").removeClass("active");
                        }
                    });
            });
        }
    });

    // COLLAPSE SCHLIESSEN
    $(document).on("hide.bs.collapse", ".collapse.auswertung_collapse, .collapse.verzeichnis_collapse", function (event) {
        const $collapse = $(this);

        if ($collapse.is(event.target)) {
            $('.toggle_symbol[data-bs-target="#' + $collapse.attr("id") + '"]').each(function () {
                Schnittstelle_ToggleSymbol($(this));
            });
        }
    });
}

function Schnittstelle_BtnWartenStart($btn_warten) {
    const beschriftung = $btn_warten.html();
    $btn_warten.attr("data-beschriftung", beschriftung);
    $btn_warten.html(STATUS_SPINNER_HTML);

    $btn_warten.prop("disabled", true);
}

function Schnittstelle_BtnWartenEnde($btn_warten) {
    $btn_warten.prop("disabled", false);

    const beschriftung = $btn_warten.attr("data-beschriftung");
    $btn_warten.prop("data-beschriftung", false);
    $btn_warten.html(beschriftung);
}

function Schnittstelle_BtnDanebenWartenStart($btn_daneben_warten) {
    $btn_daneben_warten.after(STATUS_SPINNER_HTML);

    $btn_daneben_warten.addClass("invisible");
    $btn_daneben_warten.prop("disabled", true);
}

function Schnittstelle_BtnDanebenWartenEnde($btn_daneben_warten) {
    $btn_daneben_warten.prop("disabled", false);
    $btn_daneben_warten.removeClass("invisible");

    $btn_daneben_warten.siblings("." + STATUS_SPINNER_CLASS).remove();
}

function Schnittstelle_CheckWartenStart($check) {
    $check.prop("disabled", true);

    const $check_beschriftung = $check.siblings(".beschriftung");
    const beschriftung = $check_beschriftung.html();
    $check_beschriftung.attr("data-beschriftung", beschriftung);
    $check_beschriftung.html(STATUS_SPINNER_HTML);
    $check_beschriftung.addClass("text-primary");
}

function Schnittstelle_CheckWartenEnde($check) {
    const $check_beschriftung = $check.siblings(".beschriftung");
    const beschriftung = $check_beschriftung.attr("data-beschriftung");
    $check_beschriftung.prop("data-beschriftung", false);
    $check_beschriftung.removeClass("text-primary");
    $check_beschriftung.html(beschriftung);

    $check.prop("disabled", false);
}

function Schnittstelle_JetztAktualisieren($jetzt) {
    let format = "dd.MM.yyyy HH:mm:ss";
    const data_format = $jetzt.attr("data-format");
    if (typeof data_format !== "undefined") format = $jetzt.attr("data-format");
    $jetzt.text(DateTime.now().toFormat(format));
}

function Schnittstelle_ToggleSymbol($symbol) {
    const toggle_symbol_neu = $symbol.attr("data-toggle_symbol");

    let toggle_symbol_alt = undefined;
    $.each($symbol.attr("class").split(/\s+/), function (position, klasse) {
        if (klasse.slice(0, 3) == "bi-") {
            toggle_symbol_alt = klasse.slice(3, klasse.length);
            return false;
        }
    });

    if (typeof toggle_symbol_alt !== "undefined" && typeof toggle_symbol_neu !== "undefined")
        $symbol
            .removeClass("bi-" + toggle_symbol_alt)
            .addClass("bi-" + toggle_symbol_neu)
            .attr("data-toggle_symbol", toggle_symbol_alt);
}
