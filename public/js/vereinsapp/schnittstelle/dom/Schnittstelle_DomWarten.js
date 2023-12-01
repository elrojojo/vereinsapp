const STATUS_SPINNER_CLASS = "spinner-border spinner-border-sm";
const STATUS_SPINNER_HTML = '<span class="' + STATUS_SPINNER_CLASS + '" role="status"><span class="visually-hidden">Loading...</span></span>';

$(document).ready(function () {
    const STATUS_STANDARD_HTML = $("#status").html();

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
});

function Schnittstelle_BtnWartenStart($btn) {
    const beschriftung = $btn.html();
    $btn.attr("data-beschriftung", beschriftung);
    $btn.html(STATUS_SPINNER_HTML);

    $btn.prop("disabled", true);
}

function Schnittstelle_BtnWartenEnde($btn) {
    $btn.prop("disabled", false);

    const beschriftung = $btn.attr("data-beschriftung");
    $btn.prop("data-beschriftung", false);
    $btn.html(beschriftung);
}

function Schnittstelle_BtnDanebenWartenStart($btn) {
    $btn.after(STATUS_SPINNER_HTML);

    $btn.addClass("invisible");
    $btn.prop("disabled", true);
}

function Schnittstelle_BtnDanebenWartenEnde($btn) {
    $btn.prop("disabled", false);
    $btn.removeClass("invisible");

    $btn.siblings("." + STATUS_SPINNER_CLASS).remove();
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
