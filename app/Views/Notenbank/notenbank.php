<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-2">
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['aktuelles_verzeichnis'] ) ); ?>
</div>

<?php if( auth()->user()->can('notenbank.verwaltung') ) echo view( 'Notenbank/titel_erstellen_modal' ); ?>
<?= $this->endSection() ?>

