function Liste_TodoZurueck(prio_liste) {
    const todo = new Array();

    if (prio_liste in G.LISTEN) {
        // Priorisierte Liste wird an den Anfang gesetzt
        todo.push(prio_liste);

        // Alle anderen G.LISTEN werden angehängt
        $.each(Object.keys(G.LISTEN), function (index, liste) {
            if (liste != prio_liste) todo.push(liste);
        });
    }

    return todo;
}
