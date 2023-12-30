function Liste_Verzeichnis2$VerzeichnisZurueck(verzeichnis, verzeichnis_basis, $blanko_verzeichnis_element, liste) {
    const $verzeichnis = new Array();

    $.each(verzeichnis, function (beschriftung, unterverzeichnis) {
        const $neues_verzeichnis_element = $blanko_verzeichnis_element.clone().removeClass("blanko invisible").addClass("verzeichnis_element");

        if (isObject(unterverzeichnis)) {
            $neues_verzeichnis_element.find(".beschriftung").text(beschriftung);
            $neues_verzeichnis_element.find(".symbol").addClass("bi-" + SYMBOLE.verzeichnis.bootstrap);
            $neues_verzeichnis_element.find("a.stretched-link").removeAttr("href").attr("data-liste", liste);
        } else {
            const punkt = unterverzeichnis.lastIndexOf(".");
            const name = unterverzeichnis.slice(0, punkt);
            const typ = unterverzeichnis.slice(punkt + 1);
            $neues_verzeichnis_element.find(".beschriftung").text(name);
            $neues_verzeichnis_element.find(".symbol").addClass("bi-" + SYMBOLE[typ].bootstrap);
            $neues_verzeichnis_element
                .find("a.stretched-link")
                .removeClass("btn_verzeichnis_oeffnen")
                .attr("href", verzeichnis_basis + unterverzeichnis);
        }
        $verzeichnis.push($neues_verzeichnis_element);
    });
    return $verzeichnis;
}
