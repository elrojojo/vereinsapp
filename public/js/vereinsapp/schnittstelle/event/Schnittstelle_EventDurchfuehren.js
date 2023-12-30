function Schnittstelle_EventDurchfuehren(liste, naechste_aktionen, aktion) {
    if (!(liste in G.LISTEN))
        $.each(G.LISTEN, function (liste) {
            Schnittstelle_EventDurchfuehren(liste, naechste_aktionen, aktion);
        });
    else {
        aktion(liste);

        // Wenn andere Listen von dieser Liste abhängig sind, dann muss die Variable für diese anderen Listen auch aktualisiert werden
        $.each(G.LISTEN, function (liste_) {
            if ("abhaengig_von" in G.LISTEN[liste_] && G.LISTEN[liste_].abhaengig_von.includes(liste)) aktion(liste_);
        });

        // Nachdem alles in der Variable aktualisiert ist, wird die naechste Aktion ausgeführt
        Schnittstelle_NaechsteAktion(liste, naechste_aktionen);
    }
}
