function Liste_FilternVerknuepfungAendern($verknuepfung, instanz, liste) {
    const verknuepfung = $verknuepfung.attr("data-verknuepfung");

    if (verknuepfung == "&&") $verknuepfung.attr("data-verknuepfung", "||").text("ODER");
    else if (verknuepfung == "||") $verknuepfung.attr("data-verknuepfung", "&&").text("UND");

    Liste_FilternSpeichern($verknuepfung.closest(".modal.filtern").find(".filtern"), instanz, liste);
}
