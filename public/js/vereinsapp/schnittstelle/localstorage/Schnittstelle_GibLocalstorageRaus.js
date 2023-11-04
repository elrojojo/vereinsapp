function Schnittstelle_GibLocalstorageRaus(schluessel, json) {
    const LocalstorageRaus = localStorage.getItem("vereinsapp_" + schluessel);

    if (LocalstorageRaus === null || LocalstorageRaus == "undefined") LocalstorageRaus = undefined;
    else if (json) LocalstorageRaus = JSON.parse(LocalstorageRaus);

    return LocalstorageRaus;
}
