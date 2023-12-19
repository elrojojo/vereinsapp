<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'werkzeugkasten' ); ?><?= view( 'Templates/werkzeugkasten' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-2">
<?= view( 'Templates/Liste/liste', array( 'liste' => $liste['bevorstehende_termine'] ) ); ?>
</div>

<?= view( 'Termine/rueckmeldung_detaillieren_modal' ); ?>
<?php if( auth()->user()->can('termine.verwaltung') ) echo view( 'Termine/termin_erstellen_modal' ); ?>
<?php if( auth()->user()->can('termine.verwaltung') ) echo view( 'Templates/Liste/loeschen_modal' ); ?>
<?= view( 'Templates/Liste/liste_filtern_modal' ); ?>
<?= view( 'Templates/Liste/liste_sortieren_modal' ); ?>
<?= $this->endSection() ?>

