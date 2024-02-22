function Liste_VerzeichnisAktualisieren($verzeichnis, liste) {
    const element_id = Number($verzeichnis.attr("data-element_id"));

    let instanz = $verzeichnis.attr("data-instanz");
    if (typeof instanz === "undefined") instanz = $verzeichnis.attr("id");

    let basis = $verzeichnis.attr("data-basis");
    if (typeof basis !== "undefined") basis = JSON.parse(basis);
    else basis = new Array();

    if (basis.length > 0)
        $verzeichnis
            .closest(".unterverzeichnis")
            .find(".beschriftung")
            .text(basis[basis.length - 1]);

    let inhalt = Schnittstelle_VariableRausZurueck("verzeichnis", element_id, liste);
    $.each(basis, function (position, unterverzeichnis) {
        inhalt = inhalt.unterverzeichnisse[unterverzeichnis];
    });
    const unterverzeichnisse_gefiltert_sortiert = Object.keys(inhalt.unterverzeichnisse);
    const dateien_gefiltert_sortiert = inhalt.dateien;

    // UNTERVERZEICHNISSE IM DOM LÖSCHEN
    $verzeichnis.children(".unterverzeichnis").each(function () {
        const $unterverzeichnis = $(this);
        const unterverzeichnis = $unterverzeichnis.attr("data-unterverzeichnis");
        if (!unterverzeichnisse_gefiltert_sortiert.includes(unterverzeichnis)) $unterverzeichnis.remove();
    });

    // DATEIEN IM DOM LÖSCHEN
    $verzeichnis.children(".datei").each(function () {
        const $datei = $(this);
        const datei = $datei.attr("data-datei");
        if (!dateien_gefiltert_sortiert.includes(datei)) $datei.remove();
    });

    // UNTERVERZEICHNISSE IM DOM ERGÄNZEN
    $.each(unterverzeichnisse_gefiltert_sortiert, function (position, unterverzeichnis) {
        const $unterverzeichnis = $verzeichnis.children(".unterverzeichnis[data-unterverzeichnis='" + unterverzeichnis + "']");

        // Unterverzeichnis wird nur hinzugefügt, falls es noch nicht existiert
        if (!$unterverzeichnis.exists()) {
            // Blanko-Verzeichnis wird geklont

            const $neues_unterverzeichnis = G.LISTEN[liste].verzeichnis[instanz].$blanko_unterverzeichnis
                .clone()
                .removeClass("blanko invisible")
                .addClass("unterverzeichnis")
                .attr("data-unterverzeichnis", unterverzeichnis);

            const neue_id = zufaelligeZeichenketteZurueck(8);
            $neues_unterverzeichnis
                .find('[data-bs-toggle="collapse"]')
                .first()
                .attr("data-bs-target", "#unterverzeichnis_" + neue_id);

            $neues_unterverzeichnis
                .find(".collapse")
                .first()
                .attr("id", "unterverzeichnis_" + neue_id);

            const neue_basis = JSON.parse(JSON.stringify(basis));
            neue_basis.push(unterverzeichnis);
            $neues_unterverzeichnis
                .find(".verzeichnis")
                .attr("data-instanz", instanz)
                .attr("data-element_id", element_id)
                .attr("data-basis", JSON.stringify(neue_basis));

            // Unterverzeichnis wird hinzugefügt (je nachdem, wo es im Verzeichnis positioniert ist)
            if (position == 0) $neues_unterverzeichnis.appendTo($verzeichnis);
            else
                $neues_unterverzeichnis.insertAfter(
                    $verzeichnis.children('.unterverzeichnis[data-unterverzeichnis="' + unterverzeichnisse_gefiltert_sortiert[position - 1] + '"]')
                );
        }
    });

    // DATEIEN IM DOM ERGÄNZEN
    $.each(dateien_gefiltert_sortiert, function (position, datei) {
        const $datei = $verzeichnis.children('.datei[data-datei="' + datei + '"]');

        // Datei wird nur hinzugefügt, falls sie noch nicht existiert
        if (!$datei.exists()) {
            // Blanko-Datei wird geklont
            const $neue_datei = G.LISTEN[liste].verzeichnis[instanz].$blanko_datei
                .clone()
                .removeClass("blanko invisible")
                .addClass("datei")
                .attr("data-liste", liste)
                .attr("data-datei", datei);

            // Datei wird hinzugefügt (je nachdem, wo sie im Verzeichnis positioniert ist)
            if (position == 0) {
                if (unterverzeichnisse_gefiltert_sortiert.length > 0)
                    $neue_datei.insertAfter(
                        $verzeichnis.children(
                            '.unterverzeichnis[data-unterverzeichnis="' +
                                unterverzeichnisse_gefiltert_sortiert[unterverzeichnisse_gefiltert_sortiert.length - 1] +
                                '"]'
                        )
                    );
                else $neue_datei.appendTo($verzeichnis);
            } else $neue_datei.insertAfter($verzeichnis.children('.datei[data-datei="' + dateien_gefiltert_sortiert[position - 1] + '"]'));
        }
    });

    // UNTERVERZEICHNISSE IM DOM SORTIEREN
    $.each(unterverzeichnisse_gefiltert_sortiert, function (position, unterverzeichnis) {
        const $unterverzeichnis = $verzeichnis.children(".unterverzeichnis[data-unterverzeichnis='" + unterverzeichnis + "']");
        if (position == 0) $unterverzeichnis.appendTo($verzeichnis);
        else
            $unterverzeichnis.insertAfter(
                $verzeichnis.children('.unterverzeichnis[data-unterverzeichnis="' + unterverzeichnisse_gefiltert_sortiert[position - 1] + '"]')
            );
    });

    // DATEIEN IM DOM SORTIEREN
    $.each(dateien_gefiltert_sortiert, function (position, datei) {
        const $datei = $verzeichnis.children('.datei[data-datei="' + datei + '"]');
        if (position == 0) {
            if (unterverzeichnisse_gefiltert_sortiert.length > 0)
                $datei.insertAfter(
                    $verzeichnis.children(
                        '.unterverzeichnis[data-unterverzeichnis="' +
                            unterverzeichnisse_gefiltert_sortiert[unterverzeichnisse_gefiltert_sortiert.length - 1] +
                            '"]'
                    )
                );
            else $datei.appendTo($verzeichnis);
        } else $datei.insertAfter($verzeichnis.children('.datei[data-datei="' + dateien_gefiltert_sortiert[position - 1] + '"]'));
    });

    // UNTERVERZEICHNISSE AKTUALISIEREN
    $verzeichnis.children(".unterverzeichnis").each(function () {
        Liste_VerzeichnisAktualisieren($(this).find(".verzeichnis").first(), liste);
    });

    // ÜBERSCHRIFTEN EIN-/AUSBLENDEN
    if (basis.length === 0) {
        if ($verzeichnis.children().length == 0) $verzeichnis.prev('.ueberschrift[data-instanz="' + instanz + '"]').addClass("invisible");
        else $verzeichnis.prev('.ueberschrift[data-instanz="' + instanz + '"]').removeClass("invisible");
    }
}
