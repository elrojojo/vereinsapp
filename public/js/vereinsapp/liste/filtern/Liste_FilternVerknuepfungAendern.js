function Liste_FilternVerknuepfungAendern($btn) {
    const $verknuepfung = $btn.closest(".filtern_sammlung").find(".verknuepfung").first();
    const verknuepfung = $verknuepfung.attr("data-verknuepfung");

    if (verknuepfung == "&&") $verknuepfung.attr("data-verknuepfung", "||").text("ODER");
    else if (verknuepfung == "||") $verknuepfung.attr("data-verknuepfung", "&&").text("UND");
}
