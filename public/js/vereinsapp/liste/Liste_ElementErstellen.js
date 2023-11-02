function Liste_ElementErstellen($btn, liste) {
    const btn_beschriftung = $btn.html();
    const aktion = $btn.attr("data-aktion");
    const $formular = $btn.parents(".formular").first();
    const element = $btn.attr("data-element");
    const element_id = $btn.attr("data-element_id");

    const AJAX_DATA = new Object();
    if (typeof element_id !== "undefined") AJAX_DATA.id = element_id;
    const data_werte = $btn.attr("data-werte");
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

    // AJAX IN DIE SCHLANGE
    $.ajaxQueue({
        url: BASE_URL + "/" + LISTEN[liste].controller + "/ajax_" + element + "_" + aktion,
        method: "post",
        data: AJAX_DATA,
        dataType: "json",
        beforeSend: function () {
            $btn.html(STATUS_SPINNER_HTML).prop("disabled", true);
        },
        success: function (antwort) {
            G.CSRF[CSRF_NAME] = antwort[CSRF_NAME];

            // WENN DIE VALIDATION FEHLSCHLÄGT
            if (typeof antwort.validation !== "undefined") {
                console.log("FEHLER " + element + " " + aktion + ": validation -> " + JSON.stringify(antwort.validation));
                $formular.find(".eigenschaft").each(function () {
                    const $eigenschaft = $(this);
                    const eigenschaft = $eigenschaft.attr("data-eigenschaft");

                    if (typeof antwort.validation[eigenschaft] !== "undefined") {
                        $eigenschaft.addClass("is-invalid").removeClass("is-valid");
                        $eigenschaft.after('<div class="invalid-tooltip">' + antwort.validation[eigenschaft] + "</div>");
                    } else {
                        $eigenschaft.addClass("is-valid").removeClass("is-invalid");
                    }
                });
            }

            // WENN DIE VALIDATION ERFOLGREICH DURCHLÄUFT
            else {
                if (typeof antwort.info !== "undefined") console.log(JSON.stringify(antwort.info)); //console.log( 'ERFOLG '+element+' '+aktion );

                if (typeof element_id === "undefined") {
                    AJAX_DATA["id"] = LISTEN[liste].tabelle.length + 1;
                    LISTEN[liste].tabelle[AJAX_DATA["id"]] = new Object();
                }

                $.each(AJAX_DATA, function (eigenschaft, wert) {
                    if (wert && !Number.isNaN(Number(wert)) && typeof wert !== "boolean") wert = Number(wert);
                    if (
                        typeof EIGENSCHAFTEN[LISTEN[liste].controller][liste][eigenschaft] !== "undefined" &&
                        EIGENSCHAFTEN[LISTEN[liste].controller][liste][eigenschaft]["typ"] == "zeitpunkt"
                    )
                        wert = DateTime.fromFormat(wert, SQL_DATETIME);
                    LISTEN[liste].tabelle[AJAX_DATA["id"]][eigenschaft] = wert;
                });

                $(document).trigger("VAR_upd_LOC", [liste]); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR );

                $btn.parents(".modal").first().modal("hide");
            }
        },
        error: function (xhr) {
            console.log("FEHLER " + element + " " + aktion + ": " + xhr.status + " " + xhr.statusText);
        },
        complete: function () {
            $btn.html(btn_beschriftung).prop("disabled", false);
        },
    });

    // SCHNITTSTELLE AJAX -> PHP
    // Schnittstelle_AjaxRaus({
    //     id: element + " " + aktion,
    //     $btn: $btn,
    //     url: LISTEN[liste].controller + "/ajax_" + element + "_" + aktion,
    //     methode: "post", // mapping dataType json
    //     data: AJAX_DATA,
    //     vorher_aktion: function () {
    //         $btn.html(STATUS_SPINNER_HTML).prop("disabled", true);
    //     },
    //     validation_negativ_aktion: function () {
    //         $formular.find(".eigenschaft").each(function () {
    //             const $eigenschaft = $(this);
    //             const eigenschaft = $eigenschaft.attr("data-eigenschaft");

    //             if (typeof antwort.validation[eigenschaft] !== "undefined") {
    //                 $eigenschaft.addClass("is-invalid").removeClass("is-valid");
    //                 $eigenschaft.after('<div class="invalid-tooltip">' + antwort.validation[eigenschaft] + "</div>");
    //             } else {
    //                 $eigenschaft.addClass("is-valid").removeClass("is-invalid");
    //             }
    //         });
    //     },
    //     validation_positiv_aktion: function () {
    //         if (typeof element_id === "undefined") {
    //             AJAX_DATA["id"] = LISTEN[liste].tabelle.length + 1;
    //             LISTEN[liste].tabelle[AJAX_DATA["id"]] = new Object();
    //         }

    //         $.each(AJAX_DATA, function (eigenschaft, wert) {
    //             if (wert && !Number.isNaN(Number(wert)) && typeof wert !== "boolean") wert = Number(wert);
    //             if (
    //                 typeof EIGENSCHAFTEN[LISTEN[liste].controller][liste][eigenschaft] !== "undefined" &&
    //                 EIGENSCHAFTEN[LISTEN[liste].controller][liste][eigenschaft]["typ"] == "zeitpunkt"
    //             )
    //                 wert = DateTime.fromFormat(wert, SQL_DATETIME);
    //             LISTEN[liste].tabelle[AJAX_DATA["id"]][eigenschaft] = wert;
    //         });

    //         $(document).trigger("VAR_upd_LOC", [liste]); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR );

    //         $btn.parents(".modal").first().modal("hide");
    //     },
    //     nachher_aktion: function () {
    //         $btn.html(btn_beschriftung).prop("disabled", false);
    //     },
    // });
}
