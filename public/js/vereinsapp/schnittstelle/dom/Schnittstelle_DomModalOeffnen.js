function Schnittstelle_DomModalOeffnen($modal) {
    const $umgebung = $("#modals");

    if (typeof $modal === "string") {
        const html = $modal;
        const temp_id = zufaelligeZeichenketteZurueck(8);

        $umgebung.after('<div id="modal_' + temp_id + '"></div>');
        const $umgebung_temp = $umgebung.siblings("#modal_" + temp_id).first();
        $umgebung_temp.append(html);
        $modal = $umgebung_temp.find(".modal").first();
        $umgebung_temp.remove();
    }

    $umgebung.find(".modal.show").each(function () {
        $(this).addClass("warten");
        bootstrap.Modal.getInstance($(this)).hide();
    });

    if (!$umgebung.find($modal).exists()) $modal.appendTo($umgebung);

    bootstrap.Modal.getOrCreateInstance($modal).show();
}
