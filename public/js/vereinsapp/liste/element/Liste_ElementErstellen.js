function Liste_ElementErstellen($btn, liste) {
    const element = $btn.attr("data-element");
    const element_id = $btn.attr("data-element_id");
    const aktion = $btn.attr("data-aktion");
    const data_werte = $btn.attr("data-werte");

    const AJAX_DATA = new Object();
    if (typeof element_id !== "undefined") AJAX_DATA.id = element_id;
    if (typeof data_werte !== "undefined")
        $.each(JSON.parse(data_werte), function (eigenschaft, wert) {
            AJAX_DATA[eigenschaft] = wert;
        });

    // WERTE AUS DEM FORMULAR
    $btn.closest(".formular")
        .find(".eigenschaft")
        .each(function () {
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
                    wert =
                        DateTime.fromFormat(AJAX_DATA[eigenschaft], SQL_DATETIME).toFormat(SQL_DATE) +
                        " " +
                        DateTime.fromISO(wert).toFormat(SQL_TIME);
                else wert = DateTime.fromISO(wert).toFormat(SQL_DATETIME);
            }
            AJAX_DATA[eigenschaft] = wert;

            $eigenschaft.removeClass("is-valid").removeClass("is-invalid");
            $eigenschaft.find(".invalid-tooltip").remove();
        });

    const neue_ajax_id = G.AJAX.length;
    G.AJAX[neue_ajax_id] = {
        ajax_id: neue_ajax_id,
        label: element + "_" + aktion,
        url: G.LISTEN[liste].controller + "/ajax_" + element + "_" + aktion,
        data: AJAX_DATA,
        liste: liste,
        $btn: $btn,
        warten_auf: neue_ajax_id,
        raus_aktion: function (AJAX) {
            Schnittstelle_BtnWartenStart(AJAX.$btn);
        },
        rein_validation_neg_aktion: function (AJAX) {
            AJAX.$btn
                .closest(".formular")
                .find(".eigenschaft")
                .each(function () {
                    const $eigenschaft = $(this);
                    const eigenschaft = $eigenschaft.attr("data-eigenschaft");

                    if (eigenschaft in AJAX.antwort.validation) {
                        $eigenschaft.addClass("is-invalid").removeClass("is-valid");
                        $eigenschaft.after('<div class="invalid-tooltip">' + AJAX.antwort.validation[eigenschaft] + "</div>");
                    } else {
                        $eigenschaft.addClass("is-valid").removeClass("is-invalid");
                    }
                });
        },
        rein_validation_pos_aktion: function (AJAX) {
            if (typeof AJAX.data.id === "undefined") {
                AJAX.data.id = G.LISTEN[AJAX.liste].tabelle.length + 1;
                G.LISTEN[AJAX.liste].tabelle[AJAX.data.id] = new Object();
            }
            $.each(AJAX.data, function (eigenschaft, wert) {
                if (eigenschaft != "ajax_id" && eigenschaft != CSRF_NAME)
                    G.LISTEN[AJAX.liste].tabelle[AJAX.data.id][eigenschaft] = Schnittstelle_VariableWertBereinigtZurueck(wert);
            });
            Schnittstelle_EventVariableUpdLocalstorage(AJAX.liste, [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);
            AJAX.$btn.closest(".formular").modal("hide");
        },
        rein_aktion: function (AJAX) {
            Schnittstelle_BtnWartenEnde(AJAX.$btn);
        },
    };

    Schnittstelle_AjaxInDieSchlange(G.AJAX[neue_ajax_id]);
}
