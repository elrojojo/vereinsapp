function Liste_ElementAuswahlEinfordern(dom, title, liste, klasse_id, data) {
    if (typeof data === "undefined") data = new Object();

    const ziel_id = zufaelligeZeichenketteZurueck(8);
    if ("$ziel" in dom && dom.$ziel.exists()) dom.$ziel.attr("id", ziel_id);
    data.ziel_id = ziel_id;

    const instanz = liste + "_auswahl";

    const $neues_auswahl_modal = Schnittstelle_DomNeuesModalInitialisiertZurueck(
        ELEMENTE[LISTEN[liste].element].beschriftung + " " + title,
        "AUSWAHL"
    );

    $neues_auswahl_modal.find("#AUSWAHLLISTE.liste").attr("id", instanz).attr("data-liste", liste); // ToDo: Hauptinstanzen verwenden
    $neues_auswahl_modal.find('.werkzeug[data-instanz="AUSWAHLLISTE"]').each(function () {
        const $werkzeug = $(this);
        const title = LISTEN[liste].beschriftung + " " + $werkzeug.attr("data-title");
        $werkzeug.attr("data-liste", liste).attr("data-instanz", instanz).attr("data-title", title);
    });
    $neues_auswahl_modal.find('.listenstatistik[data-instanz="AUSWAHLLISTE"]').attr("data-instanz", instanz).attr("data-liste", liste);

    const $blanko_element = AUSWAHLLISTE.$blanko_element.clone();
    $blanko_element.attr("data-liste", liste);
    $blanko_element.find(".beschriftung").html(Liste_ElementBeschriftungHtmlZurueck(liste));
    if (typeof klasse_id !== "undefined") $blanko_element.addClass(klasse_id);
    if (typeof data !== "undefined" && isObject(data))
        $.each(data, function (eigenschaft, wert) {
            $blanko_element.attr("data-" + eigenschaft, wert);
        });

    LISTEN[liste].instanz[instanz] = { filtern: [], sortieren: [], $blanko_element: $blanko_element };

    Schnittstelle_DomModalOeffnen($neues_auswahl_modal);
    Schnittstelle_EventAusfuehren([Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom], { liste: liste });
}
