function Schnittstelle_LocalstorageInit() {
    // LOCALSTORAGE LEEREN
    $(".btn_localstorage_leeren").click(function () {
        localstorage_leeren();
        $(this).closest(".modal").modal("hide");
    });

    // LOCALSTORAGE LEEREN ERZWINGEN
    if (
        typeof Schnittstelle_LocalstorageRausZurueck("localstorage_reset") === "undefined" ||
        DateTime.fromISO(Schnittstelle_LocalstorageRausZurueck("localstorage_reset")) < DateTime.fromISO(FORCE_LOCALSTORAGE_RESET_ZEITPUNKT)
    )
        localstorage_leeren();
}

function localstorage_leeren() {
    const datenschutz_richtlinie = Schnittstelle_LocalstorageRausZurueck("datenschutz_richtlinie_" + DATENACHUTZ_RICHTLINIE_DATUM);
    localStorage.clear();
    Schnittstelle_LocalstorageRein("localstorage_reset", DateTime.now());
    if (typeof datenschutz_richtlinie !== "undefined")
        Schnittstelle_LocalstorageRein("datenschutz_richtlinie_" + DATENACHUTZ_RICHTLINIE_DATUM, datenschutz_richtlinie);
    console.log("LocalStorage wurde erfolgreich geleert.");
}
