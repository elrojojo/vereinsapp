function Schnittstelle_AjaxRaus(AJAX) {
    // Das AJAX-Objekt wird für $.ajaxQueue vorbereitet
    Schnittstelle_AjaxRausVorbereiten(AJAX);

    // $.ajaxQueue wird ausgeführt
    $.ajaxQueue(AJAX.ajaxQueue);
}
