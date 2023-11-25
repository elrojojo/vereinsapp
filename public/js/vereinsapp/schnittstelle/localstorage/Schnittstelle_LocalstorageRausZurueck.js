function Schnittstelle_LocalstorageRausZurueck(schluessel, json) {
    let LocalstorageRaus = localStorage.getItem("vereinsapp_" + schluessel);
    if (LocalstorageRaus === null || typeof LocalstorageRaus === "undefined") LocalstorageRaus = undefined;

    if (typeof json !== "undefined" && json) {
        if (typeof LocalstorageRaus === "undefined") LocalstorageRaus = [];
        else LocalstorageRaus = JSON.parse(LocalstorageRaus);
    }

    return LocalstorageRaus;
}
