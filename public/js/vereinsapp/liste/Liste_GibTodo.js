function Liste_GibTodo(prio_liste) {
    const todo = new Array();

    if (prio_liste in LISTEN) {
        // Priorisierte Liste wird an den Anfang gesetzt
        todo.push(prio_liste);

        // Alle anderen Listen werden angehängt
        $.each(Object.keys(LISTEN), function (index, liste) {
            if (liste != prio_liste) todo.push(liste);
        });
    }

    return todo;
}
