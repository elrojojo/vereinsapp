function Schnittstelle_VariableLoeschen(element_id, liste, ziel) {
    if (typeof ziel === "undefined") ziel = "tabelle";
    else if (ziel == "tmp" && typeof element_id === "undefined") element_id = 0;

    if (typeof element_id !== "undefined" && typeof liste !== "undefined") {
        delete G.LISTEN[liste][ziel][Number(element_id)];

        if ("verlinkte_listen" in G.LISTEN[liste])
            $.each(G.LISTEN[liste].verlinkte_listen, function (prio, verlinkte_liste) {
                $.each(G.LISTEN[verlinkte_liste][ziel], function () {
                    const element = this;
                    if (
                        "id" in element &&
                        G.LISTEN[liste].element + "_id" in element &&
                        element[G.LISTEN[liste].element + "_id"] == Number(element_id)
                    )
                        Schnittstelle_VariableLoeschen(element.id, verlinkte_liste, ziel);
                });
            });

        if (ziel != "tmp") Schnittstelle_VariableLoeschen(element_id, liste, "tmp");
    }
}
