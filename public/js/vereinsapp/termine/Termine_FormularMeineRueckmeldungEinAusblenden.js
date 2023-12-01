function Termine_FormularMeineRueckmeldungEinAusblenden($rueckmeldung, $element) {
    const element_id = Number($element.attr("data-element_id"));
    console.log(element_id, G.LISTEN.termine.tabelle, G.LISTEN.termine.tabelle[element_id]);

    const $rueckmeldung_nicht_eingeladen = $rueckmeldung.siblings(".rueckmeldung_nicht_eingeladen").closest();

    if (G.LISTEN.termine.tabelle[element_id].ich_eingeladen) {
        $rueckmeldung.removeClass("invisible");
        $rueckmeldung_nicht_eingeladen.addClass("invisible");
    } else {
        $rueckmeldung.addClass("invisible");
        $rueckmeldung_nicht_eingeladen.removeClass("invisible");
    }
}
