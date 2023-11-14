function Liste_ElementErstellen($btn, liste) {
    const element = $btn.attr("data-element");
    const element_id = $btn.attr("data-element_id");
    const aktion = $btn.attr("data-aktion");
    const data_werte = $btn.attr("data-werte");
    const $formular = $btn.parents(".formular").first();

    const AJAX_DATA = new Object();
    if (typeof element_id !== "undefined") AJAX_DATA.id = element_id;
    if (typeof data_werte !== "undefined")
        $.each(JSON.parse(data_werte), function (eigenschaft, wert) {
            AJAX_DATA[eigenschaft] = wert;
        });

    // WERTE AUS DEM FORMULAR
    $formular.find(".eigenschaft").each(function () {
        const $eigenschaft = $(this);
        const eigenschaft = $eigenschaft.attr("data-eigenschaft");

        let wert = $eigenschaft.val();
        if ($eigenschaft.attr("type") == "date") {
            wert = DateTime.fromISO(wert);
            if (eigenschaft == "ende") {
                wert = wert.plus({ days: 1 }).minus({ seconds: 1 });
            }
            wert = wert.toFormat(SQL_DATETIME);
        } else if ($eigenschaft.attr("type") == "time") {
            if (typeof AJAX_DATA[eigenschaft] !== "undefined ")
                wert = DateTime.fromFormat(AJAX_DATA[eigenschaft], SQL_DATETIME).toFormat(SQL_DATE) + " " + DateTime.fromISO(wert).toFormat(SQL_TIME);
            else wert = DateTime.fromISO(wert).toFormat(SQL_DATETIME);
        }
        AJAX_DATA[eigenschaft] = wert;

        $eigenschaft.removeClass("is-valid").removeClass("is-invalid");
        $eigenschaft.find(".invalid-tooltip").remove();
    });

    const neue_ajax_id = G.AJAX.length;
    G.AJAX[neue_ajax_id] = {
        id: element + "_" + aktion,
        url: LISTEN[liste].controller + "/ajax_" + element + "_" + aktion,
        data: AJAX_DATA,
        liste: liste,
        DOM: { $btn: $btn, btn_beschriftung: $btn.html() },
        raus_aktion: function (AJAX) {
            AJAX.DOM.$btn.html(STATUS_SPINNER_HTML).prop("disabled", true);
        },
        rein_validation_neg_aktion: function (AJAX) {
            const $formular = AJAX.DOM.$btn.parents(".formular").first();
            $formular.find(".eigenschaft").each(function () {
                const $eigenschaft = $(this);
                const eigenschaft = $eigenschaft.attr("data-eigenschaft");

                if (typeof AJAX.antwort.validation[eigenschaft] !== "undefined") {
                    $eigenschaft.addClass("is-invalid").removeClass("is-valid");
                    $eigenschaft.after('<div class="invalid-tooltip">' + AJAX.antwort.validation[eigenschaft] + "</div>");
                } else {
                    $eigenschaft.addClass("is-valid").removeClass("is-invalid");
                }
            });
        },
        rein_validation_pos_aktion: function (AJAX) {
            if (typeof AJAX.data.id === "undefined") {
                AJAX.data.id = LISTEN[AJAX.liste].tabelle.length + 1;
                LISTEN[AJAX.liste].tabelle[AJAX.data.id] = new Object();
            }

            $.each(AJAX.data, function (eigenschaft, wert) {
                if (wert && !Number.isNaN(Number(wert)) && typeof wert !== "boolean") wert = Number(wert);
                if (
                    typeof EIGENSCHAFTEN[LISTEN[AJAX.liste].controller][AJAX.liste][eigenschaft] !== "undefined" &&
                    EIGENSCHAFTEN[LISTEN[AJAX.liste].controller][AJAX.liste][eigenschaft]["typ"] == "zeitpunkt"
                )
                    wert = DateTime.fromFormat(wert, SQL_DATETIME);
                LISTEN[AJAX.liste].tabelle[AJAX.data.id][eigenschaft] = wert;
            });

            $(document).trigger("VAR_upd_LOC", [AJAX.liste]); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR );

            const $formular = AJAX.DOM.$btn.parents(".formular").first();
            $formular.modal("hide");
        },
        rein_aktion: function (AJAX) {
            AJAX.DOM.$btn.html(AJAX.DOM.btn_beschriftung).prop("disabled", false);
        },
    };

    Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
}
