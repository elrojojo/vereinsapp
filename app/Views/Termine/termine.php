<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-3">
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['bevorstehende_termine'] ) ); ?>
</div>

<div class="blanko_modals" data-liste="termine">
<?php if( auth()->user()->can('termine.verwaltung') ) echo view( 'Termine/termin_basiseigenschaften_modal' ); ?>
<?= view( 'Templates/Liste/liste_modal', array( 'liste' => $liste['anwesenheiten_dokumentieren'] ) ); ?>
</div>
<?= $this->endSection() ?>

