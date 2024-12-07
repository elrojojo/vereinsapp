function Schnittstelle_NaechsteAktion(liste, naechste_aktionen) {
    if (isArray(naechste_aktionen) && naechste_aktionen.length != 0) {
        const naechste_aktion = naechste_aktionen[0];
        const neue_naechste_aktionen = new Array();
        $.each(naechste_aktionen, function (prio, naechste_aktion) {
            if (prio > 0) neue_naechste_aktionen.push(naechste_aktion);
        });
        naechste_aktion(liste, neue_naechste_aktionen);
    }
}
