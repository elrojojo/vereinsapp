function Liste_FilternErstellen($btn) {
    const liste = $btn.attr("data-liste");
    const instanz = $btn.attr("data-instanz");
    const eigenschaft = $btn.attr("data-eigenschaft");
    // const filtern_liste = $btn.attr("data-filtern_liste");
    const element_id = $btn.attr("data-element_id");
    const $formular = $btn.closest(".modal");

    const $filtern_definition = $btn.closest(".filtern_definition");

    const filtern = new Array();
    $filtern_definition.find(".filtern_wert").each(function () {
        const $filtern_wert = $(this);
        if ($filtern_wert.val())
            filtern.push({
                operator: $filtern_wert.attr("data-operator"),
                eigenschaft: $filtern_definition.attr("data-eigenschaft"),
                wert: Schnittstelle_VariableWertBereinigtZurueck($filtern_wert.val()),
            });
    });

    let filtern_knoten;
    if (filtern.length == 1) filtern_knoten = filtern[0];
    else filtern_knoten = { verknuepfung: "&&", filtern: filtern };

    if (typeof instanz !== "undefined") {
        if (G.LISTEN[liste].instanz[instanz].filtern.length == 0) G.LISTEN[liste].instanz[instanz].filtern.push(filtern_knoten);
        else {
            if ("verknuepfung" in G.LISTEN[liste].instanz[instanz].filtern[0])
                G.LISTEN[liste].instanz[instanz].filtern[0].filtern.push(filtern_knoten);
            else {
                const einziges_element = G.LISTEN[liste].instanz[instanz].filtern[0];
                G.LISTEN[liste].instanz[instanz].filtern[0] = { verknuepfung: "&&", filtern: new Array() };
                G.LISTEN[liste].instanz[instanz].filtern[0].filtern.push(einziges_element);
                G.LISTEN[liste].instanz[instanz].filtern[0].filtern.push(filtern_knoten);
            }
        }
        Schnittstelle_EventVariableUpdLocalstorage(liste, [Schnittstelle_EventLocalstorageUpdVariable, Schnittstelle_EventVariableUpdDom]);
    }
    if (typeof eigenschaft !== "undefined") {
        let filtern_eigenschaft = new Array();
        if (Array.isArray(Schnittstelle_VariableRausZurueck(eigenschaft, element_id, liste, "tmp")))
            filtern_eigenschaft = Schnittstelle_VariableRausZurueck(eigenschaft, element_id, liste, "tmp");
        if (filtern_eigenschaft.length == 0) filtern_eigenschaft.push(filtern_knoten);
        else {
            if ("verknuepfung" in filtern_eigenschaft[0]) filtern_eigenschaft[0].filtern.push(filtern_knoten);
            else {
                const einziges_element = filtern_eigenschaft[0];
                filtern_eigenschaft[0] = { verknuepfung: "&&", filtern: new Array() };
                filtern_eigenschaft[0].filtern.push(einziges_element);
                filtern_eigenschaft[0].filtern.push(filtern_knoten);
            }
        }
        Schnittstelle_VariableRein(filtern_eigenschaft, eigenschaft, element_id, liste, "tmp");
    }
    Liste_FilternAktualisieren($formular, liste);
}
