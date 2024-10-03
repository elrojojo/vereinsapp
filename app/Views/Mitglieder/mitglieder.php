<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-3">
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['alle_mitglieder'] ) ); ?>
</div>

<div class="blanko_modals" data-liste="mitglieder">
<?php if( auth()->user()->can( 'mitglieder.verwaltung' ) ) echo
        view( 'Templates/modal', array( 'modal_id' => 'basiseigenschaften', 'modal' =>
        view( 'Templates/Liste/formular', array( 'data' => array( 'liste' => 'mitglieder', 'aktion' => 'aendern' ), 'btn' => array( 'klasse_id' => 'btn_mitglied_aktion' ), 'formular' =>
        view( 'Mitglieder/mitglied_basiseigenschaften_formular' ) ) ) ) ); ?>
<?php if( auth()->user()->can( 'mitglieder.verwaltung' ) ) echo
        view( 'Templates/modal', array( 'modal_id' => 'einmal_link_anzeigen', 'modal' =>
        view( 'Templates/Liste/formular', array( 'data' => array( 'liste' => 'mitglieder' ), 'btn' => array( 'klasse_id' => 'btn_mitglied_einmal_link_anzeigen', 'beschriftung' => 'Einmal-Link anzeigen' ), 'formular' =>
        view( 'Mitglieder/mitglied_einmal_link_anzeigen_formular' ) ) ) ) ); ?>
<?= view( 'Templates/modal', array( 'modal_id' => 'anwesenheiten_dokumentieren', 'modal' =>
    view( 'Templates/Liste/liste', array( 'liste' => $liste['anwesenheiten_dokumentieren'] ) ) ) ); ?>
</div>

<div class="blanko_modals" data-liste="strafkatalog">
<?php if( array_key_exists( 'strafkatalog.verwaltung' , VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'strafkatalog.verwaltung' ) ) echo
        view( 'Templates/modal', array( 'modal_id' => 'strafkatalog_auswahl', 'modal' =>
        view( 'Templates/Liste/liste', array( 'liste' => $liste['strafkatalog_auswahl'] ) ) ) ); ?>
</div>
<?= $this->endSection() ?>