function Liste_AuswahlListeInitialisieren($liste, $werkzeug, $listenstatistik, instanz, liste, klasse_id, data) {
    LISTEN[liste].instanz[instanz] = new Object();
    $liste.attr("id", instanz).attr("data-liste", liste);
    $werkzeug.each(function () {
        const $werkzeug = $(this);
        const title = LISTEN[liste].beschriftung + " " + $werkzeug.attr("data-title");
        $werkzeug.attr("data-liste", liste).attr("data-instanz", instanz).attr("data-title", title);
    });
    $listenstatistik.attr("data-instanz", instanz).attr("data-liste", liste);

    const $blanko_element = AUSWAHLLISTE.$blanko_element.clone();
    $blanko_element.attr("data-liste", liste);
    $blanko_element.find(".beschriftung").html(Liste_ElementBeschriftungHtmlZurueck(liste));
    if (typeof klasse_id !== "undefined") $blanko_element.addClass(klasse_id);
    if (typeof data !== "undefined" && isObject(data))
        $.each(data, function (eigenschaft, wert) {
            $blanko_element.attr("data-" + eigenschaft, wert);
        });

    LISTEN[liste].instanz[instanz] = { filtern: [], sortieren: [], $blanko_element: $blanko_element };
}
