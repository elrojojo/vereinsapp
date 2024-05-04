function Schnittstelle_DomLetztesModalZurueck() {
    const $umgebung = $("#modals");
    return $umgebung.find(".modal").last();
}
