<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-3">
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['aktuelle_umfragen'] ) ); ?>
</div>

<?php if( auth()->user()->can( 'umfragen.verwaltung' ) ) echo
        view( 'Templates/modal', array( 'id' => 'umfrage_basiseigenschaften', 'modal' =>
        view( 'Templates/Liste/formular', array( 'data' => array( 'liste' => 'umfragen' ), 'btn' => array( 'klasse_id' => 'btn_umfrage_aktion' ), 'formular' =>
        view( 'Umfragen/umfrage_basiseigenschaften_formular' ) ) ) ) ); ?>
<?= $this->endSection() ?>