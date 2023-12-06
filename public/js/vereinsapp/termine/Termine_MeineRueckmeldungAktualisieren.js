function Termine_MeineRueckmeldungAktualisieren($btn_rueckmelden) {
    const $btn_rueckmeldung_detaillieren = $btn_rueckmelden.siblings(".btn_rueckmeldung_detaillieren");
    const termin_id = Number($btn_rueckmelden.closest('.element[data-element="termin"]').attr("data-element_id"));

    if ("tabelle" in G.LISTEN.termine) {
        let ich_rueckmeldung_id = G.LISTEN.termine.tabelle[termin_id].ich_rueckmeldung_id;

        if (typeof ich_rueckmeldung_id === "undefined") ich_rueckmeldung_id = null;

        if (ich_rueckmeldung_id !== null) $btn_rueckmelden.attr("data-element_id", ich_rueckmeldung_id).attr("data-aktion", "aendern");
        else {
            let data_werte = $btn_rueckmelden.attr("data-werte");

            if (typeof data_werte !== "undefined") data_werte = JSON.parse(data_werte);
            else data_werte = new Object();

            data_werte.termin_id = termin_id;

            $btn_rueckmelden.attr("data-werte", JSON.stringify(data_werte));
        }

        if ($btn_rueckmelden.hasClass("zusagen")) {
            if (ich_rueckmeldung_id !== null && G.LISTEN.rueckmeldungen.tabelle[ich_rueckmeldung_id].status >= 1) {
                $btn_rueckmelden
                    .prop("disabled", true)
                    .removeClass("w-100")
                    .addClass("w-75")
                    .removeClass("btn-outline-success")
                    .addClass("btn-success")
                    .removeClass("rounded-end")
                    .removeClass("rounded-pill")
                    .addClass("rounded-0")
                    .text("ZUGESAGT");

                $btn_rueckmeldung_detaillieren.removeClass("invisible").attr("data-element_id", ich_rueckmeldung_id);

                const bemerkung = G.LISTEN.rueckmeldungen.tabelle[ich_rueckmeldung_id].bemerkung;
                if (typeof bemerkung !== "undefined" && bemerkung != null && bemerkung != "")
                    $btn_rueckmeldung_detaillieren.removeClass("btn-outline-success").addClass("btn-success");
                else $btn_rueckmeldung_detaillieren.addClass("btn-outline-success").removeClass("btn-success");
            } else {
                $btn_rueckmelden
                    .prop("disabled", false)
                    .removeClass("w-75")
                    .addClass("w-100")
                    .removeClass("btn-success")
                    .addClass("btn-outline-success")
                    .removeClass("rounded-0")
                    .addClass("rounded-end")
                    .addClass("rounded-pill")
                    .text("ZUSAGEN");

                $btn_rueckmeldung_detaillieren.addClass("invisible").removeClass("btn-success").addClass("btn-outline-success");
            }
        } else if ($btn_rueckmelden.hasClass("absagen")) {
            if (ich_rueckmeldung_id !== null && G.LISTEN.rueckmeldungen.tabelle[ich_rueckmeldung_id].status == 0) {
                $btn_rueckmelden
                    .prop("disabled", true)
                    .removeClass("w-100")
                    .addClass("w-75")
                    .removeClass("btn-outline-danger")
                    .addClass("btn-danger")
                    .removeClass("rounded-start")
                    .removeClass("rounded-pill")
                    .addClass("rounded-0")
                    .text("ABGESAGT");

                $btn_rueckmeldung_detaillieren.removeClass("invisible").attr("data-element_id", ich_rueckmeldung_id);

                const bemerkung = G.LISTEN.rueckmeldungen.tabelle[ich_rueckmeldung_id].bemerkung;
                if (typeof bemerkung !== "undefined" && bemerkung != null && bemerkung != "")
                    $btn_rueckmeldung_detaillieren.removeClass("btn-outline-danger").addClass("btn-danger");
                else $btn_rueckmeldung_detaillieren.addClass("btn-outline-danger").removeClass("btn-danger");
            } else {
                $btn_rueckmelden
                    .prop("disabled", false)
                    .removeClass("w-75")
                    .addClass("w-100")
                    .removeClass("btn-danger")
                    .addClass("btn-outline-danger")
                    .removeClass("rounded-0")
                    .addClass("rounded-start")
                    .addClass("rounded-pill")
                    .text("ABSAGEN");

                $btn_rueckmeldung_detaillieren.addClass("invisible").removeClass("btn-danger").addClass("btn-outline-danger");
            }
        }
    }
}
