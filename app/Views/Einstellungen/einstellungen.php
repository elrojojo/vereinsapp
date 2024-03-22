<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-2">
    <div class="text-secondary text-center mb-1">Mein Gerät</div>
<?= view( 'Einstellungen/verknuepfung' ); ?>
</div>

<div class="container mb-2">
    <div class="ueberschrift text-secondary text-center invisible mb-1" data-instanz="rechte_vergeben">Meine Rechte</div>
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['rechte_vergeben'] ) ); ?>
</div>

<div class="container mb-2">
    <div class="text-secondary text-center mb-1">Mein Passwort ändern</div>
<?= view( 'Mitglieder/passwort_aendern' ); ?>
</div>

<div class="container mb-2">
    <div class="text-secondary text-center mb-1">Mein LocalStorage</div>
<?= view( 'Einstellungen/localstorage_leeren' ); ?>
</div>
<?= view( 'Einstellungen/localstorage_leeren_modal' ); ?>

<?= $this->endSection() ?>

