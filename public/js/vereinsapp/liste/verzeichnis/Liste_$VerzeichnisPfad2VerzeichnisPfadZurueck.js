function Liste_$VerzeichnisPfad2VerzeichnisPfadZurueck($verzeichnis_pfad, liste) {
    const verzeichnis_pfad = new Array();

    $verzeichnis_pfad.children(".verzeichnis_pfad_element").each(function (index, element) {
        if (index > 0) {
            const $element = $(element);
            const name = $element.text();
            verzeichnis_pfad.push(name);
        }
    });

    return verzeichnis_pfad;
}
