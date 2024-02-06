function Liste_AuswertungenAktualisieren($auswertungen, auswertungen) {
    const auswertungen_instanz = $auswertungen.attr("id");

    // STATUS_AUSWAHL DEFINIEREN
    let status_auswahl = $auswertungen.attr("data-status_auswahl");
    if (typeof status_auswahl !== "undefined") status_auswahl = JSON.parse(status_auswahl);
    else status_auswahl = new Object();

    // LISTE DEFINIEREN
    // liste aus data
    let liste_data = $auswertungen.attr("data-liste");
    if (typeof liste_data !== "undefined") liste_data = JSON.parse(liste_data);
    else liste_data = new Object();
    // liste aus liste_data
    let liste = undefined;
    if ("liste" in liste_data) liste = liste_data.liste;
    // eigenschaft aus liste_data
    let eigenschaft_data = undefined;
    if ("eigenschaft" in liste_data) eigenschaft_data = liste_data.eigenschaft;
    // eigenschaft aus LocalStorage
    const eigenschaft_LocalStorage = G.LISTEN[auswertungen].auswertungen[auswertungen_instanz].eigenschaft;
    // eigenschaft_data und eigenschaft_LocalStorage kombinieren
    let eigenschaft;
    if (typeof eigenschaft_LocalStorage === "undefined") eigenschaft = eigenschaft_data;
    else eigenschaft = eigenschaft_LocalStorage;
    // filtern aus liste_data
    let liste_filtern = new Array();
    if ("filtern" in liste_data) liste_filtern = Liste_SqlFiltern2FilternZurueck(liste_data.filtern, liste);
    const tabelle_gefiltert = Liste_TabelleGefiltertZurueck(liste_filtern, liste);

    // GEGEN_LISTE DEFINIEREN
    // gegen_liste_data aus data
    let gegen_liste_data = $auswertungen.attr("data-gegen_liste");
    if (typeof gegen_liste_data !== "undefined") gegen_liste_data = JSON.parse(gegen_liste_data);
    else gegen_liste_data = new Object();
    // gegen_liste aus gegen_liste_data
    let gegen_liste = undefined;
    if ("liste" in gegen_liste_data) gegen_liste = gegen_liste_data.liste;
    // gegen_liste_filtern aus gegen_liste_data
    let gegen_liste_filtern = new Array();
    if ("filtern" in gegen_liste_data) gegen_liste_filtern = Liste_SqlFiltern2FilternZurueck(gegen_liste_data.filtern, gegen_liste);
    const gegen_tabelle_gefiltert = Liste_TabelleGefiltertZurueck(gegen_liste_filtern, gegen_liste);

    // AUSWERTUNGEN FILTERN
    // filtern für liste definieren
    const auswertungen_liste_filtern = { verknuepfung: "||", filtern: new Array() };
    const eigenschaft_werte = new Array();
    $.each(tabelle_gefiltert, function () {
        const element = this;
        auswertungen_liste_filtern.filtern.push({ operator: "==", eigenschaft: G.LISTEN[liste].element + "_id", wert: element.id });
        // werte zur eigenschaft sammeln
        if (!eigenschaft_werte.includes(element[eigenschaft])) eigenschaft_werte.push(element[eigenschaft]);
    });
    // filtern für gegen_liste definieren
    const auswertungen_gegen_liste_filtern = { verknuepfung: "||", filtern: new Array() };
    $.each(gegen_tabelle_gefiltert, function () {
        const element = this;
        auswertungen_gegen_liste_filtern.filtern.push({ operator: "==", eigenschaft: G.LISTEN[gegen_liste].element + "_id", wert: element.id });
    });
    // filtern für liste und filtern für gegen_liste kombinieren
    const auswertungen_filtern = [{ verknuepfung: "&&", filtern: [auswertungen_liste_filtern, auswertungen_gegen_liste_filtern] }];
    // auswertungen filtern
    const auswertungen_tabelle_gefiltert = Liste_TabelleGefiltertZurueck(auswertungen_filtern, auswertungen);

    // WERTE ZUR EIGENSCHAFT SORTIEREN
    eigenschaft_werte.sort();

    // META_IDS VORBEREITEN
    const meta_ids = new Object();
    // ergebnis_neutral vorbereiten
    meta_ids.ergebnis_neutral = new Object();
    $.each(eigenschaft_werte, function (position, wert) {
        meta_ids.ergebnis_neutral[wert] = new Array();
    });
    // ergebnis vorbereiten
    meta_ids.ergebnis = new Object();
    $.each(eigenschaft_werte, function (position, wert) {
        meta_ids.ergebnis[wert] = new Object();
        $.each(status_auswahl, function (status) {
            meta_ids.ergebnis[wert][status] = new Array();
        });
    });
    // ergebnis_wert vorbereiten
    meta_ids.ergebnis_wert = new Object();
    $.each(eigenschaft_werte, function (position, wert) {
        meta_ids.ergebnis_wert[wert] = new Array();
    });
    // ergebnis_status vorbereiten
    meta_ids.ergebnis_status = new Object();
    $.each(status_auswahl, function (status) {
        meta_ids.ergebnis_status[status] = new Array();
    });

    // META_IDS CLUSTERN
    // ergebnis, ergebnis_wert und ergebnis_status clustern
    $.each(auswertungen_tabelle_gefiltert, function () {
        const auswertung = this;
        const status = auswertung.status;
        const element_id = auswertung[G.LISTEN[liste].element + "_id"];
        const wert = G.LISTEN[liste].tabelle[element_id][eigenschaft];
        meta_ids.ergebnis[wert][status].push(element_id);
        meta_ids.ergebnis_status[status].push(element_id);
        meta_ids.ergebnis_wert[wert].push(element_id);
    });
    // ergebnis_neutral clustern und ergebnis_neutral in ergebnis_wert integrieren
    $.each(tabelle_gefiltert, function (position, element) {
        const element_id = element.id;
        const wert = G.LISTEN[liste].tabelle[element_id][eigenschaft];
        if (!meta_ids.ergebnis_wert[wert].includes(element_id)) {
            meta_ids.ergebnis_wert[wert].push(element_id);
            meta_ids.ergebnis_neutral[wert].push(element_id);
        }
    });

    // DOM LÖSCHEN
    $auswertungen.find('.auswertung[data-auswertung="' + eigenschaft + '"]').each(function () {
        const $auswertung = $(this);
        if (typeof $auswertung.attr("data-wert") === "undefined" || !eigenschaft_werte.includes($auswertung.attr("data-wert"))) $auswertung.remove();
    });

    // DOM ERGÄNZEN
    $.each(eigenschaft_werte, function (position, wert) {
        const $auswertung = $auswertungen.find('.auswertung[data-auswertung="' + eigenschaft + '"][data-wert="' + wert + '"]');
        if (!$auswertung.exists()) {
            const $neue_auswertung = G.LISTEN[auswertungen].auswertungen[auswertungen_instanz].$blanko_auswertung
                .clone()
                .removeClass("blanko invisible")
                .attr("data-auswertung", eigenschaft)
                .attr("data-wert", wert);

            $neue_auswertung
                .find('[data-bs-toggle="collapse"]')
                .attr("data-bs-target", "#auswertung_" + auswertungen_instanz + "_" + eigenschaft + "_" + wert);

            $neue_auswertung.find(".collapse").attr("id", "auswertung_" + auswertungen_instanz + "_" + eigenschaft + "_" + wert);

            if (position == 0) $neue_auswertung.appendTo($auswertungen);
            else
                $neue_auswertung.insertAfter(
                    $auswertungen.find('.auswertung[data-auswertung="' + eigenschaft + '"][data-wert="' + eigenschaft_werte[position - 1] + '"]')
                );
        }
    });

    if (!$auswertungen.find('.auswertung_summe[data-auswertung="' + eigenschaft + '"]').exists()) {
        const $neue_auswertung_summe = G.LISTEN[auswertungen].auswertungen[auswertungen_instanz].$blanko_auswertung
            .clone()
            .removeClass("blanko invisible")
            .attr("data-auswertung", eigenschaft)
            .removeClass("auswertung")
            .addClass("auswertung_summe");
        $neue_auswertung_summe.find('[data-bs-toggle="collapse"]').removeAttr("data-bs-toggle role");
        $neue_auswertung_summe.find(".collapse").remove();
        $neue_auswertung_summe.find(".collapse-toggle").remove();
        $neue_auswertung_summe.find(".progress").remove();
        $neue_auswertung_summe.find(".beschriftung").text("Summe");

        $neue_auswertung_summe.insertAfter($auswertungen.find('.auswertung[data-auswertung="' + eigenschaft + '"]').last());
    }

    // AUSWERTUNG AKTUALISIEREN
    $('.auswertung[data-auswertung="' + eigenschaft + '"]').each(function () {
        const $auswertung = $(this);
        const wert = $auswertung.attr("data-wert");

        // BESCHRIFTUNG AKTUALISIEREN
        $auswertung.find(".beschriftung").text(VORGEGEBENE_WERTE[liste][eigenschaft][wert].beschriftung);

        // ERGEBNIS_ANZAHL AKTUALISIEREN
        $auswertung.find(".ergebnis_anzahl").each(function () {
            const $ergebnis = $(this);
            const status = $ergebnis.attr("data-status");
            if ($ergebnis.hasClass("progress-bar"))
                $ergebnis.attr("style", "width: " + (meta_ids.ergebnis[wert][status].length / meta_ids.ergebnis_wert[wert].length) * 100 + "%");
            else $ergebnis.text(meta_ids.ergebnis[wert][status].length);
        });
        // ERGEBNIS_ANZAHL_NEUTRAL AKTUALISIEREN
        $auswertung.find(".ergebnis_neutral_anzahl").each(function () {
            const $ergebnis = $(this);
            if ($ergebnis.hasClass("progress-bar"))
                $ergebnis.attr("style", "width: " + (meta_ids.ergebnis_neutral[wert].length / meta_ids.ergebnis_wert[wert].length) * 100 + "%");
            else $ergebnis.text(meta_ids.ergebnis_neutral[wert].length);
        });

        // ERGEBNIS AKTUALISIEREN
        $auswertung.find(".ergebnis").each(function () {
            const $ergebnis = $(this);
            const status = $ergebnis.attr("data-status");
            filtern = "";
            $.each(meta_ids.ergebnis[wert][status], function (position, id) {
                filtern += '{"operator":"==","eigenschaft":"id","wert":' + id + "}";
                if (position < meta_ids.ergebnis[wert][status].length - 1) filtern += ",";
            });
            filtern = '[{"verknuepfung":"||","filtern":[' + filtern + "]}]";
            $ergebnis.attr("data-filtern", filtern);
        });

        // ERGEBNIS_NEUTRAL AKTUALISIEREN
        $auswertung.find(".ergebnis_neutral").each(function () {
            const $ergebnis = $(this);
            filtern = "";
            $.each(meta_ids.ergebnis_neutral[wert], function (position, id) {
                filtern += '{"operator":"==","eigenschaft":"id","wert":' + id + "}";
                if (position < meta_ids.ergebnis_neutral[wert].length - 1) filtern += ",";
            });
            filtern = '[{"verknuepfung":"||","filtern":[' + filtern + "]}]";
            $ergebnis.attr("data-filtern", filtern);
        });
    });

    // SUMME AKTUALISIEREN
    $('.auswertung_summe[data-auswertung="' + eigenschaft + '"]').each(function () {
        const $auswertung = $(this);
        $auswertung.find(".ergebnis_anzahl").each(function () {
            const $ergebnis = $(this);
            const status = $ergebnis.attr("data-status");
            if ($ergebnis.hasClass("progress-bar"))
                $ergebnis.attr("style", "width: " + (meta_ids.ergebnis_status[status][status].length / tabelle_gefiltert.length) * 100 + "%");
            else $ergebnis.text(meta_ids.ergebnis_status[status].length);
        });
    });
}
