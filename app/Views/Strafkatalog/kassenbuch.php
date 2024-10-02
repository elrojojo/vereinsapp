<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-3">
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['aktuelles_kassenbuch'] ) ); ?>
</div>

<div class="blanko_modals" data-liste="kassenbuch">
<?php if( auth()->user()->can( 'strafkatalog.verwaltung' ) ) echo view( 'Templates/modal', array( 'modal_id' => 'basiseigenschaften', 'modal_body' => view( 'Strafkatalog/kassenbucheintrag_basiseigenschaften_formular', array( 'data' => array( 'liste' => 'kassenbuch' ) ) ) ) ); ?>
</div>
<?= $this->endSection() ?>