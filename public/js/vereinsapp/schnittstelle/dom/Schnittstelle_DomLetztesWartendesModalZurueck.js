function Schnittstelle_DomLetztesWartendesModalZurueck() {
    const $umgebung = $("#modals");
    return $umgebung.find(".modal.warten").last();
}
