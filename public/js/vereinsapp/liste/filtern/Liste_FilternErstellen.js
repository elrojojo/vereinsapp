function Liste_FilternErstellen($btn_erstellen, liste) {
    const $formular = $btn_erstellen.parents(".filtern_definition").first();
    const eigenschaft = $formular.attr("data-eigenschaft");

    const filtern = new Array();
    $formular.find(".filtern_wert").each(function () {
        const $filtern_wert = $(this);

        if ($filtern_wert.val()) {
            const operator = $filtern_wert.attr("data-operator");
            let wert = $filtern_wert.val();
            if (wert && !Number.isNaN(Number(wert)) && typeof wert !== "boolean") wert = Number(wert);
            if (
                typeof EIGENSCHAFTEN[LISTEN[liste].controller][liste][eigenschaft] !== "undefined" &&
                EIGENSCHAFTEN[LISTEN[liste].controller][liste][eigenschaft]["typ"] == "zeitpunkt"
            )
                wert = DateTime.fromISO(wert);
            filtern.push({
                operator: operator,
                eigenschaft: eigenschaft,
                wert: wert,
            });
        }
    });

    let filtern_knoten;
    if (filtern.length == 1) filtern_knoten = filtern[0];
    else filtern_knoten = { verknuepfung: "&&", filtern: filtern };

    if (LISTEN[liste].filtern.length == 0) LISTEN[liste].filtern.push(filtern_knoten);
    else {
        if ("verknuepfung" in LISTEN[liste].filtern[0]) LISTEN[liste].filtern[0].filtern.push(filtern_knoten);
        else {
            const einziges_element = LISTEN[liste].filtern[0];
            LISTEN[liste].filtern[0] = { verknuepfung: "&&", filtern: new Array() };
            LISTEN[liste].filtern[0].filtern.push(einziges_element);
            LISTEN[liste].filtern[0].filtern.push(filtern_knoten);
        }
    }

    $(document).trigger("VAR_upd_LOC", [liste]); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR' );
}
