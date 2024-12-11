function Schnittstelle_AjaxRaus(AJAX) {
    // AJAX.data wird für php aufbereitet, aber ggf. vorher in AJAX.data_original zwischengespeichert
    AJAX.data_original = new Object();
    $.each(AJAX.data, function (eigenschaft, wert) {
        if (wert === null) {
            AJAX.data_original[eigenschaft] = null;
            AJAX.data[eigenschaft] = "";
        }
    });
}
