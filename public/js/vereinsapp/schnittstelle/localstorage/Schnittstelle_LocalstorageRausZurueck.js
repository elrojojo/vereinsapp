function Schnittstelle_LocalstorageRausZurueck(schluessel) {
    let LocalstorageRaus = localStorage.getItem("vereinsapp_" + schluessel);
    if (LocalstorageRaus === null) LocalstorageRaus = undefined;
    else if (isJson(LocalstorageRaus)) LocalstorageRaus = JSON.parse(LocalstorageRaus);

    return LocalstorageRaus;
}
