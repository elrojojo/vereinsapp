function Termine_FormularMeineRueckmeldungEinAusblenden($rueckmeldung) {
    const $rueckmeldung_nicht_eingeladen = $rueckmeldung.siblings(".rueckmeldung_nicht_eingeladen").closest();
    const element_id = Number($rueckmeldung.parents(".termin").closest().attr("data-element_id"));

    if (G.LISTEN.termine.tabelle[element_id].ich_eingeladen) {
        $rueckmeldung.removeClass("invisible");
        $rueckmeldung_nicht_eingeladen.addClass("invisible");
    } else {
        $rueckmeldung.addClass("invisible");
        $rueckmeldung_nicht_eingeladen.removeClass("invisible");
    }
}
