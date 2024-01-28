<?= $this->extend( 'Templates/layout' ); ?>
<?= $this->section( 'navbar' ); ?><?= view( 'Templates/navbar_int' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'werkzeugkasten' ); ?><?= view( 'Templates/werkzeugkasten' ); ?><?= $this->endSection(); ?>
<?= $this->section( 'containers' ); ?>

<div class="container mb-2 text-center element" data-liste="notenbank" data-element_id="<?= $element_id; ?>">
    <?= view( 'Templates/Liste/element_navigation', array( 'element_navigation' => $element_navigation ) ); ?>
    <div class="h5 beschriftung"><span class="eigenschaft" data-eigenschaft="titel"></span></div>
    <div class="row g-0 my-1">
        <div class="col text-nowrap"><span class="eigenschaft" data-eigenschaft="kategorie"></span></div>
    </div>
</div>

<div class="container mb-2">
<?= view( 'Templates/Liste/verzeichnis', array( 'verzeichnis' => $verzeichnis['aktuelles_verzeichnis'] ) ); ?>
</div>

<?php if( auth()->user()->can('notenbank.verwaltung') ) echo view( 'Notenbank/titel_erstellen_modal' ); ?>
<?php if( auth()->user()->can('notenbank.verwaltung') ) echo view( 'Templates/Liste/liste_filtern_modal' ); ?>
<?php if( auth()->user()->can('notenbank.verwaltung') ) echo view( 'Templates/Liste/liste_sortieren_modal' ); ?>
<?php if( auth()->user()->can('notenbank.verwaltung') ) echo view( 'Templates/Liste/loeschen_modal' ); ?>

<?= $this->endSection() ?>

