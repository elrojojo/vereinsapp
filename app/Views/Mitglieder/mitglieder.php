<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-2">
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['alle_mitglieder'] ) ); ?>
</div>

<div class="blanko_modals" data-liste="mitglieder">
<?php if( auth()->user()->can('mitglieder.verwaltung') ) echo view( 'Mitglieder/mitglied_basiseigenschaften_modal' ); ?>
<?php if( auth()->user()->can('mitglieder.verwaltung') ) echo view( 'Mitglieder/mitglied_einmal_link_anzeigen_modal' ); ?>
</div>
<?= $this->endSection() ?>

