<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-3">
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['bevorstehende_termine'] ) ); ?>
</div>

<?php if( auth()->user()->can( 'termine.verwaltung' ) ) echo
        view( 'Templates/modal', array( 'modal_id' => 'termine_basiseigenschaften', 'modal' =>
        view( 'Templates/Liste/formular', array( 'data' => array( 'liste' => 'termine', 'aktion' => 'aendern' ), 'btn' => array( 'klasse_id' => 'btn_termin_aktion' ), 'formular' =>
        view( 'Termine/termin_basiseigenschaften_formular' ) ) ) ) ); ?>
<?= view( 'Templates/modal', array( 'modal_id' => 'termine_anwesenheiten_dokumentieren', 'modal' =>
    view( 'Templates/Liste/liste', array( 'liste' => $liste['anwesenheiten_dokumentieren'] ) ) ) ); ?>
<?= $this->endSection() ?>