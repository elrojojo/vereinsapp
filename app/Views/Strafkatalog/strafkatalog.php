<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-2">
<?= view( 'Strafkatalog/kassenbuch_oeffnen' ); ?>
</div>

<div class="container mb-2">
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['aktueller_strafkatalog'] ) ); ?>
</div>

<div class="blanko_modals" data-liste="strafkatalog">
<?php if( auth()->user()->can('strafkatalog.verwaltung') ) echo view( 'Strafkatalog/strafe_basiseigenschaften_modal' ); ?>
</div>
<div class="blanko_modals" data-liste="mitglieder">
<?php if( auth()->user()->can('strafkatalog.verwaltung') ) echo view( 'Templates/Liste/liste_modal', array( 'liste' => $liste['mitglieder_auswahl'] ) ); ?>
</div>
<?= $this->endSection() ?>

