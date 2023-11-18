function Liste_FilternVerknuepfungAendern($btn_aendern, liste) {
    const $filtern = $btn_aendern.parents(".filtern").first();
    const $verknuepfung = $btn_aendern.parents(".filtern_sammlung").first().find(".verknuepfung").first();
    const verknuepfung = $verknuepfung.attr("data-verknuepfung");

    if (verknuepfung == "&&") $verknuepfung.attr("data-verknuepfung", "||");
    else if (verknuepfung == "||") $verknuepfung.attr("data-verknuepfung", "&&");

    G.LISTEN[liste].filtern = Liste_Gib$Filtern2Filtern($filtern, "filtern", liste);
    $(document).trigger("VAR_upd_LOC", [liste]); // impliziert auch ein $(document).trigger( 'LOC_upd_VAR' );
}
