function Schnittstelle_AjaxInDieSchlange(AJAX) {
    // Das AJAX-Objekt wird für $.ajaxQueue vorbereitet
    Schnittstelle_AjaxFuerDieSchlangeVorbereiten(AJAX);

    // $.ajaxQueue wird ausgeführt
    $.ajaxQueue(AJAX.ajaxQueue);
}
