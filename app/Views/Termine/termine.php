<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-3">
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['bevorstehende_termine'] ) ); ?>
</div>

<div class="blanko_modals" data-liste="termine">
<?php if( auth()->user()->can( 'termine.verwaltung' ) ) echo view( 'Templates/modal', array( 'modal_id' => 'basiseigenschaften', 'modal_body' => view( 'Termine/termin_basiseigenschaften_formular', array( 'data' => array( 'liste' => 'termine' ) ) ) ) ); ?>
<?= view( 'Templates/Liste/liste_modal', array( 'liste' => $liste['anwesenheiten_dokumentieren'] ) ); ?>
</div>
<?= $this->endSection() ?>