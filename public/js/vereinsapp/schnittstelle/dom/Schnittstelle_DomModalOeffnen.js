function Schnittstelle_DomModalOeffnen($modal, $umgebung) {
    if (typeof $umgebung === "undefined" || !$umgebung.exists()) $umgebung = $("#modals");

    if (typeof $modal === "string") {
        const html = $modal;
        const temp_id = zufaelligeZeichenketteZurueck(8);

        $umgebung.append('<div id="modal_' + temp_id + '"></div>');
        const $umgebung_temp = $umgebung.find("#modal_" + temp_id).first();
        $umgebung_temp.append(html);

        $modal = $umgebung
            .find("#modal_" + temp_id)
            .find(".modal")
            .first();

        $umgebung_temp.remove();
    }

    $modal.appendTo($umgebung);

    bootstrap.Modal.getOrCreateInstance($modal).show();
}
