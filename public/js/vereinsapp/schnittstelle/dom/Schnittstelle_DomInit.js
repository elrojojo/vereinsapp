const STATUS_SPINNER_CLASS = "spinner-border spinner-border-sm";
const STATUS_SPINNER_HTML = '<span class="' + STATUS_SPINNER_CLASS + '" role="status"><span class="visually-hidden">Loading...</span></span>';

function Schnittstelle_DomInit() {
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

    $(".jetzt").each(function () {
        Schnittstelle_JetztAktualisieren($(this));
    });

    // WERKZEUGKASTEN (OFFCANVAS) ÖFFNEN
    $("#werkzeugkasten").on("show.bs.offcanvas", function (event) {
        const $werkzeugkasten = $(this).find(".werkzeugkasten");
        const $btn_oeffnend = $(event.relatedTarget);
        const liste = $btn_oeffnend.attr("data-liste");
        const element_id = $btn_oeffnend.attr("data-element_id");

        $werkzeugkasten.find(".werkzeug").removeAttr("data-element_id");
        $werkzeugkasten.find(".werkzeug").removeAttr("data-gegen_element_id");

        if (typeof liste !== "undefined" && typeof element_id !== "undefined")
            $werkzeugkasten.find(".werkzeug").each(function () {
                const $werkzeug = $(this);
                if ($werkzeug.attr("data-liste") == liste) $werkzeug.attr("data-element_id", element_id);
                else $werkzeug.attr("data-gegen_element_id", element_id);
            });
    });

    // AKTIVE MODALS WERDEN GETRACKED
    $(".modal").on("show.bs.modal", function (event) {
        const $modal = $(this);
        const modal_id = $modal.attr("id");
        const $btn_oeffnend = $(event.relatedTarget);

        const title_modal = $modal.find(".modal-title").first().attr("data-title");
        if (typeof title_modal !== "undefined") $modal.find(".modal-title").html(title_modal);
        else {
            const title_btn = $btn_oeffnend.attr("data-title");
            if (typeof title_btn !== "undefined") {
                $modal.find(".modal-title").attr("data-title", title_btn);
                $modal.find(".modal-title").text(title_btn);
            } else $modal.find(".modal-title").text("ERROR: Hier fehlt ein Titel");
        }

        if (G.MODALS.offen.length == 0 || G.MODALS.offen[G.MODALS.offen.length - 1].modal_id != modal_id) {
            G.MODALS.offen.push({ modal_id: modal_id, $btn_oeffnend: $btn_oeffnend });
        }
    });

    $(".modal").on("hidden.bs.modal", function () {
        const $modal = $(this);

        const title_modal = $modal.find(".modal-title").html();
        if (typeof title_modal !== "undefined") $modal.find(".modal-title").first().attr("data-title", title_modal);

        if ($modal.attr("id") == G.MODALS.offen[G.MODALS.offen.length - 1].modal_id) {
            G.MODALS.offen.pop();
            if (G.MODALS.offen.length > 0) $("#" + G.MODALS.offen[G.MODALS.offen.length - 1].modal_id).modal("show");
        }
    });
}

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

function Schnittstelle_JetztAktualisieren($jetzt) {
    let format = "dd.MM.yyyy HH:mm:ss";
    const data_format = $jetzt.attr("data-format");
    if (typeof data_format !== "undefined") format = $jetzt.attr("data-format");
    $jetzt.text(DateTime.now().toFormat(format));
}
