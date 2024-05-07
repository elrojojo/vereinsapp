function Schnittstelle_DomBestaetigungEinfordern(nachricht, title, btn_klasse_id, btn_data, farbe) {
    let modal_id;
    if (btn_klasse_id.substring(0, 4) == "btn_") modal_id = btn_klasse_id.slice(0, 4) + "_bestaetigung";
    else modal_id = btn_klasse_id;

    const $neue_bestaetigung = BESTAETIGUNGEN.$blanko_bestaetigung.clone().removeClass("invisible");
    $neue_bestaetigung.attr("id", modal_id);
    $neue_bestaetigung.find(".modal-title").first().text(title);
    $neue_bestaetigung.find(".nachricht").first().text(nachricht);

    const $btn_bestaetigen = $neue_bestaetigung.find(".btn_bestaetigen");
    if (typeof farbe !== "undefined") $btn_bestaetigen.removeClass("btn-outline-success").addClass("btn-outline-" + farbe);
    $.each(btn_data, function (data, wert) {
        $btn_bestaetigen.attr("data-" + data, wert);
    });
    $btn_bestaetigen.addClass(btn_klasse_id).text(title);

    Schnittstelle_DomModalOeffnen($neue_bestaetigung);
}
