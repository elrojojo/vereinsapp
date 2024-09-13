<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-3">
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['aktuelles_kassenbuch'] ) ); ?>
</div>

<div class="blanko_modals" data-liste="kassenbuch">
<?php if( auth()->user()->can('strafkatalog.verwaltung') ) echo view( 'Strafkatalog/kassenbucheintrag_basiseigenschaften_modal' ); ?>
</div>
<?= $this->endSection() ?>

