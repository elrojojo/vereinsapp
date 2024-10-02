<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-3">
<?= view( 'Einstellungen/verknuepfung' ); ?>
</div>

<div class="container mb-3">
    <div class="text-secondary text-center mb-1"><hr>Meine Daten</div>
<?= view( 'Mitglieder/mitglied_basiseigenschaften_formular', array( 'data' => array( 'liste' => 'mitglieder', 'aktion' => 'aendern', 'element_id' => ICH['id'] ), 'btn_beschriftung' => 'Meine Daten speichern' ) ); ?>
</div>

<div class="container mb-3">
    <div class="ueberschrift text-secondary text-center invisible mb-1" data-instanz="rechte_vergeben"><hr>Meine Rechte</div>
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['rechte_vergeben'] ) ); ?>
</div>

<div class="container mb-3">
    <div class="text-secondary text-center mb-1"><hr>Mein Passwort</div>
<?= view( 'Mitglieder/mitglied_passwort_aendern_formular', array( 'data' => array( 'liste' => 'mitglieder', 'element_id' => ICH['id'] ), 'btn_beschriftung' => 'Mein Passwort ändern' ) ); ?>
</div>

<div class="container mb-3">
    <div class="text-secondary text-center mb-1"><hr>Mein LocalStorage</div>
<?= view( 'Einstellungen/localstorage_leeren' ); ?>
</div>
<?= $this->endSection() ?>