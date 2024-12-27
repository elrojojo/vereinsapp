function Aufgaben_AufgabeZugeordnetesElementLoeschen(dom) {
    if ("$formular" in dom && dom.$formular.exists()) {
        const $zugeordnete_liste = dom.$formular.find('.eingabe[data-eingabe="zugeordnete_liste"]');

        $zugeordnete_liste.val(null);
        if (
            "change_aktion" in EIGENSCHAFTEN.aufgaben.zugeordnete_liste &&
            typeof EIGENSCHAFTEN.aufgaben.zugeordnete_liste.change_aktion === "function"
        )
            EIGENSCHAFTEN.aufgaben.zugeordnete_liste.change_aktion($zugeordnete_liste);
    }
}
