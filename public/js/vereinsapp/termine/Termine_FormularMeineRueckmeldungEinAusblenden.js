function Termine_FormularMeineRueckmeldungEinAusblenden($formular_meine_rueckmeldung) {
    const $termin = $formular_meine_rueckmeldung.closest('.element[data-liste="termine"]');

    if ($termin.exists() && "tabelle" in G.LISTEN.termine) {
        const termin = G.LISTEN.termine.tabelle[Number($termin.attr("data-element_id"))];
        const $formular_meine_rueckmeldung_nicht_eingeladen = $formular_meine_rueckmeldung
            .siblings(".formular_meine_rueckmeldung_nicht_eingeladen")
            .first();

        if (termin.ich_eingeladen) {
            $formular_meine_rueckmeldung.removeClass("invisible");
            $formular_meine_rueckmeldung_nicht_eingeladen.addClass("invisible");
        } else {
            $formular_meine_rueckmeldung.addClass("invisible");
            $formular_meine_rueckmeldung_nicht_eingeladen.removeClass("invisible");
        }
    }
}
