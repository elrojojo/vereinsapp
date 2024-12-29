function Termine_TerminrueckmeldungEinAusblenden($terminrueckmeldung_eingeladen) {
    const $termin = $terminrueckmeldung_eingeladen.closest('.element[data-liste="termine"]');

    if ($termin.exists() && "tabelle" in LISTEN.termine) {
        const termin = LISTEN.termine.tabelle[Number($termin.attr("data-element_id"))];
        const $terminrueckmeldung_nicht_eingeladen = $terminrueckmeldung_eingeladen.siblings(".terminrueckmeldung_nicht_eingeladen").first();

        if (termin.ich_eingeladen) {
            $terminrueckmeldung_eingeladen.removeClass("invisible");
            $terminrueckmeldung_nicht_eingeladen.addClass("invisible");
        } else {
            $terminrueckmeldung_eingeladen.addClass("invisible");
            $terminrueckmeldung_nicht_eingeladen.removeClass("invisible");
        }
    }
}
