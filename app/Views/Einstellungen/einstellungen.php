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
<?= view( 'Mitglieder/mitglied_passwort_aendern' ); ?>
</div>

<div class="container mb-2">
    <div class="text-secondary text-center mb-1">Mein LocalStorage</div>
<?= view( 'Einstellungen/localstorage_leeren' ); ?>
</div>

<?php if( auth()->user()->can('global.einstellungen') ) { ?>
<div class="container mb-2">
    <div class="text-secondary text-center mb-1">Doppelte Rückmeldungen</div>
<?= view( 'Einstellungen/temp_check_doppelte_rueckmeldungen' ); ?>
</div>

<div class="blanko_modals" data-liste="temp_check_doppelte_rueckmeldungen">
<?= view( 'Einstellungen/temp_check_doppelte_rueckmeldungen_modal', array( 'liste' => $liste ) ); ?>
</div><?php } ?>
<?= $this->endSection() ?>

