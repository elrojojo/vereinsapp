function Schnittstelle_DomBestaetigungEinfordern(nachricht, title, btn_klasse_id, btn_data, btn_farbe) {
    const $neues_bestaetigung_modal = Schnittstelle_DomNeuesModalInitialisiertZurueck(title, "BESTAETIGUNG");
    const $bestaetigung = $neues_bestaetigung_modal.find(".bestaetigung");

    $bestaetigung.find(".nachricht").text(nachricht);

    const $btn_bestaetigen = $bestaetigung.find(".btn_bestaetigen");
    $btn_bestaetigen.addClass(btn_klasse_id).removeClass("btn_bestaetigen").text(title);
    if (typeof btn_data !== "undefined" && isObject(btn_data))
        $.each(btn_data, function (eigenschaft, wert) {
            $btn_bestaetigen.attr("data-" + eigenschaft, wert);
        });
    if (typeof btn_farbe !== "undefined") $btn_bestaetigen.removeClass("btn-outline-success").addClass("btn-outline-" + btn_farbe);

    Schnittstelle_DomModalOeffnen($neues_bestaetigung_modal);
}
