function Schnittstelle_AjaxRein(AJAX) {
    // Falls der Ajax fertig ist und Schleife aktiv ist,
    if (AJAX.zustand == AJAX_ZUSTAND.FERTIG && typeof AJAX.schleife === "function") {
        // dann wird die liste rekonstruiert
        let liste;
        if (Array.isArray(AJAX.warten_auf)) {
            liste = new Array();
            $.each(AJAX.warten_auf, function (prio, ajax_id) {
                AJAX = AJAXSCHLANGE[Number(ajax_id)];
                liste.push(AJAX.liste);
            });
            liste.push(AJAX.liste);
        } else liste = AJAX.liste;
        // und der nächste Durchlauf nach AJAX_ZYKLUSZEIT Sekunden gestartet
        setTimeout(AJAX.schleife, AJAX_ZYKLUSZEIT * 1000, liste, true, AJAX.naechste_aktionen);
    }
}
