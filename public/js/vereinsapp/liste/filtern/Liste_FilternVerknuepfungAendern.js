function Liste_FilternVerknuepfungAendern($btn) {
    const liste = $btn.attr("data-liste");
    const instanz = $btn.attr("data-instanz");
    const $formular = $btn.closest(".modal.filtern");

    const $verknuepfung = $btn.closest(".filtern_sammlung").find(".verknuepfung").first();
    const verknuepfung = $verknuepfung.attr("data-verknuepfung");

    if (verknuepfung == "&&") $verknuepfung.attr("data-verknuepfung", "||").text("ODER");
    else if (verknuepfung == "||") $verknuepfung.attr("data-verknuepfung", "&&").text("UND");

    Liste_FilternSpeichern($formular, instanz, liste);
}
