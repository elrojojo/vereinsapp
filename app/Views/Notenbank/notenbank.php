<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-3">
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['aktuelles_verzeichnis'] ) ); ?>
</div>

<div class="blanko_modals" data-liste="notenbank">
<?php if( auth()->user()->can('notenbank.verwaltung') ) echo view( 'Notenbank/titel_basiseigenschaften_modal' ); ?>
</div>
<?= $this->endSection() ?>

