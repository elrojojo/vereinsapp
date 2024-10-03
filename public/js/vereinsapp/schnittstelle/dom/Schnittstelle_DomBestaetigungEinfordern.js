function Schnittstelle_DomBestaetigungEinfordern(nachricht, title, btn_klasse_id, btn_data, btn_farbe) {
    const $neue_bestaetigung = BESTAETIGUNGEN.$blanko_bestaetigung.clone().removeClass("invisible");
    $neue_bestaetigung.find(".modal-title").first().text(title);
    $neue_bestaetigung.find(".nachricht").first().text(nachricht);

    const $btn_bestaetigen = $neue_bestaetigung.find(".btn_bestaetigen");
    $btn_bestaetigen.addClass(btn_klasse_id).text(title);
    if (typeof btn_data !== "undefined" && isObject(btn_data))
        $.each(btn_data, function (eigenschaft, wert) {
            $btn_bestaetigen.attr("data-" + eigenschaft, wert);
        });
    if (typeof btn_farbe !== "undefined") $btn_bestaetigen.removeClass("btn-outline-success").addClass("btn-outline-" + btn_farbe);

    Schnittstelle_DomModalOeffnen($neue_bestaetigung);
}
