function Strafkatalog_KassenbucheintragDeAktivieren(bestaetigung_einfordern, dom, title, kassenbucheintrag_id) {
    if (typeof kassenbucheintrag_id !== "undefined") kassenbucheintrag_id = Number(kassenbucheintrag_id);
    let aktiv = Schnittstelle_VariableRausZurueck("aktiv", kassenbucheintrag_id, "kassenbuch");

    if (bestaetigung_einfordern) {
        let nachricht;
        if (aktiv === 0) nachricht = " aktivieren (Betrag wurde bezahlt)?";
        else nachricht = " deaktivieren (Betrag wurde nicht bezahlt)?";
        Schnittstelle_DomBestaetigungEinfordern(
            "Willst du wirklich den Kassenbucheintrag " + Liste_ElementBeschriftungZurueck(kassenbucheintrag_id, "kassenbuch") + nachricht,
            title,
            "btn_kassenbucheintrag_de_aktivieren",
            { element_id: kassenbucheintrag_id }
        );
    } else {
        if (aktiv === 0) aktiv = 1;
        else aktiv = 0;
        Strafkatalog_KassenbucheintragAendern(false, dom, { aktiv: aktiv }, title, kassenbucheintrag_id);
    }
}
