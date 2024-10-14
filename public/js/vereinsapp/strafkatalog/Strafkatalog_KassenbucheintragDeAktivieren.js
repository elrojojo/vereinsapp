function Strafkatalog_KassenbucheintragDeAktivieren(bestaetigung_einfordern, dom, data, title, kassenbucheintrag_id) {
    if (typeof kassenbucheintrag_id !== "undefined") kassenbucheintrag_id = Number(kassenbucheintrag_id);
    if ("aktiv" in data && typeof data.aktiv !== "undefined") data.aktiv = Number(data.aktiv);

    if (bestaetigung_einfordern && data.aktiv == 0)
        Schnittstelle_DomBestaetigungEinfordern(
            "Willst du den Kassenbucheintrag " +
                Liste_ElementBeschriftungZurueck(kassenbucheintrag_id, "kassenbuch") +
                " wirklich aktivieren (Betrag wurde bezahlt)?",
            title,
            "btn_kassenbucheintrag_de_aktivieren",
            { liste: "strafkatalog", element_id: kassenbucheintrag_id, data: JSON.stringify(data) }
        );
    else if (bestaetigung_einfordern && data.aktiv == 1)
        Schnittstelle_DomBestaetigungEinfordern(
            "Willst du den Kassenbucheintrag " +
                Liste_ElementBeschriftungZurueck(kassenbucheintrag_id, "kassenbuch") +
                " wirklich deaktivieren (Betrag wurde nicht bezahlt)?",
            title,
            "btn_kassenbucheintrag_de_aktivieren",
            { liste: "strafkatalog", element_id: kassenbucheintrag_id, data: JSON.stringify(data) }
        );
    else {
        if (data.aktiv == 0) data.aktiv = 1;
        else data.aktiv = 0;
        Strafkatalog_KassenbucheintragAendern(false, dom, data, title, kassenbucheintrag_id);
    }
}
