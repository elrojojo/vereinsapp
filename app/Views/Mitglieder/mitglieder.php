<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-3">
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['alle_mitglieder'] ) ); ?>
</div>

<div class="blanko_modals" data-liste="mitglieder">
<?php if( auth()->user()->can( 'mitglieder.verwaltung' ) ) echo view( 'Templates/modal', array( 'modal_id' => 'basiseigenschaften', 'modal_body' => view( 'Mitglieder/mitglied_basiseigenschaften_formular', array( 'data' => array( 'liste' => 'mitglieder' ) ) ) ) ); ?>
<?php if( auth()->user()->can( 'mitglieder.verwaltung' ) ) echo view( 'Templates/modal', array( 'modal_id' => 'einmal_link_anzeigen', 'modal_body' => view( 'Mitglieder/mitglied_einmal_link_anzeigen_formular', array( 'data' => array( 'liste' => 'mitglieder' ), 'btn_beschriftung' => 'Einmal-Link anzeigen' ) ) ) ); ?>
<?= view( 'Templates/Liste/liste_modal', array( 'liste' => $liste['anwesenheiten_dokumentieren'] ) ); ?>
</div>

<div class="blanko_modals" data-liste="strafkatalog">
<?php if( array_key_exists( 'strafkatalog.verwaltung' , VERFUEGBARE_RECHTE ) AND auth()->user()->can( 'strafkatalog.verwaltung' ) ) echo view( 'Templates/Liste/liste_modal', array( 'liste' => $liste['strafkatalog_auswahl'] ) ); ?>
</div>
<?= $this->endSection() ?>