function Liste_Init() {
    $.each(G.LISTEN, function (liste) {
        G.LISTEN[liste].instanz = new Object();
        $('.liste[data-liste="' + liste + '"]').each(function () {
            const $liste = $(this);
            const instanz = $liste.attr("id");
            G.LISTEN[liste].instanz[instanz] = { filtern: new Array(), sortieren: new Array(), $blanko_element: $liste.find(".blanko").first() };
        });
        $('.liste[data-liste="' + liste + '"]').empty();
    });

    Liste_ChecklisteInit();

    Liste_AuswertungenInit();

    Liste_VerzeichnisInit();

    Liste_FilternInit();

    Liste_SortierenInit();

    // FORMULAR (MODAL) ÖFFNEN
    $(document).on("show.bs.modal", ".formular", function () {
        Liste_ElementFormularOeffnen($(this), G.MODALS.offen[G.MODALS.offen.length - 1].$btn_oeffnend);
    });

    // FORMULAR (MODAL) SCHLIESSEN
    $(document).on("hide.bs.modal", ".formular", function () {
        Liste_ElementFormularSchliessen($(this));
    });

    // ELEMENT LÖSCHEN BESTÄTIGUNG (MODAL) ÖFFNEN
    $(document).on("click", ".btn_element_loeschen_modal", function () {
        const $btn = $(this);
        const data = { liste: $btn.attr("data-liste"), element_id: $btn.attr("data-element_id") };
        const weiterleiten = $btn.attr("data-weiterleiten");
        if (typeof weiterleiten !== "undefined") data.weiterleiten = weiterleiten;

        Schnittstelle_DomBestaetigungEinfordern(
            "Willst du " + Liste_ElementBeschriftungZurueck(data.element_id, data.liste) + " wirklich löschen?",
            $btn.attr("data-title"),
            "btn_" + G.LISTEN[data.liste].element + "_loeschen",
            data,
            $btn.attr("data-farbe")
        );
    });

    // SORTABLE
    $(".sortable").sortable({
        handle: ".sortable_handle",
        start: function (event, ui) {
            ui.item.addClass("border-top border-primary shadow");
        },
        stop: function (event, ui) {
            ui.item.removeClass("border-top border-primary shadow");
        },
        update: function () {
            $("#sortable_speichern").attr("disabled", false);
        },
    });

    Schnittstelle_EventLocalstorageUpdVariable();
    Schnittstelle_EventVariableUpdDom();
    if (Object.keys(G.LISTEN).length > 0)
        Schnittstelle_EventSqlUpdLocalstorage(Object.keys(G.LISTEN), true, [
            Schnittstelle_EventLocalstorageUpdVariable,
            Schnittstelle_EventVariableUpdDom,
        ]);
}
