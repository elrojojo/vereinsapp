<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-3">
    <div class="text-secondary text-center mb-1">Mein Gerät</div>
<?= view( 'Einstellungen/verknuepfung' ); ?>
</div>

<div class="container mb-3">
    <div class="text-secondary text-center mb-1">Meine Daten</div>
<?= view( 'Mitglieder/mitglied_basiseigenschaften' ); ?>
</div>

<div class="container mb-3">
    <div class="ueberschrift text-secondary text-center invisible mb-1" data-instanz="rechte_vergeben">Meine Rechte</div>
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['rechte_vergeben'] ) ); ?>
</div>

<div class="container mb-3">
    <div class="text-secondary text-center mb-1">Mein Passwort</div>
<?= view( 'Mitglieder/mitglied_passwort_aendern' ); ?>
</div>

<div class="container mb-3">
    <div class="text-secondary text-center mb-1">Mein LocalStorage</div>
<?= view( 'Einstellungen/localstorage_leeren' ); ?>
</div>
<?= $this->endSection() ?>

