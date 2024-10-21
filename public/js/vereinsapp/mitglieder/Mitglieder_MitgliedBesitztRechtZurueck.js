function Mitglieder_MitgliedBesitztRechtZurueck(recht, mitglied_id) {
    if (typeof mitglied_id !== "undefined") mitglied_id = Number(mitglied_id);

    let recht_id;
    $.each(LISTEN.verfuegbare_rechte.tabelle, function () {
        const verfuegbares_recht = this;
        if ("id" in verfuegbares_recht && verfuegbares_recht.permission == recht) recht_id = verfuegbares_recht.id;
    });

    let mitglied_besitzt_recht = false;
    $.each(LISTEN.vergebene_rechte.tabelle, function () {
        const vergebenes_recht = this;
        if ("id" in vergebenes_recht && vergebenes_recht.mitglied_id == mitglied_id && vergebenes_recht.verfuegbares_recht_id == recht_id)
            mitglied_besitzt_recht = true;
    });

    return mitglied_besitzt_recht;
}
