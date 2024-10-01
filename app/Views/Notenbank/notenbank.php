<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<?php if( NOTENBANK_VERZEICHNIS != NULL AND !empty(NOTENBANK_VERZEICHNIS) ) { ?><div class="container mb-3">
<?= view( 'Notenbank/verzeichnis_oeffnen' ); ?>
</div><?php } ?>

<div class="container mb-3">
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['aktuelles_verzeichnis'] ) ); ?>
</div>

<div class="blanko_modals" data-liste="notenbank">
<?php if( auth()->user()->can('notenbank.verwaltung') ) echo view( 'Templates/modal', array( 'modal_id' => 'basiseigenschaften', 'modal_body' => view( 'Notenbank/titel_basiseigenschaften_formular', array( 'data' => array( 'liste' => 'notenbank' ) ) ) ) ); ?>
</div>
<?= $this->endSection() ?>

