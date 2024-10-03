<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-3">
<?= view( 'Strafkatalog/kassenbuch_oeffnen' ); ?>
</div>

<div class="container mb-3">
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['aktueller_strafkatalog'] ) ); ?>
</div>

<div class="blanko_modals">
<?php if( auth()->user()->can( 'strafkatalog.verwaltung' ) ) echo
        view( 'Templates/modal', array( 'modal_id' => 'strafkatalog_basiseigenschaften', 'modal' =>
        view( 'Templates/Liste/formular', array( 'data' => array( 'liste' => 'strafkatalog', 'aktion' => 'aendern' ), 'btn' => array( 'klasse_id' => 'btn_strafe_aktion' ), 'formular' =>
        view( 'Strafkatalog/strafe_basiseigenschaften_formular' ) ) ) ) ); ?>
<?php if( auth()->user()->can( 'strafkatalog.verwaltung' ) ) echo
        view( 'Templates/modal', array( 'modal_id' => 'mitglieder_auswahl', 'modal' =>
        view( 'Templates/Liste/liste', array( 'liste' => $liste['mitglieder_auswahl'] ) ) ) ); ?>
</div>
<?= $this->endSection() ?>