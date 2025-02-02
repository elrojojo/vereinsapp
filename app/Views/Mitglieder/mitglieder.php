<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-3">
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['alle_mitglieder'] ) ); ?>
</div>

<?= view( 'Templates/modal', array( 'id' => 'mitglieder_anwesenheiten_dokumentieren', 'modal' =>
    view( 'Templates/Liste/liste', array( 'liste' => $liste['anwesenheiten_dokumentieren'] ) ) ) ); ?>
<?php if( auth()->user()->can( 'mitglieder.verwaltung' ) ) echo
    view( 'Templates/modal', array( 'id' => 'mitglied_basiseigenschaften', 'modal' =>
    view( 'Templates/Liste/formular', array( 'data' => array( 'liste' => 'mitglieder' ), 'btn' => array( 'klasse_id' => 'btn_mitglied_aktion' ), 'formular' =>
    view( 'Mitglieder/mitglied_basiseigenschaften_formular' ) ) ) ) ); ?>
<?php if( auth()->user()->can( 'mitglieder.verwaltung' ) ) echo
    view( 'Templates/modal', array( 'id' => 'mitglieder_einmal_link_anzeigen', 'modal' =>
    view( 'Templates/Liste/formular', array( 'data' => array( 'liste' => 'mitglieder' ), 'btn' => array( 'klasse_id' => 'btn_mitglied_einmal_link_anzeigen', 'beschriftung' => 'Einmal-Link anzeigen' ), 'formular' =>
    view( 'Mitglieder/mitglied_einmal_link_anzeigen_formular' ) ) ) ) ); ?>
<?= $this->endSection() ?>