function Schnittstelle_VariableLoeschen(element_id, liste) {
    if (typeof element_id !== "undefined" && typeof liste !== "undefined") {
        delete G.LISTEN[liste].tabelle[Number(element_id)];

        if ("verlinkte_listen" in G.LISTEN[liste])
            $.each(G.LISTEN[liste].verlinkte_listen, function (prio, verlinkte_liste) {
                $.each(G.LISTEN[verlinkte_liste].tabelle, function () {
                    const element = this;
                    if (
                        "id" in element &&
                        G.LISTEN[liste].element + "_id" in element &&
                        element[G.LISTEN[liste].element + "_id"] == Number(element_id)
                    )
                        Schnittstelle_VariableLoeschen(element.id, verlinkte_liste);
                });
            });
    }
}
