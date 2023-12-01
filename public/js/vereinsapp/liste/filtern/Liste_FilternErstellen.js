function Liste_FilternErstellen($btn, liste) {
    const $formular = $btn.parents(".filtern_definition").first();

    const filtern = new Array();
    $formular.find(".filtern_wert").each(function () {
        const $filtern_wert = $(this);
        if ($filtern_wert.val())
            filtern.push({
                operator: $filtern_wert.attr("data-operator"),
                eigenschaft: $formular.attr("data-eigenschaft"),
                wert: Schnittstelle_VariableWertBereinigtZurueck($filtern_wert.val()),
            });
    });

    let filtern_knoten;
    if (filtern.length == 1) filtern_knoten = filtern[0];
    else filtern_knoten = { verknuepfung: "&&", filtern: filtern };

    if (G.LISTEN[liste].filtern.length == 0) G.LISTEN[liste].filtern.push(filtern_knoten);
    else {
        if ("verknuepfung" in G.LISTEN[liste].filtern[0]) G.LISTEN[liste].filtern[0].filtern.push(filtern_knoten);
        else {
            const einziges_element = G.LISTEN[liste].filtern[0];
            G.LISTEN[liste].filtern[0] = { verknuepfung: "&&", filtern: new Array() };
            G.LISTEN[liste].filtern[0].filtern.push(einziges_element);
            G.LISTEN[liste].filtern[0].filtern.push(filtern_knoten);
        }
    }

    Schnittstelle_EventVariableUpdLocalstorage(liste); // impliziert auch ein Schnittstelle_EventLocalstorageUpdVariable;
}
