function Termine_RueckmeldungAktualisieren($btn_rueckmelden) {
    const $btn_rueckmeldung_detaillieren = $btn_rueckmelden.siblings(".btn_rueckmeldung_detaillieren");

    let data_werte = $btn_rueckmelden.attr("data-werte");
    if (typeof data_werte !== "undefined") data_werte = JSON.parse(data_werte);
    else data_werte = new Object();

    if (!("mitglied_id" in data_werte)) data_werte.mitglied_id = null;
    else {
        /* FEHLER */
    }
    const mitglied_id = Number(data_werte.mitglied_id);

    const termin_id = Number($btn_rueckmelden.closest('.element[data-liste="termine"]').attr("data-element_id"));

    let element_id = $btn_rueckmelden.attr("data-element_id");
    if (typeof element_id !== "undefined") element_id = Number(element_id);
    else element_id = Termine_RueckmeldungIdZurueck(termin_id, mitglied_id);

    if ($btn_rueckmelden.hasClass("zusagen")) {
        $btn_rueckmelden.attr("data-werte", JSON.stringify({ termin_id: termin_id, mitglied_id: mitglied_id, bemerkung: "", status: 1 }));

        if (element_id !== null && G.LISTEN.rueckmeldungen.tabelle[element_id].status >= 1) {
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

            $btn_rueckmeldung_detaillieren.removeClass("invisible").attr("data-element_id", element_id);

            const bemerkung = G.LISTEN.rueckmeldungen.tabelle[element_id].bemerkung;
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
            if (element_id !== null) $btn_rueckmelden.attr("data-element_id", element_id).attr("data-aktion", "aendern");

            $btn_rueckmeldung_detaillieren.addClass("invisible").removeClass("btn-success").addClass("btn-outline-success");
        }
    } else if ($btn_rueckmelden.hasClass("absagen")) {
        $btn_rueckmelden.attr("data-werte", JSON.stringify({ termin_id: termin_id, mitglied_id: mitglied_id, bemerkung: "", status: 0 }));

        if (element_id !== null && G.LISTEN.rueckmeldungen.tabelle[element_id].status == 0) {
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

            $btn_rueckmeldung_detaillieren.removeClass("invisible").attr("data-element_id", element_id);

            const bemerkung = G.LISTEN.rueckmeldungen.tabelle[element_id].bemerkung;
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
            if (element_id !== null) $btn_rueckmelden.attr("data-element_id", element_id).attr("data-aktion", "aendern");

            $btn_rueckmeldung_detaillieren.addClass("invisible").removeClass("btn-danger").addClass("btn-outline-danger");
        }
    } else {
        /* FEHLER */
    }

    if (G.LISTEN.termine.tabelle[termin_id].start < DateTime.now()) {
        $btn_rueckmelden.prop("disabled", true);
        $btn_rueckmeldung_detaillieren.prop("disabled", true);
    }
}
