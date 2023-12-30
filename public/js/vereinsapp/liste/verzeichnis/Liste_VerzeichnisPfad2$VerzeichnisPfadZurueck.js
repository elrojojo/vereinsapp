function Liste_VerzeichnisPfad2$VerzeichnisPfadZurueck(verzeichnis_pfad, $blanko_verzeichnis_pfad_element, liste) {
    const $verzeichnis_pfad = new Array();

    const $neues_verzeichnis_pfad_element = $blanko_verzeichnis_pfad_element
        .clone()
        .removeClass("blanko invisible")
        .addClass("verzeichnis_pfad_element");

    $neues_verzeichnis_pfad_element.html("<i class='bi bi-" + SYMBOLE.verzeichnis_basis.bootstrap + "'></i>");

    if (verzeichnis_pfad.length == 0)
        $neues_verzeichnis_pfad_element.removeAttr("data-liste").removeAttr("role").addClass("active").removeClass("text-primary");
    else $neues_verzeichnis_pfad_element.addClass("btn_verzeichnis_pfad_oeffnen");

    $verzeichnis_pfad.push($neues_verzeichnis_pfad_element);

    $.each(verzeichnis_pfad, function (index, name) {
        const $neues_verzeichnis_pfad_element = $blanko_verzeichnis_pfad_element
            .clone()
            .removeClass("blanko invisible")
            .addClass("verzeichnis_pfad_element");

        $neues_verzeichnis_pfad_element.text(name);

        if (index == verzeichnis_pfad.length - 1)
            $neues_verzeichnis_pfad_element.removeAttr("data-liste").removeAttr("role").addClass("active").removeClass("text-primary");
        else $neues_verzeichnis_pfad_element.addClass("btn_verzeichnis_pfad_oeffnen");

        $verzeichnis_pfad.push($neues_verzeichnis_pfad_element);
    });

    return $verzeichnis_pfad;
}
